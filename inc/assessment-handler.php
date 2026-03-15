<?php
/**
 * Assessment Form Handler — Page Reload (PRG pattern)
 *
 * Hooks into `template_redirect` to process POST submissions on single
 * assessment pages. Validates the nonce, sanitizes all inputs, calculates
 * the score server-side from Carbon Fields data, saves to the custom DB
 * table, then redirects (POST → redirect → GET) to prevent double-submits.
 *
 * @package mindful-insights-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Main handler — hooked to template_redirect.
 * Fires early enough to call wp_redirect() before any output.
 */
function mit_handle_assessment_form_submit() {

	// Only run on single assessment pages with a POST request.
	if ( ! is_singular( 'assessment' ) ) {
		return;
	}
	if ( 'POST' !== strtoupper( $_SERVER['REQUEST_METHOD'] ?? '' ) ) {
		return;
	}
	if ( empty( $_POST['mit_submit_assessment'] ) ) {
		return;
	}

	// ── 1. Nonce check ─────────────────────────────────────────────────────
	$nonce = isset( $_POST['mit_assessment_nonce'] ) ? sanitize_text_field( wp_unslash( $_POST['mit_assessment_nonce'] ) ) : '';
	if ( ! wp_verify_nonce( $nonce, 'mit_assessment_submit' ) ) {
		wp_die(
			'নিরাপত্তা যাচাই ব্যর্থ হয়েছে। অনুগ্রহ করে আবার চেষ্টা করুন।',
			'Security Error',
			array( 'response' => 403, 'back_link' => true )
		);
	}

	// ── 2. Assessment ID ────────────────────────────────────────────────────
	$assessment_id = absint( $_POST['assessment_id'] ?? 0 );
	if ( ! $assessment_id || 'assessment' !== get_post_type( $assessment_id ) ) {
		wp_die( 'অবৈধ মূল্যায়ন।', 'Error', array( 'response' => 400, 'back_link' => true ) );
	}

	// ── 3. Sanitize visitor fields ──────────────────────────────────────────
	$visitor_name  = sanitize_text_field( wp_unslash( $_POST['visitor_name']  ?? '' ) );
	$visitor_age   = sanitize_text_field( wp_unslash( $_POST['visitor_age']   ?? '' ) );
	$visitor_job   = sanitize_text_field( wp_unslash( $_POST['visitor_job']   ?? '' ) );
	$visitor_phone = sanitize_text_field( wp_unslash( $_POST['visitor_phone'] ?? '' ) );
	$visitor_email = sanitize_email( wp_unslash( $_POST['visitor_email']      ?? '' ) );

	// ── 4. Validate required fields ─────────────────────────────────────────
	$errors = array();
	if ( empty( $visitor_name ) )  $errors[] = 'নাম প্রয়োজন।';
	if ( empty( $visitor_age ) )   $errors[] = 'বয়স প্রয়োজন।';
	if ( empty( $visitor_job ) )   $errors[] = 'পেশা প্রয়োজন।';
	if ( empty( $visitor_phone ) ) $errors[] = 'ফোন নম্বর প্রয়োজন।';

	$raw_answers = ( isset( $_POST['answers'] ) && is_array( $_POST['answers'] ) )
		? $_POST['answers']
		: array();

	$questions = function_exists( 'carbon_get_post_meta' )
		? carbon_get_post_meta( $assessment_id, 'mit_assessment_questions' )
		: array();

	if ( empty( $questions ) ) {
		wp_die( 'এই মূল্যায়নে কোনো প্রশ্ন নেই।', 'Error', array( 'response' => 400, 'back_link' => true ) );
	}

	if ( count( $raw_answers ) < count( $questions ) ) {
		$errors[] = 'সমস্ত প্রশ্নের উত্তর দিন।';
	}

	// ── 5. On validation errors: redirect back with errors in transient ──────
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

	// ── 6. Calculate score (server-side only — never trust submitted scores) ─
	$total_score    = 0;
	$answers_detail = array();

	foreach ( $questions as $q_index => $question ) {
		$opt_index = isset( $raw_answers[ $q_index ] ) ? absint( $raw_answers[ $q_index ] ) : null;

		if ( null === $opt_index || ! isset( $question['options'][ $opt_index ] ) ) {
			wp_die( 'অবৈধ উত্তর তথ্য।', 'Error', array( 'response' => 400, 'back_link' => true ) );
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

	// ── 7. Match score range ────────────────────────────────────────────────
	$score_ranges = function_exists( 'carbon_get_post_meta' )
		? carbon_get_post_meta( $assessment_id, 'mit_assessment_score_ranges' )
		: array();

	$result_title = '';
	$result_desc  = '';

	foreach ( (array) $score_ranges as $range ) {
		if ( $total_score >= intval( $range['min_score'] ) && $total_score <= intval( $range['max_score'] ) ) {
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

	// ── 8. Save to custom DB table ──────────────────────────────────────────
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

	// ── 9. Send email if provided ────────────────────────────────────────────
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

	// ── 10. PRG: store result in transient, redirect to GET ──────────────────
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


/**
 * Sends the result email to the visitor.
 *
 * @param string $to              Email address.
 * @param string $visitor_name    Visitor name.
 * @param string $assessment_name Name of the assessment.
 * @param int    $total_score     Final score.
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
