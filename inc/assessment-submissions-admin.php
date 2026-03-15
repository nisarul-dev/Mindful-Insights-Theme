<?php
/**
 * Assessment Submissions Admin View
 *
 * Reads from the custom `{prefix}mit_assessment_submissions` DB table.
 *
 * @package mindful-insights-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Register Submissions submenu page under the Assessments CPT menu.
 */
function mit_register_assessment_submissions_page() {
	add_submenu_page(
		'edit.php?post_type=assessment',
		'Assessment Submissions',
		'Submissions',
		'manage_options',
		'mit-assessment-submissions',
		'mit_render_assessment_submissions_page'
	);
}
add_action( 'admin_menu', 'mit_register_assessment_submissions_page' );


/**
 * Render the main submissions page (list or detail).
 */
function mit_render_assessment_submissions_page() {
	// Detail view.
	$view_id = isset( $_GET['view'] ) ? absint( $_GET['view'] ) : 0;
	if ( $view_id ) {
		$submission = mit_get_assessment_submission( $view_id );
		if ( $submission ) {
			mit_render_submission_detail( $submission );
			return;
		}
	}

	// --- List view ---
	$paged             = max( 1, absint( $_GET['paged'] ?? 1 ) );
	$filter_assessment = absint( $_GET['filter_assessment'] ?? 0 );

	$result = mit_get_assessment_submissions( array(
		'assessment_id' => $filter_assessment,
		'per_page'      => 20,
		'page'          => $paged,
	) );

	$submissions = $result['submissions'];
	$total_pages = $result['pages'];
	$total       = $result['total'];

	// All assessments for the filter dropdown.
	$all_assessments = get_posts( array(
		'post_type'      => 'assessment',
		'post_status'    => 'publish',
		'posts_per_page' => -1,
		'orderby'        => 'title',
		'order'          => 'ASC',
	) );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Assessment Submissions</h1>
		<span class="title-count" style="margin-left:8px;"><?php echo esc_html( $total ); ?> total</span>
		<hr class="wp-header-end">

		<!-- Filter Form -->
		<form method="get" style="margin: 16px 0 10px;">
			<input type="hidden" name="post_type" value="assessment">
			<input type="hidden" name="page"      value="mit-assessment-submissions">
			<select name="filter_assessment">
				<option value="0">— All Assessments —</option>
				<?php foreach ( $all_assessments as $asm ) : ?>
				<option value="<?php echo esc_attr( $asm->ID ); ?>" <?php selected( $filter_assessment, $asm->ID ); ?>>
					<?php echo esc_html( $asm->post_title ); ?>
				</option>
				<?php endforeach; ?>
			</select>
			<?php submit_button( 'Filter', 'secondary', '', false ); ?>
		</form>

		<?php if ( ! empty( $submissions ) ) : ?>
		<table class="wp-list-table widefat fixed striped">
			<thead>
				<tr>
					<th style="width:5%">#</th>
					<th style="width:18%">Visitor Name</th>
					<th style="width:22%">Assessment</th>
					<th style="width:8%">Score</th>
					<th style="width:27%">Result</th>
					<th style="width:12%">Date</th>
					<th style="width:8%">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $submissions as $sub ) :
					$detail_url = add_query_arg( array(
						'post_type' => 'assessment',
						'page'      => 'mit-assessment-submissions',
						'view'      => $sub->id,
					), admin_url( 'edit.php' ) );
				?>
				<tr>
					<td><?php echo esc_html( $sub->id ); ?></td>
					<td><strong><?php echo esc_html( $sub->visitor_name ); ?></strong></td>
					<td><?php echo esc_html( $sub->assessment_title ); ?></td>
					<td><strong><?php echo esc_html( $sub->total_score ); ?></strong></td>
					<td><?php echo esc_html( $sub->result_title ); ?></td>
					<td><?php echo esc_html( date_i18n( 'd M Y H:i', strtotime( $sub->submitted_at ) ) ); ?></td>
					<td><a href="<?php echo esc_url( $detail_url ); ?>" class="button button-small">View</a></td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<!-- Pagination -->
		<?php if ( $total_pages > 1 ) :
			$base_url = add_query_arg( array(
				'post_type'         => 'assessment',
				'page'              => 'mit-assessment-submissions',
				'filter_assessment' => $filter_assessment ?: null,
			), admin_url( 'edit.php' ) );
		?>
		<div style="margin-top:16px;">
			<?php for ( $p = 1; $p <= $total_pages; $p++ ) : ?>
			<a href="<?php echo esc_url( add_query_arg( 'paged', $p, $base_url ) ); ?>"
			   class="button<?php echo $p === $paged ? ' button-primary' : ''; ?>"
			   style="margin-right:4px;">
				<?php echo esc_html( $p ); ?>
			</a>
			<?php endfor; ?>
		</div>
		<?php endif; ?>

		<?php else : ?>
		<div class="notice notice-info inline" style="margin-top:20px;">
			<p>No submissions found yet.</p>
		</div>
		<?php endif; ?>
	</div>
	<?php
}


/**
 * Render the detail view for a single submission row.
 *
 * @param object $sub DB row object.
 */
function mit_render_submission_detail( $sub ) {
	$answers  = json_decode( $sub->answers, true ) ?: array();
	$back_url = add_query_arg( array(
		'post_type' => 'assessment',
		'page'      => 'mit-assessment-submissions',
	), admin_url( 'edit.php' ) );
	?>
	<div class="wrap">
		<h1 class="wp-heading-inline">Submission #<?php echo esc_html( $sub->id ); ?></h1>
		<a href="<?php echo esc_url( $back_url ); ?>" class="page-title-action">← Back to All Submissions</a>
		<hr class="wp-header-end" style="margin-bottom:20px;">

		<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;max-width:1100px;">
			<!-- Visitor Info -->
			<div class="postbox" style="margin:0;padding:16px;">
				<h2 class="hndle" style="padding:8px 0 12px;">Visitor Information</h2>
				<table class="widefat">
					<tr><th>নাম</th><td><?php echo esc_html( $sub->visitor_name ); ?></td></tr>
					<tr><th>বয়স</th><td><?php echo esc_html( $sub->visitor_age ); ?></td></tr>
					<tr><th>পেশা</th><td><?php echo esc_html( $sub->visitor_job ); ?></td></tr>
					<tr><th>ফোন</th><td><?php echo esc_html( $sub->visitor_phone ); ?></td></tr>
					<tr><th>ইমেইল</th><td><?php echo esc_html( $sub->visitor_email ?: '—' ); ?></td></tr>
					<tr><th>Submitted</th><td><?php echo esc_html( date_i18n( 'd M Y H:i', strtotime( $sub->submitted_at ) ) ); ?></td></tr>
				</table>
			</div>

			<!-- Result Info -->
			<div class="postbox" style="margin:0;padding:16px;">
				<h2 class="hndle" style="padding:8px 0 12px;">Result</h2>
				<table class="widefat">
					<tr><th>Assessment</th><td><?php echo esc_html( $sub->assessment_title ); ?></td></tr>
					<tr><th>Total Score</th><td><strong><?php echo esc_html( $sub->total_score ); ?></strong></td></tr>
					<tr><th>Result</th><td><strong><?php echo esc_html( $sub->result_title ); ?></strong></td></tr>
					<tr><th>Description</th><td><?php echo wp_kses_post( $sub->result_description ); ?></td></tr>
				</table>
			</div>
		</div>

		<!-- Answers Detail -->
		<?php if ( ! empty( $answers ) ) : ?>
		<div class="postbox" style="margin-top:20px;padding:16px;max-width:1100px;">
			<h2 class="hndle" style="padding:8px 0 12px;">Answers</h2>
			<table class="wp-list-table widefat fixed striped">
				<thead>
					<tr>
						<th style="width:50%"># Question</th>
						<th style="width:40%">Chosen Answer</th>
						<th style="width:10%">Score</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ( $answers as $i => $a ) : ?>
					<tr>
						<td><?php echo esc_html( ( $i + 1 ) . '. ' . $a['question'] ); ?></td>
						<td><?php echo esc_html( $a['chosen'] ); ?></td>
						<td><?php echo esc_html( $a['score'] ); ?></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		</div>
		<?php endif; ?>
	</div>
	<?php
}
