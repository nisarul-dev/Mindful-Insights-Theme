<?php
/**
 * Assessment Custom Database Table
 *
 * Handles the creation of and CRUD operations for the
 * `{prefix}mit_assessment_submissions` table.
 *
 * @package mindful-insights-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Creates the custom submissions table using dbDelta.
 * Safe to call multiple times — only creates if not already present.
 */
function mit_create_assessment_submissions_table() {
	global $wpdb;

	$table_name      = $wpdb->prefix . 'mit_assessment_submissions';
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS {$table_name} (
		id            BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
		assessment_id BIGINT(20) UNSIGNED NOT NULL,
		assessment_title VARCHAR(255)  NOT NULL DEFAULT '',
		visitor_name  VARCHAR(150)  NOT NULL DEFAULT '',
		visitor_age   VARCHAR(20)   NOT NULL DEFAULT '',
		visitor_job   VARCHAR(150)  NOT NULL DEFAULT '',
		visitor_phone VARCHAR(30)   NOT NULL DEFAULT '',
		visitor_email VARCHAR(150)  NOT NULL DEFAULT '',
		total_score   INT(11)       NOT NULL DEFAULT 0,
		result_title  VARCHAR(255)  NOT NULL DEFAULT '',
		result_description LONGTEXT NOT NULL,
		answers       LONGTEXT      NOT NULL,
		submitted_at  DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
		PRIMARY KEY (id),
		KEY assessment_id (assessment_id),
		KEY submitted_at  (submitted_at)
	) {$charset_collate};";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );
}

/**
 * Checks a transient and creates the table once per month if the transient is missing.
 * Hooked at priority 5 so the table exists before other init hooks use it.
 */
function mit_maybe_create_assessment_table() {
	if ( ! get_transient( 'mit_assessment_table_created' ) ) {
		mit_create_assessment_submissions_table();
		set_transient( 'mit_assessment_table_created', true, MONTH_IN_SECONDS );
	}
}
add_action( 'init', 'mit_maybe_create_assessment_table', 5 );

/**
 * Insert a new assessment submission row.
 *
 * @param array $data {
 *   assessment_id, assessment_title, visitor_name, visitor_age,
 *   visitor_job, visitor_phone, visitor_email,
 *   total_score, result_title, result_description, answers (array)
 * }
 * @return int|false Inserted row ID or false on failure.
 */
function mit_insert_assessment_submission( array $data ) {
	global $wpdb;

	$table = $wpdb->prefix . 'mit_assessment_submissions';

	$inserted = $wpdb->insert(
		$table,
		array(
			'assessment_id'      => absint( $data['assessment_id'] ),
			'assessment_title'   => sanitize_text_field( $data['assessment_title'] ),
			'visitor_name'       => sanitize_text_field( $data['visitor_name'] ),
			'visitor_age'        => sanitize_text_field( $data['visitor_age'] ),
			'visitor_job'        => sanitize_text_field( $data['visitor_job'] ),
			'visitor_phone'      => sanitize_text_field( $data['visitor_phone'] ),
			'visitor_email'      => sanitize_email( $data['visitor_email'] ),
			'total_score'        => intval( $data['total_score'] ),
			'result_title'       => sanitize_text_field( $data['result_title'] ),
			'result_description' => wp_kses_post( $data['result_description'] ),
			'answers'            => wp_json_encode( $data['answers'] ),
			'submitted_at'       => current_time( 'mysql' ),
		),
		array( '%d', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s' )
	);

	return $inserted ? $wpdb->insert_id : false;
}

/**
 * Get a paginated list of assessment submissions.
 *
 * @param array $args {
 *   assessment_id (int, optional), per_page (int), page (int), order (ASC|DESC)
 * }
 * @return array { submissions, total, pages }
 */
function mit_get_assessment_submissions( array $args = array() ) {
	global $wpdb;

	$table = $wpdb->prefix . 'mit_assessment_submissions';

	$defaults = array(
		'assessment_id' => 0,
		'per_page'      => 20,
		'page'          => 1,
		'order'         => 'DESC',
	);
	$args = wp_parse_args( $args, $defaults );

	$where  = '';
	$params = array();

	if ( ! empty( $args['assessment_id'] ) ) {
		$where    = ' WHERE assessment_id = %d';
		$params[] = absint( $args['assessment_id'] );
	}

	$order  = ( 'ASC' === strtoupper( $args['order'] ) ) ? 'ASC' : 'DESC';
	$offset = ( max( 1, (int) $args['page'] ) - 1 ) * (int) $args['per_page'];

	$order_limit = " ORDER BY submitted_at {$order} LIMIT %d OFFSET %d";
	$params_full = array_merge( $params, array( (int) $args['per_page'], $offset ) );

	$sql_rows  = "SELECT * FROM {$table}{$where}{$order_limit}";
	$sql_count = "SELECT COUNT(*) FROM {$table}{$where}";

	// phpcs:disable WordPress.DB.PreparedSQL.NotPrepared -- all params are type-checked above.
	$submissions = $wpdb->get_results( $wpdb->prepare( $sql_rows, ...$params_full ) );
	$total       = (int) $wpdb->get_var( empty( $params ) ? $sql_count : $wpdb->prepare( $sql_count, ...$params ) );
	// phpcs:enable

	return array(
		'submissions' => $submissions ?: array(),
		'total'       => $total,
		'pages'       => $args['per_page'] > 0 ? (int) ceil( $total / $args['per_page'] ) : 1,
	);
}

/**
 * Get a single submission by its ID.
 *
 * @param int $id Row ID.
 * @return object|null Row object or null.
 */
function mit_get_assessment_submission( $id ) {
	global $wpdb;
	$table = $wpdb->prefix . 'mit_assessment_submissions';
	return $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$table} WHERE id = %d", absint( $id ) ) );
}
