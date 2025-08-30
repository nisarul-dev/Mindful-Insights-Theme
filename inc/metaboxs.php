<?php 

use Carbon_Fields\Container;
use Carbon_Fields\Field;

/**
 * Loads and initializes Carbon Fields from the theme's `lib/carbon-fields` directory.
 *
 * This function checks if the Carbon Fields autoloader file exists in the specified path,
 * requires it if available, and then boots Carbon Fields. It runs on the
 * `after_setup_theme` hook to ensure the theme environment is ready.
 *
 * @return void
 */
function mit_load_carbon_fields() {
    if ( file_exists( get_template_directory() . '/lib/carbon-fields/vendor/autoload.php' ) ) {
        require_once( get_template_directory() . '/lib/carbon-fields/vendor/autoload.php' );
        \Carbon_Fields\Carbon_Fields::boot();
    }
}
add_action( 'after_setup_theme', 'mit_load_carbon_fields' );

/**
 * Registers theme options pages using Carbon Fields.
 *
 * Creates a main Theme Options page with sub-pages for Header, Footer, and Social Links.
 *
 * @return void
 */
function mit_register_theme_options() {
    // Main Theme Options page.
    $basic_options_container = Container::make( 'theme_options', __( 'Theme Options', 'mindful-insights-theme' ) )
        ->set_icon( 'dashicons-image-filter' )
        ->set_page_menu_position( 61 )
        ->add_fields( array(
            Field::make( 'header_scripts', 'cl_header_script', __( 'Header Script', 'mindful-insights-theme' ) ),
            Field::make( 'footer_scripts', 'cl_footer_script', __( 'Footer Script', 'mindful-insights-theme' ) ),
        ) );

    // Header Options.
    Container::make( 'theme_options', __( 'Header Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_fields( array(
            Field::make( 'image', 'cl_header_logo', __( 'Header Logo', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'cl_header_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'cl_header_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) ),
        ) );


    // Footer Options.
    Container::make( 'theme_options', __( 'Footer Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_fields( array(
            Field::make( 'image', 'cl_footer_logo', __( 'Footer Logo', 'mindful-insights-theme' ) ),
            Field::make( 'complex', 'cl_footer_address_phone', 'Address & Phone' )
                ->add_fields( array(
                    Field::make( 'text', 'address', 'Address' ),
                    Field::make( 'text', 'phone', 'Phone No.' ),
                ) ),
            Field::make( 'textarea', 'cl_bottom_footer_map', __( 'Map Iframe', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'cl_bottom_footer_title', __( 'Bottom Footer Title', 'mindful-insights-theme' ) ),
            Field::make( 'textarea', 'cl_bottom_footer_desc', __( 'Bottom Footer Description', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'cl_footer_copyright_text', __( 'Copyright Text', 'mindful-insights-theme' ) ),
            
        ) );

    // Global Sections Options.
    Container::make( 'theme_options', __( 'Global Sections' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_tab( __( 'Latest Blog Posts Slider Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'cl_lbps_title_first_part', __( 'Heading (First Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: First Part (Black Color).' ),

            Field::make( 'text', 'cl_lbps_title_last_part', __( 'Heading (Last Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: Last Part (Orange Color).' ),
        ) )
        ->add_tab( __( 'Connect Legal Advisor Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'cl_cla_title_first_part', __( 'Heading (First Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: First Part (Black Color).' ),

            Field::make( 'text', 'cl_cla_title_last_part', __( 'Heading (Last Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: Last Part (Orange Color).' ),

            Field::make( 'textarea', 'cl_cla_content', __( 'Section Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Detailed content for the section.' ),
                
            Field::make( 'text', 'cl_cla_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Contact Us' ),

            Field::make( 'text', 'cl_cla_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /contact/' ),

            Field::make( 'image', 'cl_cla_section_img', __( 'Section Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload an image for the section.' ),
        ) );

    // Social Links.
    Container::make( 'theme_options', __( 'Social Links' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_fields( array(
            Field::make( 'text', 'crb_facebook_link', __( 'Facebook Link', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'crb_twitter_link', __( 'Twitter Link', 'mindful-insights-theme' ) ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'mit_register_theme_options' );

/**
 * Registers a custom meta field to display the post view count in the sidebar of the post edit screen.
 *
 * This field is shown in the right sidebar of the post editor for posts.
 * It displays the number of views for the current post.
 *
 * @return void
 */
function mit_register_post_view_count_field() {
    Container::make('post_meta', __('Post Views'))
        ->where('post_type', '=', 'post')
        ->set_context('side') // Moves meta box to the right sidebar.
        ->set_priority('high') // Ensures it appears near the top.
        ->add_fields(array(
            Field::make('text', 'post_views_count', __('View Count'))
                ->set_help_text('This is the number of views for this post.')
        ));
}
add_action('carbon_fields_register_fields', 'mit_register_post_view_count_field' );

/**
 * Register custom meta fields for a specific page using Carbon Fields.
 *
 * This function adds three structured sections for the page with ID 6 (Home Page).
 * @return void
 */
function mit_register_Home_page_sections() {
    Container::make( 'post_meta', __( 'Custom Page Sections', 'mindful-insights-theme' ) )
        ->where( 'post_id', '=', 6 ) // Replace with your specific page ID.
        ->add_tab( __( 'Hero Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'hero_title', __( 'Hero Title', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the hero section.' ),

            Field::make( 'textarea', 'hero_subtitle', __( 'Hero Subtitle', 'mindful-insights-theme' ) )
                ->set_help_text( 'Short description or subtitle.' ),

            Field::make( 'image', 'hero_background', __( 'Hero Background Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the background image for the hero section.' ),
        ) )
        ->add_tab( __( 'About Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'about_heading', __( 'About Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Heading for the About section.' ),

            Field::make( 'rich_text', 'about_content', __( 'About Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Detailed content for the About section.' ),

            Field::make( 'image', 'about_image', __( 'About Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload an image for the About section.' ),
        ) )
        ->add_tab( __( 'Contact Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'contact_heading', __( 'Contact Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Heading for the Contact section.' ),

            Field::make( 'text', 'contact_phone', __( 'Contact Phone', 'mindful-insights-theme' ) )
                ->set_help_text( 'Phone number to display.' ),

            Field::make( 'text', 'contact_email', __( 'Contact Email', 'mindful-insights-theme' ) )
                ->set_help_text( 'Email address for contact.' ),
        ) )
        ->add_tab( __( 'Watch Latest Video Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'cl_wlv_title', __( 'Section Title', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Watch Some of Our Latest Videos' ),
                
            Field::make( 'text', 'cl_wlv_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Watch More Videos' ),

            Field::make( 'text', 'cl_wlv_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /contact/' ),

            Field::make( 'image', 'cl_wlv_background', __( 'Background Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the background image for the section.' ),
        ) )
        ->add_tab( __( 'Experience a Smarter Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'cl_eas_title_first_part', __( 'Heading (First Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: First Part (Black Color).' ),

            Field::make( 'text', 'cl_eas_title_last_part', __( 'Heading (Last Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: Last Part (Orange Color).' ),

            Field::make( 'complex', 'cl_eas_cards', 'Blurbs' )
                ->add_fields( array(
                    Field::make( 'image', 'icon', 'Icon (SVG)' ),
                    Field::make( 'text', 'title', 'Title' ),
                    Field::make( 'text', 'description', 'Description' ),
                ) )
                ->set_help_text( 'Add 6 blurbs here.' ),
                
            Field::make( 'text', 'cl_eas_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Read More' ),

            Field::make( 'text', 'cl_eas_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /about-us/' ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'mit_register_Home_page_sections' );


