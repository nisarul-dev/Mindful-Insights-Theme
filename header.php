<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
	<?php wp_body_open(); ?>

	<!-- Header Section starts -->
    
<header class="bg-gray-50 shadow-sm">
  <div class="container mx-auto flex items-center justify-between px-4 py-3 md:py-4">
    
    <!-- Logo + Site Title -->
    <div class="flex items-center space-x-2">
      <a href="<?php echo esc_url(home_url('/')); ?>" class="flex items-center">
        <img src="<?php echo get_template_directory_uri(); ?>/assets/images/Mindful-Insights-Logo.png" alt="Logo" class="h-10 w-10">
        <span class="ml-2 text-lg font-semibold text-gray-900"><?php bloginfo('name'); ?></span>
      </a>
    </div>

    <!-- Hamburger Button (Mobile) -->
    <button id="menu-toggle" class="md:hidden text-gray-800 focus:outline-none">
      <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"/>
      </svg>
    </button>

    <!-- Menu -->
    <nav id="menu" class="hidden absolute md:static top-16 left-0 w-full md:w-auto bg-gray-50 md:bg-transparent md:flex md:items-center md:space-x-6 shadow md:shadow-none">
      <?php
        wp_nav_menu(array(
          'theme_location' => 'main-menu',
          'menu_class'     => 'flex flex-col md:flex-row md:space-x-6 text-gray-800 font-medium',
          'container'      => false,
        ));
      ?>
      <!-- Call Now Button -->
      <a href="tel:+8801774848960" class="mt-4 md:mt-0 inline-block bg-blue-900 text-white font-medium px-4 py-2 rounded-full hover:bg-blue-800 transition">
        Call Now: +(880) 1774-848960
      </a>
    </nav>

  </div>
</header>

<script>
  // Mobile Menu Toggle
  document.getElementById("menu-toggle").addEventListener("click", function() {
    document.getElementById("menu").classList.toggle("hidden");
  });
</script>

<header class="flex items-center justify-between p-4 bg-gray-100">
  <h1 class="text-xl font-bold">Mindful Insights</h1>
  <a href="tel:+8801774848960" class="bg-blue-900 text-white px-4 py-2 rounded-full">Call Now</a>
</header>
