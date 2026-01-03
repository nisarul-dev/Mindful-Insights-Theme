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
        'has_archive'        => true,
        'rewrite'            => array( 'slug' => 'psychologists' ),
        'show_in_rest'       => true,
    );

    register_post_type( 'psychologist', $args );
}
add_action( 'init', 'mit_register_psychologist_cpt' );
