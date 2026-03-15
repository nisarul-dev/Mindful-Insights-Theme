<?php
/**
 * Archive template for the Assessment CPT.
 * Lists all published assessments that have archive visibility enabled.
 *
 * @package mindful-insights-theme
 */

get_header();
?>

<!-- Archive Banner -->
<section class="assessment-archive-hero bg-theme-light-gray py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <!-- Breadcrumb -->
        <div class="breadcrumb text-font-gray text-sm mb-6">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="hover:text-theme-blue">Home</a>
            <span class="mx-2">/</span>
            <span class="text-black">Assessments</span>
        </div>

        <h1 class="text-black text-balance text-2xl md:text-4xl xl:text-5xl font-semibold mb-4">
            <?php post_type_archive_title(); ?>
        </h1>
        <p class="text-font-gray text-lg max-w-2xl">
            নিচের মূল্যায়নগুলো থেকে আপনার পছন্দেরটি বেছে নিন এবং নিজেকে আরও ভালোভাবে জানুন।
        </p>
    </div>
</section>

<!-- Assessment Cards -->
<section class="assessment-archive-list py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <?php
        // Query assessments visible in archive.
        $args = array(
            'post_type'      => 'assessment',
            'post_status'    => 'publish',
            'posts_per_page' => 12,
            'meta_query'     => array(
                array(
                    'key'     => '_mit_assessment_show_in_archive',
                    'value'   => 'yes',
                    'compare' => '=',
                ),
            ),
        );
        $assessments = new WP_Query( $args );
        ?>

        <?php if ( $assessments->have_posts() ) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <?php while ( $assessments->have_posts() ) : $assessments->the_post();
                $description = get_carbon_field( 'mit_assessment_description' );
                $banner_id   = get_carbon_field( 'mit_assessment_banner_image' );
                $questions   = carbon_get_the_post_meta( 'mit_assessment_questions' );
                $q_count     = is_array( $questions ) ? count( $questions ) : 0;
            ?>
            <article class="assessment-card bg-white rounded-[20px] shadow-sm hover:shadow-md transition-shadow duration-300 overflow-hidden flex flex-col">

                <!-- Card Image -->
                <?php if ( has_post_thumbnail() ) : ?>
                <div class="assessment-card-thumb h-[220px] overflow-hidden">
                    <?php the_post_thumbnail( 'large', array( 'class' => 'w-full h-full object-cover' ) ); ?>
                </div>
                <?php elseif ( $banner_id ) : ?>
                <div class="assessment-card-thumb h-[220px] overflow-hidden">
                    <?php echo wp_get_attachment_image( $banner_id, 'large', false, array( 'class' => 'w-full h-full object-cover' ) ); ?>
                </div>
                <?php endif; ?>

                <!-- Card Body -->
                <div class="p-6 flex flex-col flex-1">
                    <h2 class="text-black text-xl font-semibold mb-3">
                        <a href="<?php the_permalink(); ?>" class="hover:text-theme-blue transition-colors">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <?php if ( $description ) : ?>
                    <div class="text-font-gray text-sm leading-relaxed mb-4 line-clamp-3">
                        <?php echo wp_trim_words( wp_strip_all_tags( $description ), 25, '...' ); ?>
                    </div>
                    <?php endif; ?>

                    <!-- Meta -->
                    <?php if ( $q_count > 0 ) : ?>
                    <div class="flex items-center gap-2 text-sm text-font-gray mb-4">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
                        <?php echo esc_html( $q_count ); ?> টি প্রশ্ন
                    </div>
                    <?php endif; ?>

                    <!-- CTA -->
                    <div class="mt-auto">
                        <a href="<?php the_permalink(); ?>"
                           class="inline-flex items-center gap-2 bg-theme-blue text-white text-sm font-medium px-6 py-3 rounded-full hover:bg-theme-blue-hover transition-colors duration-300">
                            মূল্যায়ন শুরু করুন
                            <svg width="16" height="16" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z" fill="white"/>
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>

        <?php else : ?>
        <div class="text-center py-20">
            <div class="w-20 h-20 bg-theme-light-gray rounded-full flex items-center justify-center mx-auto mb-6">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#999" stroke-width="1.5"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 01-2 2H5a2 2 0 01-2-2V5a2 2 0 012-2h11"/></svg>
            </div>
            <h2 class="text-black text-2xl font-semibold mb-3">কোনো মূল্যায়ন পাওয়া যায়নি</h2>
            <p class="text-font-gray">এখনো কোনো মূল্যায়ন প্রকাশিত হয়নি। অনুগ্রহ করে পরে আবার আসুন।</p>
        </div>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
