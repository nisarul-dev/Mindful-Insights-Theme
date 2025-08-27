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
function crb_theme_options_page() {

    /*
    Container::make( 'theme_options', __( 'Theme Options' ) )
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'Text Field' ),
        ) );

    Container::make( 'theme_options', __( 'Theme Options 2' ) )
        ->add_tab( __( 'Profile' ), array(
            Field::make( 'text', 'crb_first_name', __( 'First Name' ) ),
            Field::make( 'text', 'crb_last_name', __( 'Last Name' ) ),
            Field::make( 'text', 'crb_position', __( 'Position' ) ),
        ) )
        ->add_tab( __( 'Notification' ), array(
            Field::make( 'text', 'crb_email', __( 'Notification Email' ) ),
            Field::make( 'text', 'crb_phone', __( 'Phone Number' ) ),
        ) );
    */

    // Default options page
    $basic_options_container = Container::make( 'theme_options', __( 'Theme Options', 'mindful-insights-theme' ) )
        ->set_icon( 'dashicons-image-filter' )
        ->set_page_menu_position( 61 )
        ->add_fields( array(
            Field::make( 'text', 'crb_text', 'Text Field' ),
            Field::make( 'image', 'crb_background_image', __( 'Background Image', 'mindful-insights-theme' ) ),
            Field::make( 'header_scripts', 'crb_header_script', __( 'Header Script', 'mindful-insights-theme' ) ),
            Field::make( 'footer_scripts', 'crb_footer_script', __( 'Footer Script', 'mindful-insights-theme' ) ),
        ) );

    // Add header options page under 'Theme Options'
    Container::make( 'theme_options', __( 'Header Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'image', 'mit_header_logo', __( 'Header Logo', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_header_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_header_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) ),
        ) );


    // Add footer options page under 'Theme Options'
    Container::make( 'theme_options', __( 'Footer Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'image', 'mit_footer_logo', __( 'Footer Logo', 'mindful-insights-theme' ) ),
            Field::make( 'complex', 'mit_footer_address_phone', 'Address & Phone' )
                ->add_fields( array(
                    Field::make( 'text', 'address', 'Address' ),
                    Field::make( 'text', 'phone', 'Phone No.' ),
                ) ),
            Field::make( 'textarea', 'mit_bottom_footer_map', __( 'Map Iframe', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_bottom_footer_title', __( 'Bottom Footer Title', 'mindful-insights-theme' ) ),
            Field::make( 'textarea', 'mit_bottom_footer_desc', __( 'Bottom Footer Description', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_copyright_text', __( 'Copyright Text', 'mindful-insights-theme' ) ),
            
        ) );

    // Add second options page under 'Theme Options'
    Container::make( 'theme_options', __( 'Social Links' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container
        ->add_fields( array(
            Field::make( 'text', 'crb_facebook_link', __( 'Facebook Link', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'crb_twitter_link', __( 'Twitter Link', 'mindful-insights-theme' ) ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'crb_theme_options_page' );

