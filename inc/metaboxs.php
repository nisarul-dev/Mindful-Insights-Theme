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
            Field::make( 'text', 'mit_footer_phone_number', __( 'Phone Number - CTA Button', 'mindful-insights-theme' ) ),
            Field::make( 'text', 'mit_footer_phone_number_link', __( 'Phone Number - CTA Button', 'mindful-insights-theme' ) ),
            Field::make( 'rich_text', 'mit_footer_copyright_text', __( 'Copyright Text', 'mindful-insights-theme' ) ),
        ) );

    // Global Sections Options.
    Container::make( 'theme_options', __( 'Global Sections' ) )
        ->set_page_parent( $basic_options_container ) // reference to a top level container.
        ->add_tab( __( 'Need Assistance Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_na_title', __( 'Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Section Heading.' ),

            Field::make( 'textarea', 'mit_na_content', __( 'Section Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Detailed content for the section.' ),
                
            Field::make( 'text', 'mit_na_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Book a Free Consultation' ),

            Field::make( 'text', 'mit_na_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /contact/' ),

            Field::make( 'image', 'mit_na_section_bg_img', __( 'Background Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload an background image for the section.' ),
        ) )
        ->add_tab( __( 'FAQ Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_faq_title', __( 'Heading', 'mindful-insights-theme' ) )
                ->set_help_text( help_text: 'Section Heading.' ),

            Field::make( 'textarea', 'mit_faq_content', __( 'Section Content', 'mindful-insights-theme' ) )
                ->set_help_text( 'Detailed content for the section.' ),

            Field::make( 'complex', 'mit_faq_left_area_cards', 'FAQ Cards (Left Area)' )
                ->add_fields( array(
                    Field::make( 'text', 'question', __( 'Question', 'mindful-insights-theme' ) ),
                    Field::make( 'textarea', 'answer', __( 'Answer', 'mindful-insights-theme' ) ),
                ) )
                ->set_help_text( 'Add 2 FAQs here.' ),

            Field::make( 'complex', 'mit_faq_right_area_cards', 'FAQ Cards (Right Area)' )
                ->add_fields( array(
                    Field::make( 'text', 'question', __( 'Question', 'mindful-insights-theme' ) ),
                    Field::make( 'textarea', 'answer', __( 'Answer', 'mindful-insights-theme' ) ),
                ) )
                ->set_help_text( 'Add 7 slides here.' ),

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
        ->add_tab( __( 'Why Online Counseling Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_woc_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),
            
            Field::make( 'complex', 'mit_woc_slides', 'Slides' )
                ->add_fields( array(
                    Field::make( 'text', 'heading', __( 'Slide Heading', 'mindful-insights-theme' ) )
                        ->set_help_text( 'Heading for the slide.' ),
                    Field::make( 'textarea', 'description', __( 'Slide Content', 'mindful-insights-theme' ) )
                        ->set_help_text( 'Short description or Content.' ),
                    Field::make( 'image', 'image', 'Slide Image' ),
                ) )
                ->set_help_text( 'Add 3 slides here.' ),
        ) )
        ->add_tab( __( 'Explore Our Services Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_eos_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'complex', 'mit_eos_cards', 'Blurbs' )
                ->add_fields( array(
                    Field::make( 'image', 'icon', 'Icon (SVG)' ),
                    Field::make( 'text', 'title', 'Title' ),
                    Field::make( 'text', 'link', 'Link to Page' ),
                ) )
                ->set_help_text( 'Add 10 blurbs here.' ),
        ) )
        ->add_tab( __( 'Meet Our Full Team Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_moft_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'complex', 'mit_moft_cards', 'Psychologists' )
                ->add_fields( array(
                    Field::make( 'image', 'avatar', 'Avatar' ),
                    Field::make( 'text', 'name', 'Name' ),
                    Field::make( 'text', 'position', 'Position' ),
                    Field::make( 'text', 'link', 'Link to Page' ),
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
            Field::make( 'text', 'mit_lav_title', __( 'Section Heading', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the section.' ),

            Field::make( 'text', 'mit_lav_cta_btn_text', __( 'CTA Btn Text', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. Show All' ),

            Field::make( 'text', 'mit_lav_cta_btn_link', __( 'CTA Btn Link', 'mindful-insights-theme' ) )
                ->set_help_text( 'e.g. /blog/' ),
        ) )
        ->add_tab( __( 'Single Workspace Section', 'mindful-insights-theme' ), array(
            Field::make( 'text', 'mit_sw_title', __( 'Section Title', 'mindful-insights-theme' ) )
                ->set_help_text( 'Main heading for the workspace section.' ),

            Field::make( 'rich_text', 'mit_sw_description_main', __( 'Main Description', 'mindful-insights-theme' ) )
                ->set_help_text( 'This appears first. The “Show More” button reveals the second paragraph.' ),

            Field::make( 'image', 'mit_sw_image_1', __( 'Large Left Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the main large image.' ),

            Field::make( 'image', 'mit_sw_image_2', __( 'Small Top-Right Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the top-right small image.' ),

            Field::make( 'image', 'mit_sw_image_3', __( 'Small Bottom-Right Image', 'mindful-insights-theme' ) )
                ->set_help_text( 'Upload the bottom-right small image.' ),
        ) );

}
add_action( 'carbon_fields_register_fields', 'mit_register_Home_page_sections' );


