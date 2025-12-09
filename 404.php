<?php get_header(); ?>

<!-- 404 Error Section -->
<section class="error-404-section py-[60px] max-md:py-[40px] bg-white flex items-center">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="max-w-4xl mx-auto text-center">
            
            <!-- 404 Visual -->
            <div class="error-number mb-10">
                <h1 class="text-theme-blue text-[150px] md:text-[200px] lg:text-[250px] font-bold leading-none">
                    404
                </h1>
            </div>

            <!-- Error Message -->
            <h2 class="text-black text-2xl md:text-4xl lg:text-5xl font-semibold mb-6">
                Oops! Page Not Found
            </h2>

            <p class="text-font-gray text-lg md:text-xl leading-relaxed mb-12 max-w-2xl mx-auto">
                The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                <a class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-8 py-5 xl:px-12 xl:py-7 border-2 border-transparent" 
                   href="<?php echo esc_url(home_url('/')); ?>">
                    Back to Homepage
                </a>
                <a class="btn bg-transparent hover:bg-white text-black lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-8 py-5 xl:px-12 xl:py-7 border-2 border-black" 
                   href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>">
                    View Blog
                </a>
            </div>

            
        </div>
    </div>
</section>


<?php get_footer(); ?>