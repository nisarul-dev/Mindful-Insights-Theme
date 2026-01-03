<?php
/**
 * Template Name: Services Page
 */

get_header()
?>

<?php get_template_part( 'template-parts/banner-1' ); ?>

<!-- Services Section Starts -->
<section class="services-page-section py-[78px]">
    <div class="container mx-auto px-5 lg:px-2">

        <!-- Services -->
        <?php if ( $services = get_carbon_field( 'mit_services_page_items' ) ) : ?>
            <div class="service-item space-y-[96px]" 
            <?php if ( isset( $service['id'] ) && ! empty( $service['id'] ) ) : ?>
            id="<?php echo esc_attr( $service['id'] ); ?>"
            <?php endif; ?>
            >
                <?php foreach ( $services as $service ) : 
                    $image_position = $service['layout'] ?? 'right';
                ?>

                    <div class="flex flex-col 
                        <?php echo $image_position === 'left' ? 'lg:flex-row-reverse' : 'lg:flex-row'; ?> 
                        gap-12 items-center">

                        <!-- Content -->
                        <div class="lg:w-1/2">
                            <h3 class="text-2xl md:text-3xl font-[500] mb-6">
                                <?php echo esc_html( $service['title'] ); ?>
                            </h3>

                            <p class="text-font-gray text-lg leading-[32px] mb-11">
                                <?php echo wp_kses_post( $service['description'] ); ?>
                            </p>

                            <?php if ( ! empty( $service['cta_link'] ) ) : ?>
                                <a href="<?php echo esc_url( $service['cta_link'] ); ?>"
                                   class="inline-flex items-center gap-3 bg-theme-blue hover:bg-theme-blue-hover text-white text-lg font-medium px-8 py-4 rounded-full transition">

                                    <?php echo esc_html( $service['cta_text'] ?: 'View Consultants' ); ?>

                                    <svg width="18" height="15" viewBox="0 0 20 17" fill="none">
                                        <path d="M18.82 9.37L11.95 16.24C11.69 16.5 11.34 16.63 11 16.63C10.61 16.63 10.27 16.5 10.01 16.24C9.45 15.73 9.45 14.82 10.01 14.31L14.52 9.75H1.38C0.6 9.75 0 9.15 0 8.38C0 7.65 0.6 7 1.38 7H14.52L10.01 2.49C9.45 1.98 9.45 1.07 10.01 0.56C10.53 0 11.43 0 11.95 0.56L18.82 7.43C19.38 7.95 19.38 8.85 18.82 9.37Z"
                                              fill="white"/>
                                    </svg>
                                </a>
                            <?php endif; ?>
                        </div>

                        <!-- Image -->
                        <div class="lg:w-1/2">
                            <?php
                            echo wp_get_attachment_image(
                                $service['image'],
                                'full',
                                false,
                                array(
                                    'class' => 'w-full h-[560px] object-cover rounded-[24px]'
                                )
                            );
                            ?>
                        </div>

                    </div>

                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>
</section>
<!-- Services Section Ends -->


<?php get_template_part( 'template-parts/need-assistance' ); ?>

<?php get_template_part( 'template-parts/faq' ); ?>

<?php get_footer(); ?>