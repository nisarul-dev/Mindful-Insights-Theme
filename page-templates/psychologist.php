<?php
/**
 * Template Name: Psychologist Page
 */

get_header()
?>
<?php
$args = array(
    'post_type'      => 'psychologist',
    'posts_per_page' => -1,
);

$query = new WP_Query($args);

if ($query->have_posts()) :
?>
<section class="py-[80px] bg-white">
    <div class="container max-w-[1200px] mx-auto px-6">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-[40px]">

            <?php while ($query->have_posts()) : $query->the_post(); ?>

                <div class="bg-[#F2FAFF] px-[18px] md:px-[58px] py-[63px] text-center md:text-left">

                    <!-- Avatar -->
                    <?php if (has_post_thumbnail()) : ?>
                        <?php the_post_thumbnail('medium', [
                            'class' => 'w-[110px] h-[110px] rounded-full m-auto md:ml-0 mb-[20px] object-cover'
                        ]); ?>
                    <?php endif; ?>

                    <!-- Name -->
                    <h3 class="text-[#213D34] text-[21px] xl:text-[25px] font-medium mb-[6px]">
                        <?php the_title(); ?>
                        <span>
                            (<?php echo esc_html(get_carbon_field('mit_psy_designation')); ?>)
                        </span>
                    </h3>

                    <!-- Qualifications -->
                    <div class="text-[#213D34] text-[14px] md:text-[15px] leading-[26px] mt-[16px] mb-[30px] text-balance">
                        <?php echo nl2br(esc_html(get_carbon_field('mit_psy_qualification'))); ?>
                    </div>

                    <!-- Fee Button -->
                    <a href="<?php echo esc_url(get_carbon_field('mit_psy_cta_link')); ?>"
                       class="inline-block bg-theme-blue hover:bg-theme-blue-hover text-white text-[14px] md:text-[16px] font-medium px-[36px] py-[14px] rounded-full transition"
                       target="_blank"
                    >
                        <?php echo esc_html(get_carbon_field('mit_psy_cta_text')); ?>
                    </a>

                </div>

            <?php endwhile; ?>

        </div>

    </div>
</section>
<?php
endif;
wp_reset_postdata();
?>


<?php get_template_part( 'template-parts/need-assistance' ); ?>

<?php get_template_part( 'template-parts/faq' ); ?>

<?php get_footer(); ?>