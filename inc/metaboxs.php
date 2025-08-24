<?php 

use Carbon_Fields\Container;
use Carbon_Fields\Field;

function crb_load() {
    if ( file_exists( get_template_directory() . '/lib/carbon-fields/vendor/autoload.php' ) ) {
        require_once( get_template_directory() . '/lib/carbon-fields/vendor/autoload.php' );
        \Carbon_Fields\Carbon_Fields::boot();
    }
}
add_action( 'after_setup_theme', 'crb_load' );

// Create Custom Fields From Here
function crb_attach_theme_options() {
    Container::make( 'theme_options', __( 'Theme Options' ) )
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'Text Field' ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'crb_attach_theme_options' );
