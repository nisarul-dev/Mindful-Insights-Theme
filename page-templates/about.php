<?php
/**
 * Template Name: About Page
 */

get_header()
?>

<?php get_template_part( 'template-parts/banner-1' ); ?>


<!-- Our Mission Section Starts -->
<section class="py-20 bg-white">
  <div class="container mx-auto px-5 lg:px-2 max-sm:pt-5">
    
    <!-- Heading -->
    <div class="text-center mb-14">
        <h2 class="text-2xl md:text-4xl font-[600] mb-6">
            <?php echo esc_html(get_carbon_field('mit_om_title')); ?>
        </h2>

        <p class="text-font-gray-light text-balance text-lg max-lg:text-[16px] leading-[32px] max-lg:leading-[1.7em] mb-11">
            <?php echo esc_html(get_carbon_field('mit_om_subtitle')); ?>
        </p>

    </div>

    <!-- Main Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
    </div>

  </div>
</section>
<!-- Our Mission Section Ends -->

<!-- Gallery Section Starts -->
<section class="py-20 bg-white">
  <div class="container mx-auto px-5 lg:px-2 max-sm:pt-5">
    
    <!-- Heading -->
    <div class="text-center mb-14">
        <h2 class="text-2xl md:text-4xl font-[600] mb-6">
            
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