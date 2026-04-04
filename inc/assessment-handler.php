<?php
/**
 * Assessment Form Handler — Page Reload (PRG pattern)
 *
 * Security layers (in order of execution):
 *  1. WordPress nonce           — CSRF protection
 *  2. Honeypot field            — silent bot trap (zero user friction)
 *  3. reCAPTCHA v3              — Google AI spam scoring
 *  4. IP rate limiting          — max 5 submissions per hour per IP
 *  5. Full server-side validation — never trust the client
 *
 * Flow: POST → validate → save to custom DB table → PRG redirect to GET
 *
 * @package mindful-insights-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}


// ═════════════════════════════════════════════════════════════════════════════
// MAIN HANDLER
// ═════════════════════════════════════════════════════════════════════════════

/**
 * Hooked to template_redirect — fires before any output so wp_redirect() works.
 */
function mit_handle_assessment_form_submit() {

	// Only run on single assessment pages with a real POST.
	if ( ! is_singular( 'assessment' )  ) {
		return;
	}
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( empty( $_POST['mit_submit_assessment'] ) ) {
		return;
	}

	// ─────────────────────────────────────────────────────────────────────────
	// LAYER 1 — WordPress Nonce (CSRF protection)
	// ─────────────────────────────────────────────────────────────────────────
	$nonce = isset( $_POST['mit_assessment_nonce'] )
		? sanitize_text_field( wp_unslash( $_POST['mit_assessment_nonce'] ) )
		: '';

	if ( ! wp_verify_nonce( $nonce, 'mit_assessment_submit' ) ) {
		mit_security_die( 'নিরাপত্তা যাচাই ব্যর্থ হয়েছে। অনুগ্রহ করে পেজটি রিলোড করে আবার চেষ্টা করুন।', 403 );
	}

	// ─────────────────────────────────────────────────────────────────────────
	// LAYER 2 — Honeypot (silent bot trap)
	// Bots fill every visible and hidden field. Humans never touch this.
	// ─────────────────────────────────────────────────────────────────────────
	$honeypot = isset( $_POST['mit_hp_field'] ) ? $_POST['mit_hp_field'] : null;
	if ( null === $honeypot ) {
		// Field not present at all — likely a direct POST without loading the page.
		mit_security_die( 'অবৈধ অনুরোধ।', 400 );
	}
	if ( '' !== $honeypot ) {
		// Field was filled by a bot.
		mit_security_die( 'অবৈধ অনুরোধ।', 400 );
	}

	// ─────────────────────────────────────────────────────────────────────────
	// LAYER 3 — reCAPTCHA v3
	// ─────────────────────────────────────────────────────────────────────────
	$recaptcha_token = isset( $_POST['recaptcha_token'] )
		? sanitize_text_field( wp_unslash( $_POST['recaptcha_token'] ) )
		: '';

	$recaptcha_result = mit_verify_recaptcha( $recaptcha_token );

	if ( ! $recaptcha_result['passed'] ) {
		mit_security_die(
			sprintf(
				'reCAPTCHA যাচাই ব্যর্থ হয়েছে (%s)। অনুগ্রহ করে আবার চেষ্টা করুন।',
				esc_html( $recaptcha_result['reason'] )
			),
			403
		);
	}

	// ─────────────────────────────────────────────────────────────────────────
	// LAYER 4 — IP Rate Limiting (max 5 per hour per IP)
	// ─────────────────────────────────────────────────────────────────────────
	if ( ! mit_check_rate_limit() ) {
		mit_security_die(
			'আপনি অল্প সময়ের মধ্যে অনেকবার ফর্ম জমা দিয়েছেন। অনুগ্রহ করে ১ ঘণ্টা পরে আবার চেষ্টা করুন।',
			429
		);
	}

	// ─────────────────────────────────────────────────────────────────────────
	// LAYER 5 — Full server-side validation
	// ─────────────────────────────────────────────────────────────────────────

	// Assessment ID.
	$assessment_id = absint( $_POST['assessment_id'] ?? 0 );
	if ( ! $assessment_id || 'assessment' !== get_post_type( $assessment_id ) ) {
		mit_security_die( 'অবৈধ মূল্যায়ন আইডি।', 400 );
	}

	// Sanitize visitor fields.
	$visitor_name  = sanitize_text_field( wp_unslash( $_POST['visitor_name']  ?? '' ) );
	$visitor_age   = sanitize_text_field( wp_unslash( $_POST['visitor_age']   ?? '' ) );
	$visitor_job   = sanitize_text_field( wp_unslash( $_POST['visitor_job']   ?? '' ) );
	$visitor_phone = sanitize_text_field( wp_unslash( $_POST['visitor_phone'] ?? '' ) );
	$visitor_email = sanitize_email( wp_unslash( $_POST['visitor_email']      ?? '' ) );

	$errors = array();
	if ( empty( $visitor_name ) )  $errors[] = 'নাম প্রয়োজন।';
	if ( empty( $visitor_age ) )   $errors[] = 'বয়স প্রয়োজন।';
	if ( empty( $visitor_job ) )   $errors[] = 'পেশা প্রয়োজন।';
	if ( empty( $visitor_phone ) ) $errors[] = 'ফোন নম্বর প্রয়োজন।';
	if ( ! empty( $visitor_email ) && ! is_email( $visitor_email ) ) {
		$errors[] = 'সঠিক ইমেইল ঠিকানা দিন।';
	}

	$raw_answers = ( isset( $_POST['answers'] ) && is_array( $_POST['answers'] ) )
		? $_POST['answers']
		: array();

	$questions = function_exists( 'carbon_get_post_meta' )
		? carbon_get_post_meta( $assessment_id, 'mit_assessment_questions' )
		: array();

	if ( empty( $questions ) ) {
		mit_security_die( 'এই মূল্যায়নে কোনো প্রশ্ন নেই।', 400 );
	}

	if ( count( $raw_answers ) < count( $questions ) ) {
		$errors[] = 'সমস্ত প্রশ্নের উত্তর দিন।';
	}

	// Redirect back with errors if validation fails.
	if ( ! empty( $errors ) ) {
		$error_token = bin2hex( random_bytes( 10 ) );
		set_transient(
			'mit_form_errors_' . $error_token,
			array(
				'errors'   => $errors,
				'old_data' => compact( 'visitor_name', 'visitor_age', 'visitor_job', 'visitor_phone', 'visitor_email' ),
			),
			5 * MINUTE_IN_SECONDS
		);
		wp_redirect( add_query_arg( 'form_errors', $error_token, get_permalink( $assessment_id ) ) );
		exit;
	}

	// ─── Score calculation (server-side only — scores from Carbon Fields DB) ──
	$total_score    = 0;
	$answers_detail = array();

	foreach ( $questions as $q_index => $question ) {
		$opt_index = isset( $raw_answers[ $q_index ] ) ? absint( $raw_answers[ $q_index ] ) : null;

		if ( null === $opt_index || ! isset( $question['options'][ $opt_index ] ) ) {
			mit_security_die( 'অবৈধ উত্তর তথ্য।', 400 );
		}

		$opt          = $question['options'][ $opt_index ];
		$score        = intval( $opt['option_score'] );
		$total_score += $score;

		$answers_detail[] = array(
			'question' => sanitize_text_field( $question['question_text'] ),
			'chosen'   => sanitize_text_field( $opt['option_text'] ),
			'score'    => $score,
		);
	}

	// ─── Match score range ───────────────────────────────────────────────────
	$score_ranges = function_exists( 'carbon_get_post_meta' )
		? carbon_get_post_meta( $assessment_id, 'mit_assessment_score_ranges' )
		: array();

	$result_title = '';
	$result_desc  = '';

	foreach ( (array) $score_ranges as $range ) {
		if (
			$total_score >= intval( $range['min_score'] ) &&
			$total_score <= intval( $range['max_score'] )
		) {
			$result_title = sanitize_text_field( $range['result_title'] );
			$result_desc  = wp_kses_post( $range['result_description'] );
			break;
		}
	}

	if ( empty( $result_title ) ) {
		$result_title = 'ফলাফল পাওয়া যায়নি';
		$result_desc  = 'আপনার স্কোর কোনো নির্ধারিত পরিসরে পড়েনি। অনুগ্রহ করে বিশেষজ্ঞের সাথে যোগাযোগ করুন।';
	}

	$assessment_title = get_the_title( $assessment_id );

	// ─── Save to custom DB table ─────────────────────────────────────────────
	mit_insert_assessment_submission( array(
		'assessment_id'      => $assessment_id,
		'assessment_title'   => $assessment_title,
		'visitor_name'       => $visitor_name,
		'visitor_age'        => $visitor_age,
		'visitor_job'        => $visitor_job,
		'visitor_phone'      => $visitor_phone,
		'visitor_email'      => $visitor_email,
		'total_score'        => $total_score,
		'result_title'       => $result_title,
		'result_description' => $result_desc,
		'answers'            => $answers_detail,
	) );

	// ─── Send email if provided ──────────────────────────────────────────────
	if ( ! empty( $visitor_email ) && is_email( $visitor_email ) ) {
		mit_send_assessment_result_email(
			$visitor_email,
			$visitor_name,
			$assessment_title,
			$total_score,
			$result_title,
			$result_desc
		);
	}

	// ─── PRG redirect with result token ─────────────────────────────────────
	$result_token = bin2hex( random_bytes( 16 ) );
	set_transient(
		'mit_result_' . $result_token,
		array(
			'visitor_name' => $visitor_name,
			'assessment'   => $assessment_title,
			'total_score'  => $total_score,
			'result_title' => $result_title,
			'result_desc'  => $result_desc,
		),
		HOUR_IN_SECONDS
	);

	wp_redirect( add_query_arg( 'result_token', $result_token, get_permalink( $assessment_id ) ) );
	exit;
}
add_action( 'template_redirect', 'mit_handle_assessment_form_submit' );


// ═════════════════════════════════════════════════════════════════════════════
// SECURITY HELPERS
// ═════════════════════════════════════════════════════════════════════════════

/**
 * Centralized security failure handler.
 * Logs the event and terminates with a user-friendly Bengali message.
 *
 * @param string $message Message shown to user.
 * @param int    $code    HTTP response code (403, 400, 429).
 */
function mit_security_die( $message, $code = 403 ) {
	// Log for admin awareness (visible in WP_DEBUG_LOG).
	if ( defined( 'WP_DEBUG_LOG' ) && WP_DEBUG_LOG ) {
		$ip = isset( $_SERVER['REMOTE_ADDR'] ) ? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) ) : 'unknown';
		// phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log
		error_log( sprintf( '[MIT Assessment Security] %s — IP: %s — Code: %d', $message, $ip, $code ) );
	}
	wp_die( esc_html( $message ), 'Security Check', array( 'response' => $code, 'back_link' => true ) );
}


/**
 * Verifies a reCAPTCHA v3 token with Google's siteverify API.
 *
 * Returns an array: ['passed' => bool, 'reason' => string]
 *
 * Behaviour:
 *  - If secret key is NOT configured → passes (graceful, pre-setup).
 *  - If secret key IS configured → token is REQUIRED and must pass all checks.
 *
 * Checks performed:
 *  1. Token present and non-empty.
 *  2. Google API returns success.
 *  3. Score >= configured threshold (default 0.5).
 *  4. Action name matches expected value (anti-token-reuse).
 *  5. Token hostname matches the site (anti-cross-site-replay).
 *
 * @param string $token  The recaptcha_token POSTed by the browser.
 * @param string $action The action name used in grecaptcha.execute().
 * @return array { passed: bool, reason: string }
 */
function mit_verify_recaptcha( $token, $action = 'assessment_submit' ) {
	$secret_key = function_exists( 'carbon_get_theme_option' )
		? (string) carbon_get_theme_option( 'mit_recaptcha_secret_key' )
		: '';

	// Not configured → skip (graceful pre-setup mode).
	if ( empty( trim( $secret_key ) ) ) {
		return array( 'passed' => true, 'reason' => 'not_configured' );
	}

	// Secret key configured but no token — direct POST attack.
	if ( empty( $token ) ) {
		return array( 'passed' => false, 'reason' => 'missing_token' );
	}

	// Call Google API.
	$response = wp_remote_post(
		'https://www.google.com/recaptcha/api/siteverify',
		array(
			'timeout'    => 10,
			'user-agent' => 'WordPress/' . get_bloginfo( 'version' ) . '; ' . home_url(),
			'body'       => array(
				'secret'   => $secret_key,
				'response' => $token,
				'remoteip' => isset( $_SERVER['REMOTE_ADDR'] )
					? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
					: '',
			),
		)
	);

	if ( is_wp_error( $response ) ) {
		return array( 'passed' => false, 'reason' => 'api_error: ' . $response->get_error_message() );
	}

	$data = json_decode( wp_remote_retrieve_body( $response ), true );

	if ( empty( $data ) || ! is_array( $data ) ) {
		return array( 'passed' => false, 'reason' => 'invalid_api_response' );
	}

	// Check 1 — Google success flag.
	if ( empty( $data['success'] ) ) {
		$codes = implode( ', ', (array) ( $data['error-codes'] ?? array() ) );
		return array( 'passed' => false, 'reason' => 'google_rejected: ' . $codes );
	}

	// Check 2 — Score threshold.
	$threshold = function_exists( 'carbon_get_theme_option' )
		? floatval( carbon_get_theme_option( 'mit_recaptcha_threshold' ) )
		: 0.5;
	if ( $threshold <= 0 || $threshold > 1 ) {
		$threshold = 0.5;
	}

	$score = isset( $data['score'] ) ? floatval( $data['score'] ) : 0.0;
	if ( $score < $threshold ) {
		return array( 'passed' => false, 'reason' => sprintf( 'low_score: %.2f < %.2f', $score, $threshold ) );
	}

	// Check 3 — Action name must match (prevents reusing tokens from other forms).
	if ( ! isset( $data['action'] ) || $data['action'] !== $action ) {
		return array( 'passed' => false, 'reason' => 'action_mismatch: ' . ( $data['action'] ?? 'none' ) );
	}

	// Check 4 — Hostname must match the site (prevents cross-site token replay).
	if ( ! empty( $data['hostname'] ) ) {
		$expected_host = wp_parse_url( home_url(), PHP_URL_HOST );
		$expected_host = ltrim( $expected_host ?? '', 'www.' );
		$token_host    = ltrim( $data['hostname'], 'www.' );

		if ( $token_host !== $expected_host ) {
			return array( 'passed' => false, 'reason' => 'hostname_mismatch: ' . $data['hostname'] );
		}
	}

	return array( 'passed' => true, 'reason' => sprintf( 'ok: score=%.2f', $score ) );
}


/**
 * Checks IP-based rate limiting.
 * Allows at most 5 successful submissions per IP per hour.
 *
 * Uses a WordPress transient keyed by an MD5 of the IP (for privacy).
 *
 * @return bool True if within limit, false if limit exceeded.
 */
function mit_check_rate_limit() {
	$ip  = isset( $_SERVER['REMOTE_ADDR'] )
		? sanitize_text_field( wp_unslash( $_SERVER['REMOTE_ADDR'] ) )
		: 'unknown';

	// Use MD5 of IP so raw IPs are not stored in options table.
	$key   = 'mit_rl_' . md5( $ip );
	$limit = 5; // Max submissions per window.
	$count = (int) get_transient( $key );

	if ( $count >= $limit ) {
		return false;
	}

	// Increment. On first call, set a 1-hour window.
	set_transient( $key, $count + 1, HOUR_IN_SECONDS );

	return true;
}


// ═════════════════════════════════════════════════════════════════════════════
// EMAIL
// ═════════════════════════════════════════════════════════════════════════════

/**
 * Sends the result email to the visitor.
 *
 * @param string $to              Recipient email.
 * @param string $visitor_name    Visitor name.
 * @param string $assessment_name Assessment title.
 * @param int    $total_score     Calculated total score.
 * @param string $result_title    Matched result title.
 * @param string $result_desc     Matched result description (HTML).
 */
function mit_send_assessment_result_email( $to, $visitor_name, $assessment_name, $total_score, $result_title, $result_desc ) {
	$site_name  = get_bloginfo( 'name' );
	$admin_mail = get_option( 'admin_email' );
	$subject    = sprintf( '[%s] আপনার মূল্যায়নের ফলাফল: %s', $site_name, $assessment_name );

	$message  = '<html><body style="font-family:Arial,sans-serif;color:#333;max-width:600px;margin:0 auto;">';
	$message .= '<h2 style="color:#2563eb;">আপনার মূল্যায়নের ফলাফল</h2>';
	$message .= '<table style="width:100%;border-collapse:collapse;margin-bottom:20px;">';
	$message .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">নাম</td><td style="padding:8px;border:1px solid #ddd;">' . esc_html( $visitor_name ) . '</td></tr>';
	$message .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">মূল্যায়ন</td><td style="padding:8px;border:1px solid #ddd;">' . esc_html( $assessment_name ) . '</td></tr>';
	$message .= '<tr><td style="padding:8px;border:1px solid #ddd;font-weight:bold;">মোট স্কোর</td><td style="padding:8px;border:1px solid #ddd;"><strong>' . intval( $total_score ) . '</strong></td></tr>';
	$message .= '</table>';
	$message .= '<div style="background:#eff6ff;border-left:4px solid #2563eb;padding:16px;border-radius:8px;margin-bottom:16px;">';
	$message .= '<h3 style="margin:0 0 8px;color:#2563eb;">' . esc_html( $result_title ) . '</h3>';
	$message .= '<div>' . wp_kses_post( $result_desc ) . '</div>';
	$message .= '</div>';
	$message .= '<p style="color:#888;font-size:12px;">এই ইমেইলটি ' . esc_html( $site_name ) . ' থেকে স্বয়ংক্রিয়ভাবে পাঠানো হয়েছে।</p>';
	$message .= '</body></html>';

	wp_mail(
		$to,
		$subject,
		$message,
		array(
			'Content-Type: text/html; charset=UTF-8',
			'From: ' . $site_name . ' <' . $admin_mail . '>',
		)
	);
}
