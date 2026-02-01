<?php
/**
 * Template Name: About Page
 */

get_header()
?>

<?php get_template_part( 'template-parts/banner-1' ); ?>


<!-- Our Mission Section Starts -->
<section class="pt-10 pb-0 lg:pt-20 bg-white">
  <div class="container mx-auto px-5 lg:px-2 max-sm:pt-5">
    
    <!-- Heading -->
    <div class="text-center mb-14">
        <h2 class="text-2xl md:text-4xl font-[500] mb-6">
            <?php echo esc_html(get_carbon_field('mit_om_title')); ?>
        </h2>

        <p class="text-font-gray-light text-balance text-lg max-lg:text-[16px] leading-[32px] max-lg:leading-[1.7em] mb-11">
            <?php echo esc_html(get_carbon_field('mit_om_subtitle')); ?>
        </p>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-7 items-start">

            <!-- Image 1 -->
            <?php if ( get_carbon_field('mit_om_image_1') ) : ?>
                <div class="overflow-hidden rounded-3xl bg-gray-100 aspect-[3/4]">
                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_om_image_1'),
                        'large',
                        false,
                        [
                            'class' => 'w-full h-full object-cover'
                        ]
                    ); ?>
                </div>
            <?php endif; ?>

            <!-- Image 2 (OFFSET DOWN) -->
            <?php if ( get_carbon_field('mit_om_image_2') ) : ?>
                <div class="overflow-hidden rounded-3xl bg-gray-100 aspect-[3/4] lg:mt-10">
                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_om_image_2'),
                        'large',
                        false,
                        [
                            'class' => 'w-full h-full object-cover'
                        ]
                    ); ?>
                </div>
            <?php endif; ?>

            <!-- Image 3 -->
            <?php if ( get_carbon_field('mit_om_image_3') ) : ?>
                <div class="overflow-hidden rounded-3xl bg-gray-100 aspect-[3/4]">
                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_om_image_3'),
                        'large',
                        false,
                        [
                            'class' => 'w-full h-full object-cover'
                        ]
                    ); ?>
                </div>
            <?php endif; ?>

        </div>

  </div>
</section>
<!-- Our Mission Section Ends -->

<!-- Healing Through Understanding Section Starts -->
<section class="py-10 lg:pt-20 lg:pb-27 bg-white">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-14 items-center">

            <!-- Left Content -->
            <div>
                <h2 class="text-2xl md:text-4xl font-[500] mb-6">
                    <?php echo esc_html( get_carbon_field('mit_ht_title') ); ?>
                </h2>

                <div class="text-font-gray text-lg leading-[32px] mb-10">
                    <?php echo wp_kses_post( get_carbon_field('mit_ht_description') ); ?>
                </div>

                <?php if ( get_carbon_field('mit_ht_button_text') && get_carbon_field('mit_ht_button_link') ) : ?>
                    <a href="<?php echo esc_url( get_carbon_field('mit_ht_button_link') ); ?>"
                        class="inline-flex items-center gap-3 bg-theme-blue hover:bg-theme-blue-hover text-white text-lg font-medium px-8 py-4 rounded-full transition">

                        <?php echo esc_html( get_carbon_field('mit_ht_button_text') ); ?>

                        <svg width="18" height="15" viewBox="0 0 20 17" fill="none">
                            <path d="M18.82 9.37L11.95 16.24C11.69 16.5 11.34 16.63 11 16.63C10.61 16.63 10.27 16.5 10.01 16.24C9.45 15.73 9.45 14.82 10.01 14.31L14.52 9.75H1.38C0.6 9.75 0 9.15 0 8.38C0 7.65 0.6 7 1.38 7H14.52L10.01 2.49C9.45 1.98 9.45 1.07 10.01 0.56C10.53 0 11.43 0 11.95 0.56L18.82 7.43C19.38 7.95 19.38 8.85 18.82 9.37Z"
                                    fill="white"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>

            <!-- Right Image -->
            <div class="overflow-hidden rounded-3xl bg-gray-100">
                <?php
                if ( get_carbon_field('mit_ht_image') ) {
                    echo wp_get_attachment_image(
                        get_carbon_field('mit_ht_image'),
                        'large',
                        false,
                        [
                            'class' => 'w-full h-full object-cover'
                        ]
                    );
                }
                ?>
            </div>

        </div>
    </div>
</section>
<!-- Healing Through Understanding Section Ends -->


<!-- Seminar & Workshops Section Starts -->
<section class="seminar-workshops-section py-[20px] max-md:py-[10px]">
    <div class="container mx-auto px-5 lg:px-2 max-sm:pt-5">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            <!-- Left Image Grid -->
            <div class="image-grid grid max-[1520px]:grid-cols-2 grid-cols-3 grid-rows-2 gap-4">

                <!-- Large Image -->
                <a href="<?php echo esc_url( wp_get_attachment_image_url( get_carbon_field('mit_sw_image_1', '', 7), 'full' ) ); ?>"
                data-fancybox="seminar-gallery"
                class="col-span-2 row-span-2 lg:col-span-2 lg:row-span-2 block">

                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_sw_image_1', '', 7),
                        'large',
                        false,
                        [
                            'class' => 'rounded-[10px] w-full h-full max-[1520px]:max-h-[340px] object-cover cursor-zoom-in'
                        ]
                    ); ?>
                </a>

                <!-- Small Image 1 -->
                <a href="<?php echo esc_url( wp_get_attachment_image_url( get_carbon_field('mit_sw_image_2', '', 7), 'full' ) ); ?>"
                data-fancybox="seminar-gallery"
                class="block">

                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_sw_image_2', '', 7),
                        'large',
                        false,
                        [
                            'class' => 'rounded-[10px] w-full h-full object-cover cursor-zoom-in'
                        ]
                    ); ?>
                </a>

                <!-- Small Image 2 -->
                <a href="<?php echo esc_url( wp_get_attachment_image_url( get_carbon_field('mit_sw_image_3', '', 7), 'full' ) ); ?>"
                data-fancybox="seminar-gallery"
                class="block">

                    <?php echo wp_get_attachment_image(
                        get_carbon_field('mit_sw_image_3', '', 7),
                        'large',
                        false,
                        [
                            'class' => 'rounded-[10px] w-full h-full object-cover cursor-zoom-in'
                        ]
                    ); ?>
                </a>

            </div>


            <!-- Right Content -->
            <div class="right-area">
                <h2 class="text-black text-balance text-center md:text-left font-[500] text-2xl md:text-4xl mb-7">
                    <?php echo esc_html(get_carbon_field('mit_sw_title', '', 7)); ?>
                </h2>

                <div class="text-font-gray text-lg md:text-xl leading-[32px] mb-4">
                    <?php echo get_carbon_field('mit_sw_description_main', '', 7); ?>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Seminar & Workshops Section Ends -->

<!-- Gallery Section Starts -->
<section class="pt-10 pb-20 lg:py-20 bg-white">
  <div class="container mx-auto px-5 lg:px-2 max-sm:pt-5">
    
    <!-- Heading -->
    <div class="text-center mb-14">
        <h2 class="text-2xl md:text-4xl font-[500] mb-6">
            
            <?php echo esc_html(get_carbon_field('mit_gallery_title')); ?>
        </h2>

        <p class="text-font-gray-light text-balance text-lg max-lg:text-[16px] leading-[32px] max-lg:leading-[1.7em] mb-11">
            <?php echo esc_html(get_carbon_field('mit_gallery_subtitle')); ?>
        </p>

    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <?php
        $gallery_images = carbon_get_the_post_meta( 'mit_gallery_images' );

        if ( ! empty( $gallery_images ) ) :
            foreach ( $gallery_images as $item ) :
                if ( ! empty( $item['picture'] ) ) :
                    $full  = wp_get_attachment_image_url( $item['picture'], 'full' );
                    $large = wp_get_attachment_image_url( $item['picture'], 'large' );
                ?>
                    <a href="<?php echo esc_url( $full ); ?>"
                    data-fancybox="mit-gallery"
                    class="group block overflow-hidden rounded-3xl aspect-[4/3] bg-gray-100">

                        <img
                            src="<?php echo esc_url( $large ); ?>"
                            alt=""
                            class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                        >
                    </a>
                <?php
                endif;
            endforeach;
        endif;
        ?>
    </div>




  </div>
</section>
<!-- Gallery Section Ends -->


<?php get_template_part( 'template-parts/need-assistance' ); ?>

<?php get_template_part( 'template-parts/faq' ); ?>

<?php get_footer(); ?>