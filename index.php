<?php get_header(); ?>

<!-- Hero Section Starts -->
<section class="hero-section bg-theme-light-gray">
    <div class="container mx-auto px-2 max-sm:pt-5">
        <div class="flex flex-col lg:flex-row">
            <div class="left-area xl:w-[70%] lg:h-[480px] flex flex-col justify-center">
                <h1
                    class="text-black text-center lg:text-left text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-5 font-semibold">
                    Your Mental Wellness, From the Comfort of Stay
                    Home</h1>
                <h2
                    class="text-black text-center lg:text-left text-balance lg:text-wrap text-md md:text-lg xl:text-xl xl:w-[700px]">
                    Professional online counseling tailored to your needs —
                    accessible, confidential, and compassionate.</h2>
                <div
                    class="flex flex-col sm:flex-row items-center lg:items-start justify-center lg:justify-start gap-3 mt-10 lg:mb-20">
                    <a class="btn bg-transparent hover:bg-white text-black lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-9 xl:py-7 border-2 border-black"
                        href="#">Online Appointment</a>
                    <a class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-9 xl:py-7 border-2 border-transparent"
                        href="#">Explore Our Services</a>
                </div>
            </div>
            <div class="right-area py-12 lg:pt-20 xl:pt-10 2xl:pt-3">
                <?php echo wp_get_attachment_image(get_carbon_field('mit_hero_section_image'), 'full'); ?>
            </div>
        </div>
    </div>
</section>
<!-- Hero Section Ends -->

<!-- Hero Section Starts -->
<section class="hero-section py-[78px]">
    <div class="container mx-auto px-2 max-sm:pt-5">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_woc_title')); ?>
        </h1>

        <?php if( get_carbon_field( 'mit_woc_slides' ) ) : ?>
        <div class="carousel w-full">
            <?php
            $i = 1;
            $slides = get_carbon_field( 'mit_woc_slides' );
            foreach( $slides as $slide ): 
            ?>
                <div id="slide<?php echo esc_attr( $i ); ?>" class="carousel-item relative w-full">
                    <div class="flex flex-col lg:flex-row">
                        <div class="left-area w-[625px]">
                            <h3>Why Choose Online Therapy?</h3>
                            <p>
                                In today’s fast-paced world, finding time for your mental well-being shouldn’t be difficult. Our online counseling sessions make it easy and safe to talk with a psychologist anytime, from anywhere. In today’s fast-paced world, finding time for your mental well-being shouldn’t be difficult. Our online counseling sessions make it easy and safe to talk with a psychologist anytime, from anywhere.
                            </p>
                            <div class="navigation">
                                <?php
                                    $prev = ( 0 >= ( $i - 1 ) ) ? count( $slides ) : $i - 1  ;
                                    $next = ( count( $slides ) >= ( $i + 1 ) ) ? $i + 1 :  1;
                                ?>
                                <a href="#slide<?php echo esc_attr( $prev ); ?>" class="btn btn-circle">❮</a>
                                <a href="#slide<?php echo esc_attr( $next ); ?>" class="btn btn-circle">❯</a>
                            </div>
                        </div>
                        <div class="right-area">
                            <img src="https://img.daisyui.com/images/stock/photo-1625726411847-8cbb60cc71e6.webp" class="w-full" />
                        </div>
                    </div>
                </div>
            <?php 
                $i++;
            endforeach;
            ?>
        </div>
        <?php endif; ?>
    </div>
</section>
<!-- Hero Section Ends -->


<?php get_footer(); ?>