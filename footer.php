<!-- Footer Section starts -->
<footer class="footer-section bg-theme-light-gray pt-12">
    <div class="container mx-auto px-6 md:px-2">
        <div class="flex flex-col lg:flex-row justify-between">

            <!-- Left Area -->
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <div class="flex items-center gap-4 mb-6">
                    <!-- Logo -->
                    <?php echo wp_get_attachment_image( get_carbon_field('mit_footer_logo', '', 'options'), 'full', false, ['class' => 'h-[70px] w-[70px]'] ); ?>
                    <h2 class="text-2xl font-semibold text-black">Mindful Insights</h2>
                </div>

                <p class="text-font-gray text-lg leading-[30px] xl:w-[450px]">
                    Your trusted partner in mental health and well-being. We provide professional psychological 
                    services, including telecounseling, workshops, and individualized support for issues like 
                    depression, anxiety, trauma, stress, OCD, and more.
                </p>
            </div>

            <!-- Right Area -->
            <div class="lg:w-1/2 flex flex-col lg:flex-row justify-between">

                <!-- Main Links -->
                <div>
                    <h3 class="text-xl font-semibold text-black mb-6">Main Links</h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu space-y-4 text-lg text-font-gray',
                        'container' => false,
                    ));
                    ?>
                </div>

                <!-- Social + Call Button -->
                <div class="mt-10 lg:mt-0">
                    <div class="flex items-center gap-5 mb-8">
                        <a href="#" class="w-[50px] h-[50px] rounded-full bg-theme-blue text-white flex items-center justify-center">
                            <i class="fab fa-facebook-f text-xl"></i>
                        </a>
                        <a href="#" class="w-[50px] h-[50px] rounded-full bg-red-600 text-white flex items-center justify-center">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="w-[50px] h-[50px] rounded-full bg-[#0A66C2] text-white flex items-center justify-center">
                            <i class="fab fa-linkedin-in text-xl"></i>
                        </a>
                    </div>

                    <a href="tel:+8801774848960"
                       class="inline-block bg-theme-blue hover:bg-theme-blue-hover text-white font-medium text-lg 
                              px-10 py-4 rounded-full">
                        Call Now: +(880) 1774-848960
                    </a>
                </div>

            </div>
        </div>
    </div>
    <div class="w-full py-5 mt-12 bg-white">
            <p class="text-center">© 2025 Mindful Insights. All rights reserved.</p>
        </div>
    </div>
</footer>
<!-- Footer Section Ends -->

<?php wp_footer(); ?>
</body>

</html>