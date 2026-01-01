<?php
// Get meta values
$banner_title        = carbon_get_the_post_meta( 'mit_banner_1_title' );
$banner_content      = carbon_get_the_post_meta( 'mit_banner_1_content' );
$btn_text_1          = carbon_get_the_post_meta( 'mit_banner_1_cta_btn_text_1' );
$btn_link_1          = carbon_get_the_post_meta( 'mit_banner_1_cta_btn_link_1' );
$btn_text_2          = carbon_get_the_post_meta( 'mit_banner_1_cta_btn_text_2' );
$btn_link_2          = carbon_get_the_post_meta( 'mit_banner_1_cta_btn_link_2' );
?>

<!-- Banner-1 Section Starts -->
<section class="banner-1-section bg-theme-light-gray">
    <div class="container mx-auto px-2 max-sm:pt-5">
        <div class="left-area xl:w-[100%] lg:h-[420px] flex flex-col justify-center">

            <?php if ( ! empty( $banner_title ) ) : ?>
                <h1 class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-5 font-semibold">
                    <?php echo esc_html( $banner_title ); ?>
                </h1>
            <?php endif; ?>

            <?php if ( ! empty( $banner_content ) ) : ?>
                <h2 class="text-black text-center text-balance text-md md:text-lg xl:text-xl xl:max-w-[1000px] mx-auto">
                    <?php echo esc_html( $banner_content ); ?>
                </h2>
            <?php endif; ?>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 my-10 max-lg:mb-15">

                <?php if ( ! empty( $btn_text_1 ) && ! empty( $btn_link_1 ) ) : ?>
                    <a
                        class="btn bg-transparent hover:bg-white text-black lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5 xl:px-9 xl:py-7 border-2 border-black"
                        href="<?php echo esc_url( $btn_link_1 ); ?>">
                        <?php echo esc_html( $btn_text_1 ); ?>
                    </a>
                <?php endif; ?>

                <?php if ( ! empty( $btn_text_2 ) && ! empty( $btn_link_2 ) ) : ?>
                    <a
                        class="btn bg-theme-light-blue hover:bg-theme-blue-hover text-black hover:text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5 xl:px-9 xl:py-7 border-2 border-theme-light-blue hover:border-theme-blue-hover"
                        href="<?php echo esc_url( $btn_link_2 ); ?>">
                        <?php echo esc_html( $btn_text_2 ); ?>
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</section>
<!-- Banner-1 Section Ends -->
