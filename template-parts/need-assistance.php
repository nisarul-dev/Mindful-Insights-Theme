<!-- Need Assistance Section Starts -->
<section class="need-assistance-section pt-[98px] pb-[98px]"
    style="background: url('<?php echo esc_url(wp_get_attachment_image_url( get_carbon_field('mit_na_section_bg_img', '', 'options'), 'full') ); ?>') center center no-repeat; background-size: cover;; ">
    <div class="container mx-auto px-10 lg:px-2">
        <h2
            class="text-white text-center md:text-left text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[24px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_na_title', '', 'options')); ?>
        </h2>
        
        <h2 class="text-white text-center md:text-left text-balance lg:text-wrap text-lg md:text-xl xl:text-2xl xl:w-[600px]">
            <?php echo esc_html(get_carbon_field('mit_na_content', '', 'options')); ?>
        </h2>

        <div class="book-a-free-consultation-container text-center md:text-left mt-10">
            <a class="btn bg-white text-theme-blue hover:bg-theme-bg-light-blue lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-12 xl:py-7 border-2 border-transparent"
                href="<?php echo esc_url(get_carbon_field('mit_na_cta_btn_link', '', 'options') ); ?>">
                <?php echo esc_html(get_carbon_field('mit_na_cta_btn_text', '', 'options') ); ?>
            </a>
        </div>

    </div>
</section>
<!--  Need Assistance Section Ends -->