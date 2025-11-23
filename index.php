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

<!-- Why Online Counseling Section Starts -->
<section class="why-online-counseling-section py-[78px]">
    <div class="container mx-auto px-5 md:px-2 max-sm:pt-5">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] max-md:mb-[40px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_woc_title')); ?>
        </h1>

        <?php if (get_carbon_field('mit_woc_slides')): ?>
            <div class="carousel w-full">
                <?php
                $i = 1;
                $slides = get_carbon_field('mit_woc_slides');
                $count_slides = count($slides);
                foreach ($slides as $slide):
                    ?>
                    <div id="slide<?php echo esc_attr($i); ?>" class="carousel-item relative w-full">
                        <div class="flex flex-col justify-between lg:flex-row">
                            <div class="left-area w-[48%] max-lg:w-[100%]">
                                <h3 class="text-font-gray text-4xl max-md:text-xl font-medium mb-[54px] max-md:mb-[24px] mt-[52px] max-md:mt-[24px]">
                                    <?php echo esc_html($slide['heading']); ?>
                                </h3>
                                <p class="text-font-gray text-lg/[32px] max-lg:text-[16px]/[24px] mb-[54px] max-lg:mb-[42px]">
                                    <?php echo esc_html($slide['description']); ?>
                                </p>

                                <div class="navigation max-lg:text-center">
                                    <?php
                                    $prev = (0 >= ($i - 1)) ? $count_slides : $i - 1;
                                    $next = ($count_slides >= ($i + 1)) ? $i + 1 : 1;
                                    ?>
                                    <a href="#slide<?php echo esc_attr($prev); ?>"
                                        class="btn bg-white hover:bg-gray-200 py-[24px] px-[30px] rounded-[50px] border-black mr-[14px]">
                                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M0.81299 7.72461L7.68799 0.849608C7.9458 0.591796 8.28955 0.46289 8.6333 0.46289C9.02002 0.46289 9.36377 0.591796 9.62158 0.849608C10.1802 1.36523 10.1802 2.26758 9.62158 2.7832L5.10986 7.33789L18.2583 7.33789C19.0317 7.33789 19.6333 7.93945 19.6333 8.71289C19.6333 9.44336 19.0317 10.0879 18.2583 10.0879L5.10986 10.0879L9.62158 14.5996C10.1802 15.1152 10.1802 16.0176 9.62158 16.5332C9.10596 17.0918 8.20361 17.0918 7.68799 16.5332L0.812989 9.6582C0.254396 9.14258 0.254396 8.24023 0.81299 7.72461Z"
                                                fill="black" />
                                        </svg>
                                    </a>
                                    <a href="#slide<?php echo esc_attr($next); ?>"
                                        class="btn bg-theme-blue hover:bg-theme-blue-hover py-[24px] px-[30px] rounded-[50px] border-theme-blue">
                                        <svg width="20" height="18" viewBox="0 0 20 18" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z"
                                                fill="white" />
                                        </svg>
                                    </a>
                                </div>
                                <div class="number text-black font-syne text-4xl  mt-[70px] max-lg:hidden">
                                    <?php echo esc_html(sprintf("%02d", $i)); ?>/<?php echo esc_html(sprintf("%02d", $count_slides)); ?>
                                </div>
                            </div>
                            <div class="right-area w-[50%] max-lg:w-[100%] text-right pr-[20px] max-lg:pr-0 max-lg:mt-[50px]">
                                <?php
                                echo wp_get_attachment_image($slide['image'], 'full', false, array(
                                    'class' => 'h-[580px] max-lg:h-[380px] object-cover ml-auto rounded-[20px]'
                                ));
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
<!-- Why Online Counseling Section Ends -->


<!-- Explore our Services Section Starts -->
<section class="why-online-counseling-section py-[78px] bg-theme-bg-light-blue">
    <div class="container mx-auto px-3 lg:px-2">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_eos_title')); ?>
        </h1>
        <?php
        if (get_carbon_field('mit_eos_cards')):
            $eos_cards = get_carbon_field('mit_eos_cards');
            ?>
            <div class="cards-container grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-5">
                <?php foreach ($eos_cards as $eos_card): ?>
                    <a class="card-item bg-white hover:bg-gray-100 shadow-[4px_4px_10px_0px_rgba(0,0,0,0.15)] rounded-[20px] p-[15px] md:p-[25px]"
                        href="<?php echo esc_url($eos_card['link']); ?>">
                        <div class="image-container">
                            <?php
                            echo wp_get_attachment_image($eos_card['icon'], 'full', false, array(
                                'class' => 'h-[45px] md:h-[52px] object-contain mb-[20px] max-md:mx-auto'
                            ));
                            ?>
                        </div>
                        <h3 class="text-font-gray text-[15px] md:text-[18px] font-medium max-md:text-center">
                            <?php echo esc_html($eos_card['title']); ?>
                        </h3>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Explore our Services Section Ends -->

<!-- Meet Our Full Team Section Starts -->
<section class="meet-our-full-team-section py-[78px]">
    <div class="container mx-auto px-10 lg:px-2">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_moft_title')); ?>
        </h1>
        <?php
        if (get_carbon_field('mit_moft_cards')):
            $moft_cards = get_carbon_field('mit_moft_cards');
            ?>
            <div class="cards-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php foreach ($moft_cards as $moft_card): ?>
                    <a class="card-item bg-theme-light-gray hover:bg-gray-200 rounded-[20px] p-[15px] py-[40px] md:p-[20px] md:py-[40px]"
                        href="<?php echo esc_url($moft_card['link']); ?>">
                        <div class="image-container">
                            <?php
                            echo wp_get_attachment_image($moft_card['avatar'], 'full', false, array(
                                'class' => 'w-[120px] h-[120px] md:w-[120px] md:h-[120px] object-cover mb-[20px] rounded-[100%] mx-auto'
                            ));
                            ?>
                        </div>
                        <!-- <div class="self-stretch text-center justify-start text-neutral-700 text-2xl font-medium font-['Work_Sans']">MST. Musfika Akter (Physiologist)</div> -->
                        <h3
                            class="text-font-gray text-center text-[18px] md:text-[20px] lg:text-[17px] xl:text-[20px] font-medium">
                            <?php echo esc_html($moft_card['name']); ?>
                        </h3>
                        <p
                            class="text-font-gray text-center text-[18px] md:text-[20px] lg:text-[17px] xl:text-[20px] font-medium">
                            <?php echo esc_html($moft_card['position']); ?>
                        </p>
                    </a>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Meet Our Full Team Section Ends -->


<!-- Testimonials Section Starts -->
<section class="testimonials-section pt-[78px] pb-[38px] bg-theme-bg-light-blue">
    <div class="container mx-auto px-10 lg:px-2">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_tm_title')); ?>
        </h1>
        <?php
        if (get_carbon_field('mit_tm_cards')):
            $mit_tm_cards = get_carbon_field('mit_tm_cards');
            ?>
            <div id="stats" class="cards-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
                <?php foreach ($mit_tm_cards as $mit_tm_card): ?>
                    <div class="card-item mb-10">
                        <div class="image-container">
                            <?php
                            echo wp_get_attachment_image($mit_tm_card['icon'], 'full', false, array(
                                'class' => 'w-[80px] h-[80px] object-cover mb-[30px] mx-auto'
                            ));
                            ?>
                        </div>
                        <h3
                            class="text-center text-[22px] text-[#213D34] md:text-[24px] lg:text-[28px] xl:text-[30px] font-semibold mb-[18px]">
                            <span class="counter"
                                data-target="<?php echo esc_attr($mit_tm_card['number']); ?>"><?php echo esc_html($mit_tm_card['number']); ?></span><?php echo esc_html($mit_tm_card['suffix']); ?>
                        </h3>
                        <p class="text-[#213D34] text-center text-[18px] font-medium text-balance">
                            <?php echo esc_html($mit_tm_card['content']); ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<!-- Testimonials Section Ends -->

<!-- Latest Articles and Video Section Starts -->
<section class="latest-articles-and-video-section pt-[78px] pb-[38px]">
    <div class="container mx-auto px-10 lg:px-2">
        <h1
            class="text-black text-center text-balance lg:text-wrap text-2xl md:text-4xl/12 xl:text-5xl/15 mb-[64px] font-semibold">
            <?php echo esc_html(get_carbon_field('mit_lav_title')); ?>
        </h1>
        <?php
        if (have_posts()):
            ?>
            <div class="cards-container grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                <?php
                $args = array(
                    'post_type' => 'post',
                    'posts_per_page' => 3,
                );

                $random_query = new WP_Query($args);
                while ($random_query->have_posts()):
                    $random_query->the_post(); ?>
                    <div class="card-item mb-10">
                        <?php if (get_the_post_thumbnail()): ?>
                            <div class="image-container rounded-[20px] overflow-hidden relative">
                                <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                    <?php echo the_post_thumbnail(); ?>
                                </a>
                                <div class="post-date absolute bottom-0 font-[14px] px-[16px] py-[8px] bg-[#F5F5F5]">
                                    <?php echo esc_html(get_the_date('M j, Y')); ?></div>
                                <?php
                                // echo wp_get_attachment_image($moft_card['avatar'], 'full', false, array(
                                //     'class' => 'w-[120px] h-[120px] md:w-[120px] md:h-[120px] object-cover mb-[20px] rounded-[100%] mx-auto'
                                // ));
                                ?>
                            </div>
                        <?php endif; ?>
                        <!-- <div class="self-stretch text-center justify-start text-neutral-700 text-2xl font-medium font-['Work_Sans']">MST. Musfika Akter (Physiologist)</div> -->
                        <h3
                            class="text-font-gray hover:text-theme-blue-hover text-[18px] md:text-[20px] leading-[138%] mt-6 mb-8">
                            <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                <?php the_title(); ?>
                            </a>
                        </h3>
                        <a class="text-font-gray text-[18px] md:text-[18px] font-bold flex items-center gap-1.5 hover:gap-2.5 duration-[300ms]"
                            href="<?php echo esc_url(get_the_permalink()); ?>">
                            Read Article
                            <svg width="18" height="15" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M18.8203 9.36719L11.9453 16.2422C11.6875 16.5 11.3438 16.6289 11 16.6289C10.6133 16.6289 10.2695 16.5 10.0117 16.2422C9.45312 15.7266 9.45312 14.8242 10.0117 14.3086L14.5234 9.75391H1.375C0.601562 9.75391 0 9.15234 0 8.37891C0 7.64844 0.601562 7.00391 1.375 7.00391H14.5234L10.0117 2.49219C9.45312 1.97656 9.45312 1.07422 10.0117 0.558594C10.5273 0 11.4297 0 11.9453 0.558594L18.8203 7.43359C19.3789 7.94922 19.3789 8.85156 18.8203 9.36719Z"
                                    fill="black" />
                            </svg>
                        </a>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php
        endif;
        wp_reset_postdata();
        ?>
        <div class="show-all-btn-container text-center mt-5 mb-8">
            <a class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5  xl:px-9 xl:py-7 border-2 border-transparent"
                href="<?php echo esc_url(get_carbon_field('mit_lav_cta_btn_link')); ?>">
                <?php echo esc_html(get_carbon_field('mit_lav_cta_btn_text')); ?>
            </a>
        </div>

    </div>
</section>
<!-- Latest Articles and Video Section Ends -->


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

<?php get_footer(); ?>