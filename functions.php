<?php

/**
 * Enqueues scripts and styles.
 */
function mit_scripts_enqueue() {
	// fonts
	wp_enqueue_style( 'load-google-fonts-work-sans', 'https://fonts.googleapis.com/css2?family=Work+Sans:ital,wght@0,100..900;1,100..900&display=swap' );
	wp_enqueue_style( 'load-google-fonts-syne', 'https://fonts.googleapis.com/css2?family=Syne:wght@400..800&display=swap' );
	wp_enqueue_style( 'load-font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css' );
	// css libraries
	// Build Tailwind: npx @tailwindcss/cli -i ./assets/css/input.css -o ./assets/css/output.css --watch
	wp_enqueue_style( 'tailwind-output', get_template_directory_uri() . '/assets/css/output.css', array(), '4.1.12', 'all' );

	// css
	// wp_enqueue_style( 'owl-style', get_template_directory_uri() . '/assets/css/owl.carousel.min.css', array(), '2.3.4', 'all' );
    wp_enqueue_style( 'fancybox-css', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css', array(), '5.0', 'all' );
	wp_enqueue_style( 'main-style', get_template_directory_uri() . '/assets/css/main-style.css', array( 'load-google-fonts-work-sans', 'load-google-fonts-syne', 'load-font-awesome', 'tailwind-output', 'fancybox-css' ), '1.0.4', 'all' );

	// js
	// wp_enqueue_script( 'owl-script', get_template_directory_uri() . '/assets/js/owl.carousel.min.js', array( 'jquery' ), '2.3.4', true );
	wp_enqueue_script( 'fancybox-js', 'https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js', array( 'jquery' ), '5.0', true );
	wp_enqueue_script( 'main-script', get_template_directory_uri() . '/assets/js/main-script.js', array( 'fancybox-js', 'jquery' ), '1.0.0', true );

	// Assessment System — only load on assessment pages.
	if ( is_singular( 'assessment' ) ) {
		wp_enqueue_style(
			'assessment-style',
			get_template_directory_uri() . '/assets/css/assessment.css',
			array( 'main-style' ),
			'1.0.0',
			'all'
		);

		// reCAPTCHA v3 — load only when site key is configured.
		$recaptcha_site_key = get_carbon_field( 'mit_recaptcha_site_key', '', 'options' );
		if ( $recaptcha_site_key ) {
			wp_enqueue_script(
				'google-recaptcha-v3',
				'https://www.google.com/recaptcha/api.js?render=' . urlencode( $recaptcha_site_key ),
				array(),
				null,
				false // Load in <head> — required by reCAPTCHA.
			);
		}

		wp_enqueue_script(
			'assessment-script',
			get_template_directory_uri() . '/assets/js/assessment.js',
			array( 'jquery' ),
			'1.0.0',
			true
		);

		wp_localize_script( 'assessment-script', 'assessmentData', array(
			'recaptchaSiteKey' => $recaptcha_site_key,
			'recaptchaEnabled' => ! empty( $recaptcha_site_key ) ? 'yes' : 'no',
		) );
	}

	// Archive page only needs CSS.
	if ( is_post_type_archive( 'assessment' ) ) {
		wp_enqueue_style(
			'assessment-style',
			get_template_directory_uri() . '/assets/css/assessment.css',
			array( 'main-style' ),
			'1.0.0',
			'all'
		);
	}
}
add_action( 'wp_enqueue_scripts', 'mit_scripts_enqueue' );

/**
 * Setup Theme.
 */
function mit_setup_theme() {
	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'html5' );

	// Register Menu
	add_theme_support( 'menus' );
	register_nav_menu( 'main-menu', 'Header Navigation Menu' );
	register_nav_menu( 'footer-menu', 'Footer Navigation Menu' );
}
add_action( 'after_setup_theme', 'mit_setup_theme' );

/**
 * Widgets Init
 */
function mit_register_sidebar() {
	register_sidebar(
		array(
			'name'          => 'Single Blog Page Sidebar',
			'id'            => 'single-blog-sidebar',
			'description'   => 'This is the Single Blog Page Sidebar.',
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'mit_register_sidebar' );


/**
 * Including Carbon Fields Library
 */
if ( file_exists( get_template_directory() . '/inc/metaboxs.php' ) ) {
	include_once get_template_directory() . '/inc/metaboxs.php';
}

/**
 * Including Nav Walker Class
 */
if ( file_exists( get_template_directory() . '/inc/nav-walker-class.php' ) ) {
	include_once get_template_directory() . '/inc/nav-walker-class.php';
}

/**
 * Including Custom Post Types (CPTs)
 */
if ( file_exists( get_template_directory() . '/inc/cpts.php' ) ) {
	include_once get_template_directory() . '/inc/cpts.php';
}

/**
 * Including Assessment DB (custom table + CRUD) — must come before handler.
 */
if ( file_exists( get_template_directory() . '/inc/assessment-db.php' ) ) {
	include_once get_template_directory() . '/inc/assessment-db.php';
}

/**
 * Including Assessment Form Handler (template_redirect, PRG pattern)
 */
if ( file_exists( get_template_directory() . '/inc/assessment-handler.php' ) ) {
	include_once get_template_directory() . '/inc/assessment-handler.php';
}


/**
 * Including Assessment Submissions Admin Page
 */
if ( file_exists( get_template_directory() . '/inc/assessment-submissions-admin.php' ) ) {
	include_once get_template_directory() . '/inc/assessment-submissions-admin.php';
}

/**
 * Custom helper for Carbon Fields for consistent development by Nisarul
 */
if ( ! function_exists( 'get_carbon_field' ) ) {
	function get_carbon_field( $selector, $default_value = '', $post_id = null ) {
		if ( function_exists( 'carbon_get_post_meta' ) ) {
			if ( null === $post_id ) {
				return carbon_get_the_post_meta( $selector ) ?: $default_value;
			} elseif ( 'option' === $post_id || 'options' === $post_id ) {
				return carbon_get_theme_option( $selector ) ?: $default_value;
			} else {
				return carbon_get_post_meta( $post_id, $selector ) ?: $default_value;
			}
		}
		return $default_value; // fallback if Carbon Fields is not active.
	}
}
