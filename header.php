<!DOCTYPE html>
<html <?php language_attributes(); ?> data-theme="light">

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Header Section starts -->
    <header class="header-section bg-[#F5F5F5]">
        <div class="navbar container mx-auto py-[30px]">
            <div class="navbar-start">
                 <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center lg:w-[220px]  xl:w-[280px]">
                    <?php echo wp_get_attachment_image(get_carbon_field('mit_header_logo', '', 'options'), 'full'); ?>
                </a>
            </div>
            <div class="navbar-center hidden lg:flex lg:w-[70%] xl:w-[auto] lg:justify-center">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'main-menu',
                    'menu_class' => 'menu menu-horizontal px-1 text-[17px] text-black',
                    'container' => false,
                ));
                ?>
            </div>
            <div class="navbar-end">
                <a href="<?php echo esc_url(get_carbon_field('mit_header_cta_btn_link', '#', 'options')); ?>"
                    class="text-[18px] max-xl:hidden btn  bg-theme-blue text-white font-medium px-[28px] py-[25px] rounded-full hover:bg-theme-blue-hover transition">
                    <?php echo esc_html(get_carbon_field('mit_header_cta_btn_text', 'Btn Text', 'options')); ?>
                </a>

                <div class="dropdown">
                    <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> </svg>
                    </div>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'main-menu',
                        'menu_class' => 'menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 right-0 p-2 shadow',
                        'container' => false,
                    ));
                    ?>
                </div>

                <a href="<?php echo esc_url(get_carbon_field('mit_header_cta_btn_link', '#', 'options')); ?>"
                    class="xl:hidden btn  bg-blue-900 text-white font-medium   rounded-full hover:bg-blue-800 transition">
                    <i class="fa-solid fa-phone"></i>
                </a>


            </div>
        </div>
    </header>