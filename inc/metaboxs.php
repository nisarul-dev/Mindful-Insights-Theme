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
            Field::make( 'header_scripts', 'mit_header_script', __( 'Header Script', 'mindful-insights-theme' ) ),
            Field::make( 'footer_scripts', 'mit_footer_script', __( 'Footer Script', 'mindful-insights-theme' ) ),
        ) );

    // Header Options.
    Container::make( 'theme_options', __( 'Header Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_fields( array(
            Field::make( 'image', 'mit_header_logo', __( 'Header Logo', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_header_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_header_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) ),
        ) );

    // Footer Options.
    Container::make( 'theme_options', __( 'Footer Options' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_fields( array(
            Field::make( 'image', 'mit_footer_logo', __( 'Footer Logo', 'mindful-insights-theme' ) ),
            Field::make( 'textarea', 'mit_footer_desc', __( 'Footer Description', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_menu_title', __( 'Footer Menu Title', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_facebook_link', __( 'Facebook Link', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_youtube_link', __( 'Youtube Link', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_linkedin_link', __( 'LinkedIn Link', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_copyright_text', __( 'Copyright Text', 'mindful-insights-theme' ) ),
            
        ) );

    // Global Sections Options.
    Container::make( 'theme_options', __( 'Global Sections' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_tab( __( 'Latest Blog Posts Slider Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_lbps_title_first_part', __( 'Heading (First Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: First Part (Black Color).' ),

            Field::make( 'text', 'mit_lbps_title_last_part', __( 'Heading (Last Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: Last Part (Orange Color).' ),
        ) )
        ->add_tab( __( 'Connect Legal Advisor Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_cla_title_first_part', __( 'Heading (First Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: First Part (Black Color).' ),

            Field::make( 'text', 'mit_cla_title_last_part', __( 'Heading (Last Part)', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main Heading: Last Part (Orange Color).' ),

            Field::make( 'textarea', 'mit_cla_content', __( 'Section Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Detailed content for the section.' ),
                
            Field::make( 'text', 'mit_cla_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Contact Us' ),

            Field::make( 'text', 'mit_cla_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /contact/' ),

            Field::make( 'image', 'mit_cla_section_img', __( 'Section Image', 'mindful-insights-theme' ) )
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
 * This function adds three structured sections for the page with ID 7 (Home Page).
 * @return void
 */
function mit_register_Home_page_sections() {
    Container::make( 'post_meta', __( 'Page Sections', 'mindful-insights-theme' ) )
        ->where( 'post_id', '=', 7 ) // Replace with your specific page ID.
        ->add_tab( __( 'Hero Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_hero_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'textarea', 'mit_hero_content', __( 'Section Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Short description or Content.' ),

            Field::make( 'text', 'mit_hero_cta_btn_text_1', __( 'CTA Btn Text 1', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Online Appointment' ),

            Field::make( 'text', 'mit_hero_cta_btn_link_1', __( 'CTA Btn Link 1', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /contact/' ),
            
            Field::make( 'text', 'mit_hero_cta_btn_text_2', __( 'CTA Btn Text 2', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Explore Our Services' ),

            Field::make( 'text', 'mit_hero_cta_btn_link_2', __( 'CTA Btn Link 2', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /services/' ),

            Field::make( 'image', 'mit_hero_section_image', __( 'Section Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the image for the section.' ),
        ) )
        ->add_tab( __( 'Explore Our Services Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_eos_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'complex', 'mit_eos_cards', 'Blurbs' )
                ->add_fields( array(
                    Field::make( 'image', 'icon', 'Icon (SVG)' ),
                    Field::make( 'text', 'title', 'Title' ),
                    Field::make( 'link', 'link', 'Link to Page' ),
                ) )
                ->set_help_text( 'Add 10 blurbs here.' ),
        ) )
        ->add_tab( __( 'Why Online Counseling Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_woc_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            // Field::make( 'text', 'mit_woc_subtitle', __( 'Section Sub-Heading', 'mindful-insights-theme' ) )
            //     ->set_help_text( 'Sub-heading for the section.' ),

            // Field::make( 'textarea', 'mit_woc_content', __( 'Section Content', 'mindful-insights-theme' ) )
            //     ->set_help_text( 'Short description or Content.' ),

            Field::make( 'complex', 'mit_woc_cards', 'Psychologists' )
                ->add_fields( array(
                    Field::make( 'image', 'avatar', 'Avatar' ),
                    Field::make( 'text', 'name', 'Name' ),
                    Field::make( 'link', 'position', 'Position' ),
                ) )
                ->set_help_text( 'Add 8 psychologists here.' ),

            Field::make( 'text', 'mit_woc_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. View all Consultants' ),

            Field::make( 'text', 'mit_woc_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /psychologists/' ),
        ) )
        ->add_tab( __( 'Meet Our Full Team Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_moft_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'complex', 'mit_moft_cards', 'Psychologists' )
                ->add_fields( array(
                    Field::make( 'image', 'avatar', 'Avatar' ),
                    Field::make( 'text', 'name', 'Name' ),
                    Field::make( 'link', 'position', 'Position' ),
                ) )
                ->set_help_text( 'Add 8 psychologists here.' ),

            Field::make( 'text', 'mit_moft_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. View all Consultants' ),

            Field::make( 'text', 'mit_moft_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /psychologists/' ),
        ) )
        ->add_tab( __( 'Testimonials Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_tm_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'complex', 'mit_tm_cards', 'Blurbs' )
                ->add_fields( array(
                    Field::make( 'image', 'icon', 'Icon (SVG)' ),
                    Field::make( 'text', 'number', 'Number' ),
                    Field::make( 'text', 'suffix', 'Suffix' ),
                    Field::make( 'text', 'content', 'Content' ),
                ) )
                ->set_help_text( 'Add 4 blurbs here.' ),
        ) )
        ->add_tab( __( 'Latest Articles & Videos Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_tav_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'text', 'mit_tav_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Show All' ),

            Field::make( 'text', 'mit_tav_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /blog/' ),
        ) );
}
add_action( 'carbon_fields_register_fields', 'mit_register_Home_page_sections' );


