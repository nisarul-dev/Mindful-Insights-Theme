<?php
/**
 * Register Psychologist Custom Post Type
 */
function mit_register_psychologist_cpt() {

    $labels = array(
        'name'               => 'Psychologists',
        'singular_name'      => 'Psychologist',
        'menu_name'          => 'Psychologists',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Psychologist',
        'edit_item'          => 'Edit Psychologist',
        'new_item'           => 'New Psychologist',
        'view_item'          => 'View Psychologist',
        'search_items'       => 'Search Psychologists',
        'not_found'          => 'No Psychologists Found',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-businessperson',
        'supports'           => array( 'title', 'thumbnail' ),
        'has_archive'        => false,
        'rewrite'            => array( 'slug' => 'psychologist' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'psychologist', $args );
}
add_action( 'init', 'mit_register_psychologist_cpt' );

/**
 * Register Assessment Custom Post Type
 */
function mit_register_assessment_cpt() {

    $labels = array(
        'name'               => 'Assessments',
        'singular_name'      => 'Assessment',
        'menu_name'          => 'Assessments',
        'add_new'            => 'Add New',
        'add_new_item'       => 'Add New Assessment',
        'edit_item'          => 'Edit Assessment',
        'new_item'           => 'New Assessment',
        'view_item'          => 'View Assessment',
        'search_items'       => 'Search Assessments',
        'not_found'          => 'No Assessments Found',
        'all_items'          => 'All Assessments',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'menu_icon'          => 'dashicons-clipboard',
        'menu_position'      => 25,
        'supports'           => array( 'title', 'thumbnail' ),
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'assessments' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'assessment', $args );
}
add_action( 'init', 'mit_register_assessment_cpt' );

/**
 * Register Assessment Submission Custom Post Type (private – admin only)
 */
function mit_register_assessment_submission_cpt() {

    $labels = array(
        'name'               => 'Assessment Submissions',
        'singular_name'      => 'Submission',
        'menu_name'          => 'Submissions',
        'all_items'          => 'All Submissions',
        'view_item'          => 'View Submission',
        'search_items'       => 'Search Submissions',
        'not_found'          => 'No Submissions Found',
    );

    $args = array(
        'labels'             => $labels,
        'public'             => false,
        'show_ui'            => true,
        'show_in_menu'       => 'edit.php?post_type=assessment',
        'supports'           => array( 'title' ),
        'has_archive'        => false,
        'capability_type'    => 'post',
        'capabilities'       => array(
            'create_posts' => 'do_not_allow', // disable manual creation from admin
        ),
        'map_meta_cap'       => true,
    );

    register_post_type( 'assessment_submission', $args );
}
add_action( 'init', 'mit_register_assessment_submission_cpt' );

/**
 * Flush rewrite rules once after new CPTs are registered.
 * This fires at priority 20 (after CPTs are registered at default priority 10).
 * The transient ensures this only runs once, not on every page load.
 */
function mit_flush_rewrite_rules_once() {
    if ( ! get_transient( 'mit_assessment_cpt_flushed' ) ) {
        flush_rewrite_rules();
        set_transient( 'mit_assessment_cpt_flushed', true, WEEK_IN_SECONDS );
    }
}
add_action( 'init', 'mit_flush_rewrite_rules_once', 20 );

