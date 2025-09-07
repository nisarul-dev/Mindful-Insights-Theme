<?php get_header(); ?>

<!-- Hero Section Starts -->
<section class="hero-section bg-theme-light-gray">
    <div class="container mx-auto px-2 max-sm:pt-5">
        <div class="flex flex-col lg:flex-row">
            <div class="left-area xl:w-[70%] lg:h-[480px] flex flex-col justify-center">
                <h1 class="text-black text-center lg:text-left text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-5 font-semibold">Your Mental Wellness, From the Comfort of Stay
                    Home</h1>
                <h2 class="text-black text-center lg:text-left text-balance lg:text-wrap text-md md:text-lg xl:text-xl xl:w-[700px]">Professional online counseling tailored to your needs —
                    accessible, confidential, and compassionate.</h2>
                <div class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-3 mt-10 lg:mb-20">
                    <a class="btn bg-transparent hover:bg-white text-black lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-9 xl:py-7 border-2 border-black"
                        href="#">Online Appointment</a>
                    <a class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-9 xl:py-7 border-2 border-transparent"
                        href="#">Explore Our Services</a>
                </div>
            </div>
            <div class="right-area py-12 lg:pt-20 xl:pt-10 2xl:pt-3">
                <?php echo wp_get_attachment_image(get_carbon_field('mit_hero_section_image' ), 'full'); ?>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section Ends -->

<?php get_footer(); ?>