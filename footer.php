<!-- Footer Section starts -->
<footer class="footer-section bg-theme-light-gray pt-12">
    <div class="container mx-auto px-6 md:px-2">
        <div class="flex flex-col lg:flex-row justify-between lg:gap-5">

            <!-- Left Area -->
            <div class="lg:w-1/2 mb-12 lg:mb-0">
                <div class="footer-image-wrapper flex justify-center lg:justify-start">
                    <?php
                    echo wp_get_attachment_image(get_carbon_field('mit_footer_logo', '', 'options'), 'full', false, array(
                        'class' => 'max-h-[90px] mb-6'
                    ));
                    ?>
                </div>

                <p class="text-font-gray text-center text-balance lg:text-left text-lg leading-[30px] xl:w-[550px]">
                    <?php echo esc_html(get_carbon_field('mit_footer_desc', '', 'options') ); ?>
                </p>
            </div>

            <!-- Right Area -->
            <div class="lg:w-1/2 flex flex-col lg:flex-row justify-between">

                <!-- Main Links -->
                <div>
                    <h3 class="text-xl text-center lg:text-left font-semibold text-black mb-6"><?php echo esc_html(get_carbon_field('mit_footer_menu_title', '', 'options') ); ?></h3>
                    <?php
                    wp_nav_menu(array(
                        'theme_location' => 'footer-menu',
                        'menu_class' => 'footer-menu text-center lg:text-left space-y-4 text-lg text-font-gray',
                        'container' => false,
                    ));
                    ?>
                </div>

                <!-- Social + Call Button -->
                <div class="mt-12 lg:mt-0 text-center lg:text-right">
                    <div class="flex items-center justify-center lg:justify-start gap-6 mt-15 max-lg:mt-0 mb-10">
                        <?php if( get_carbon_field('mit_footer_facebook_link', '', 'options') ) : ?>
                        <a target="_black" href="<?php echo esc_url(get_carbon_field('mit_footer_facebook_link', '', 'options') ); ?>" class="w-[50px] h-[50px] rounded-full bg-theme-blue hover:bg-gray-600 text-white flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951"></path>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if( get_carbon_field('mit_footer_youtube_link', '', 'options') ) : ?>
                        <a target="_black" href="<?php echo esc_url(get_carbon_field('mit_footer_youtube_link', '', 'options') ); ?>" class="w-[50px] h-[50px] rounded-full bg-[#DA0000] hover:bg-gray-600 text-white flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-youtube" viewBox="0 0 16 16">
                            <path d="M8.051 1.999h.089c.822.003 4.987.033 6.11.335a2.01 2.01 0 0 1 1.415 1.42c.101.38.172.883.22 1.402l.01.104.022.26.008.104c.065.914.073 1.77.074 1.957v.075c-.001.194-.01 1.108-.082 2.06l-.008.105-.009.104c-.05.572-.124 1.14-.235 1.558a2.01 2.01 0 0 1-1.415 1.42c-1.16.312-5.569.334-6.18.335h-.142c-.309 0-1.587-.006-2.927-.052l-.17-.006-.087-.004-.171-.007-.171-.007c-1.11-.049-2.167-.128-2.654-.26a2.01 2.01 0 0 1-1.415-1.419c-.111-.417-.185-.986-.235-1.558L.09 9.82l-.008-.104A31 31 0 0 1 0 7.68v-.123c.002-.215.01-.958.064-1.778l.007-.103.003-.052.008-.104.022-.26.01-.104c.048-.519.119-1.023.22-1.402a2.01 2.01 0 0 1 1.415-1.42c.487-.13 1.544-.21 2.654-.26l.17-.007.172-.006.086-.003.171-.007A100 100 0 0 1 7.858 2zM6.4 5.209v4.818l4.157-2.408z"></path>
                            </svg>
                        </a>
                        <?php endif; ?>
                        <?php if( get_carbon_field('mit_footer_linkedin_link', '', 'options') ) : ?>
                        <a target="_black" href="<?php echo esc_url(get_carbon_field('mit_footer_linkedin_link', '', 'options') ); ?>" class="w-[50px] h-[50px] rounded-full bg-[#0A66C2] hover:bg-gray-600 text-white flex items-center justify-center">
                            <svg stroke="currentColor" fill="currentColor" stroke-width="0" viewBox="0 0 448 512" height="27" width="27" xmlns="http://www.w3.org/2000/svg"><path d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                        </a>
                        <?php endif; ?>
                    </div>

                    <a href="<?php echo esc_html(get_carbon_field('mit_footer_phone_number_link', '', 'options') ); ?>"
                       class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-[500] rounded-full px-6 py-5 xl:px-7 xl:py-6 border-2 border-transparent">
                        <?php echo esc_html(get_carbon_field('mit_footer_phone_number', '', 'options') ); ?>
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