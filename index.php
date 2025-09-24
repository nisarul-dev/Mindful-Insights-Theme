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
                    <div class="flex flex-col justify-between lg:flex-row">
                        <div class="left-area w-[48%]">
                            <h3 class="text-font-gray text-4xl font-medium mb-[54px] mt-[52px]"><?php echo esc_html( $slide['heading'] ); ?></h3>
                            <p class="text-font-gray text-lg/[32px] mb-[54px]">
                                <?php echo esc_html( $slide['description'] ); ?>
                            </p>

                            <div class="navigation">
                                <?php
                                    $prev = ( 0 >= ( $i - 1 ) ) ? count( $slides ) : $i - 1  ;
                                    $next = ( count( $slides ) >= ( $i + 1 ) ) ? $i + 1 :  1;
                                ?>
                                <a href="#slide<?php echo esc_attr( $prev ); ?>" class="btn bg-white hover:bg-gray-200 py-[24px] px-[30px] rounded-[50px] border-black mr-[14px]">
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.81299 7.72461L7.68799 0.849608C7.9458 0.591796 8.28955 0.46289 8.6333 0.46289C9.02002 0.46289 9.36377 0.591796 9.62158 0.849608C10.1802 1.36523 10.1802 2.26758 9.62158 2.7832L5.10986 7.33789L18.2583 7.33789C19.0317 7.33789 19.6333 7.93945 19.6333 8.71289C19.6333 9.44336 19.0317 10.0879 18.2583 10.0879L5.10986 10.0879L9.62158 14.5996C10.1802 15.1152 10.1802 16.0176 9.62158 16.5332C9.10596 17.0918 8.20361 17.0918 7.68799 16.5332L0.812989 9.6582C0.254396 9.14258 0.254396 8.24023 0.81299 7.72461Z" fill="black"/>
                                    </svg>
                                </a>
                                <a href="#slide<?php echo esc_attr( $next ); ?>" class="btn bg-theme-blue hover:bg-theme-blue-hover py-[24px] px-[30px] rounded-[50px] border-theme-blue">
                                    <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z" fill="white"/>
                                    </svg>
                                </a>
                            </div>
                        </div>
                        <div class="right-area w-[50%] text-right">
                            <?php
                            echo wp_get_attachment_image( $slide['image'], 'full', false, array( 
                                'class' => 'h-[580px] object-cover ml-auto mr-[20px] rounded-[20px]' 
                            ) );
                            ?>
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