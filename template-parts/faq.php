<!-- FAQ Section Starts  -->
<section class="faq-section pt-[78px] pb-[58px]">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="grid grid-cols-1 md:grid-cols-2 md:gap-12">
            <div class="left-area">
                <h2 class="text-black text-center md:text-left text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[34px] font-semibold">
                    <?php echo esc_html(get_carbon_field('mit_faq_title', '', 'options') ); ?>
                </h2>

                <p class="text-font-gray text-center md:text-left text-lg/[32px] max-lg:text-[16px]/[24px] mb-[44px] max-lg:mb-[42px]">
                    <?php echo esc_html(get_carbon_field('mit_faq_content', '', 'options') ); ?>
                </p>

                <?php 
                if (get_carbon_field('mit_faq_left_area_cards', '', 'options') ) :
                    foreach ( get_carbon_field('mit_faq_left_area_cards', '', 'options') as $faq ) :
                ?>
                <div class="collapse collapse-plus bg-theme-light-gray border border-base-300 mb-[22px]">
                    <input type="radio" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-lg md:text-xl"><?php echo esc_html( $faq['question'] ); ?></div>
                    <div class="collapse-content text-md"><?php echo esc_html( $faq['answer'] ); ?></div>
                </div>
                <?php
                    endforeach; 
                endif; 
                ?>
            </div>
            <div class="right-area">
                <?php 
                if (get_carbon_field('mit_faq_right_area_cards', '', 'options') ) :
                    foreach ( get_carbon_field('mit_faq_right_area_cards', '', 'options') as $faq ) :
                ?>
                <div class="collapse collapse-plus bg-theme-light-gray border border-base-300 mb-[22px]">
                    <input type="radio" name="my-accordion-3" />
                    <div class="collapse-title font-semibold text-lg md:text-xl"><?php echo esc_html( $faq['question'] ); ?></div>
                    <div class="collapse-content text-md"><?php echo esc_html( $faq['answer'] ); ?></div>
                </div>
                <?php
                    endforeach; 
                endif; 
                ?>
            </div>
        </div>
    </div>
</section>
<!-- FAQ Section Ends  -->
