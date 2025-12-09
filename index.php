<?php get_header(); ?>

<!-- Blog Archive Hero Section -->
<section class="blog-archive-hero bg-theme-light-gray py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <h1 class="text-black text-center text-balance text-2xl md:text-4xl xl:text-5xl font-semibold mb-6">
            <?php
            if (is_category()) {
                single_cat_title('Category: ');
            } elseif (is_tag()) {
                single_tag_title('Tag: ');
            } elseif (is_author()) {
                echo 'Author: ' . get_the_author();
            } elseif (is_day()) {
                echo 'Daily Archives: ' . get_the_date();
            } elseif (is_month()) {
                echo 'Monthly Archives: ' . get_the_date('F Y');
            } elseif (is_year()) {
                echo 'Yearly Archives: ' . get_the_date('Y');
            } elseif (is_search()) {
                echo 'Search Results for: ' . get_search_query();
            } else {
                echo 'Latest Articles & Videos';
            }
            ?>
        </h1>
        
        <?php if (is_category() && category_description()): ?>
        <div class="category-description text-font-gray text-center text-lg max-w-3xl mx-auto">
            <?php echo category_description(); ?>
        </div>
        <?php endif; ?>

        <?php if (is_tag() && tag_description()): ?>
        <div class="tag-description text-font-gray text-center text-lg max-w-3xl mx-auto">
            <?php echo tag_description(); ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Blog Posts Section -->
<section class="blog-posts-section py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-8">
                
                <?php if (have_posts()): ?>
                    <div class="posts-grid grid grid-cols-1 md:grid-cols-2 gap-8">
                        <?php while (have_posts()): the_post(); ?>
                            <article class="post-card mb-10">
                                
                                <?php if (has_post_thumbnail()): ?>
                                <div class="image-container rounded-[20px] overflow-hidden relative mb-6 group">
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php the_post_thumbnail('full', array('class' => 'w-full h-[250px] object-cover group-hover:scale-105 transition-transform duration-300')); ?>
                                    </a>
                                    <div class="post-date absolute bottom-0 left-0 text-[14px] px-[16px] py-[8px] bg-[#F5F5F5]">
                                        <?php echo esc_html(get_the_date('M j, Y')); ?>
                                    </div>
                                </div>
                                <?php endif; ?>

                                <?php if (has_category()): ?>
                                <div class="post-categories mb-3">
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)):
                                        foreach (array_slice($categories, 0, 2) as $category): ?>
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                                               class="inline-block bg-theme-blue hover:bg-theme-blue-hover text-white text-xs px-3 py-1 rounded-full mr-2">
                                                <?php echo esc_html($category->name); ?>
                                            </a>
                                        <?php endforeach;
                                    endif;
                                    ?>
                                </div>
                                <?php endif; ?>

                                <h3 class="text-font-gray hover:text-theme-blue text-[18px] md:text-[20px] font-medium leading-[138%] mb-4">
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <?php if (has_excerpt()): ?>
                                <div class="post-excerpt text-font-gray text-[16px] leading-[24px] mb-6">
                                    <?php echo wp_trim_words(get_the_excerpt(), 20, '...'); ?>
                                </div>
                                <?php endif; ?>

                                <a class="text-font-gray text-[16px] md:text-[18px] font-bold flex items-center gap-1.5 hover:gap-2.5 duration-[300ms]" 
                                   href="<?php echo esc_url(get_the_permalink()); ?>">
                                    Read Article
                                    <svg width="18" height="15" viewBox="0 0 20 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M18.8203 9.36719L11.9453 16.2422C11.6875 16.5 11.3438 16.6289 11 16.6289C10.6133 16.6289 10.2695 16.5 10.0117 16.2422C9.45312 15.7266 9.45312 14.8242 10.0117 14.3086L14.5234 9.75391H1.375C0.601562 9.75391 0 9.15234 0 8.37891C0 7.64844 0.601562 7.00391 1.375 7.00391H14.5234L10.0117 2.49219C9.45312 1.97656 9.45312 1.07422 10.0117 0.558594C10.5273 0 11.4297 0 11.9453 0.558594L18.8203 7.43359C19.3789 7.94922 19.3789 8.85156 18.8203 9.36719Z" fill="black"/>
                                    </svg>
                                </a>
                            </article>
                        <?php endwhile; ?>
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-container mt-12">
                        <div class="flex items-center justify-center gap-2">
                            <?php
                            global $wp_query;
                            $big = 999999999;
                            
                            $pagination = paginate_links(array(
                                'base' => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
                                'format' => '?paged=%#%',
                                'current' => max(1, get_query_var('paged')),
                                'total' => $wp_query->max_num_pages,
                                'prev_text' => '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.81299 7.72461L7.68799 0.849608C7.9458 0.591796 8.28955 0.46289 8.6333 0.46289C9.02002 0.46289 9.36377 0.591796 9.62158 0.849608C10.1802 1.36523 10.1802 2.26758 9.62158 2.7832L5.10986 7.33789L18.2583 7.33789C19.0317 7.33789 19.6333 7.93945 19.6333 8.71289C19.6333 9.44336 19.0317 10.0879 18.2583 10.0879L5.10986 10.0879L9.62158 14.5996C10.1802 15.1152 10.1802 16.0176 9.62158 16.5332C9.10596 17.0918 8.20361 17.0918 7.68799 16.5332L0.812989 9.6582C0.254396 9.14258 0.254396 8.24023 0.81299 7.72461Z" fill="currentColor"/></svg>',
                                'next_text' => '<svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z" fill="currentColor"/></svg>',
                                'type' => 'array',
                                'mid_size' => 2,
                                'end_size' => 1
                            ));
                            
                            if ($pagination) {
                                foreach ($pagination as $page) {
                                    echo $page;
                                }
                            }
                            ?>
                        </div>
                    </div>

                <?php else: ?>
                    <div class="no-posts text-center py-20">
                        <h2 class="text-black text-2xl font-semibold mb-4">No Posts Found</h2>
                        <p class="text-font-gray text-lg mb-8">
                            <?php if (is_search()): ?>
                                Sorry, no posts matched your search criteria. Please try again with different keywords.
                            <?php else: ?>
                                There are no posts available at this time. Please check back later.
                            <?php endif; ?>
                        </p>
                        <a class="btn bg-theme-blue hover:bg-theme-blue-hover text-white lg:text-lg xl:text-xl font-medium rounded-full px-15 sm:px-6 py-5 xl:px-9 xl:py-7 border-2 border-transparent" 
                           href="<?php echo esc_url(home_url('/')); ?>">
                            Return to Homepage
                        </a>
                    </div>
                <?php endif; ?>

            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                
                <!-- Search Widget -->
                <div class="widget bg-theme-light-gray rounded-[20px] p-8 mb-8">
                    <h3 class="text-black text-xl font-semibold mb-6">Search</h3>
                    <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="flex gap-2">
                            <input type="search" 
                                   class="flex-1 px-4 py-3 rounded-full border border-gray-300 focus:outline-none focus:border-theme-blue" 
                                   placeholder="Search articles..." 
                                   value="<?php echo get_search_query(); ?>" 
                                   name="s" />
                            <button type="submit" 
                                    class="bg-theme-blue hover:bg-theme-blue-hover text-white px-6 py-3 rounded-full">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.7555 18.6065L16.3182 15.2458C17.7753 13.6192 18.6367 11.481 18.6367 9.14142C18.6367 4.09375 14.5429 0 9.49527 0C4.44759 0 0.353821 4.09375 0.353821 9.14142C0.353821 14.1891 4.44759 18.2828 9.49527 18.2828C11.6855 18.2828 13.7108 17.5284 15.3326 16.2514L18.7945 19.6396C19.0152 19.8603 19.535 20 19.7752 20C20.0154 20 20.535 19.8603 20.7559 19.6396C21.1974 19.1981 21.1974 18.5279 19.7555 18.6065ZM9.49527 2.65993C13.0719 2.65993 15.9768 5.56476 15.9768 9.14142C15.9768 12.7181 13.0719 15.6229 9.49527 15.6229C5.91861 15.6229 3.01375 12.7181 3.01375 9.14142C3.01375 5.56476 5.91861 2.65993 9.49527 2.65993Z" fill="white"/>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Categories Widget -->
                <?php
                $categories = get_categories(array('hide_empty' => true));
                if (!empty($categories)):
                ?>
                <div class="widget bg-theme-light-gray rounded-[20px] p-8 mb-8">
                    <h3 class="text-black text-xl font-semibold mb-6">Categories</h3>
                    <ul class="space-y-3">
                        <?php foreach ($categories as $category): ?>
                        <li>
                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" 
                               class="text-font-gray hover:text-theme-blue flex items-center justify-between group">
                                <span><?php echo esc_html($category->name); ?></span>
                                <span class="text-sm text-gray-500">(<?php echo esc_html($category->count); ?>)</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <!-- Recent Posts Widget -->
                <div class="widget bg-theme-light-gray rounded-[20px] px-8 pt-8 pb-0 mb-8">
                    <h3 class="text-black text-xl font-semibold mb-6">Recent Posts</h3>
                    <?php
                    $recent_posts = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 5,
                        'ignore_sticky_posts' => true
                    ));
                    
                    if ($recent_posts->have_posts()):
                        while ($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                            <div class="recent-post-item mb-5 pb-5 border-b border-gray-200 last:border-0">
                                <?php if (has_post_thumbnail()): ?>
                                <div class="flex gap-4 mb-3">
                                    <a href="<?php echo esc_url(get_the_permalink()); ?>" class="flex-shrink-0">
                                        <?php the_post_thumbnail('thumbnail', array('class' => 'w-[80px] h-[80px] object-cover rounded-[10px]')); ?>
                                    </a>
                                    <div class="flex-1">
                                        <a href="<?php echo esc_url(get_the_permalink()); ?>" 
                                           class="text-font-gray hover:text-theme-blue font-medium text-[15px] leading-[138%] block mb-2">
                                            <?php echo wp_trim_words(get_the_title(), 8, '...'); ?>
                                        </a>
                                        <div class="text-xs text-gray-500">
                                            <?php echo esc_html(get_the_date('M j, Y')); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php else: ?>
                                <a href="<?php echo esc_url(get_the_permalink()); ?>" 
                                   class="text-font-gray hover:text-theme-blue font-medium leading-[138%]">
                                    <?php the_title(); ?>
                                </a>
                                <div class="text-sm text-gray-500 mt-2">
                                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <!-- Popular Tags Widget -->
                <?php
                $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 20));
                if (!empty($tags)):
                ?>
                <div class="widget bg-theme-light-gray rounded-[20px] p-8">
                    <h3 class="text-black text-xl font-semibold mb-6">Popular Tags</h3>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach ($tags as $tag): ?>
                        <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                           class="bg-white hover:bg-theme-blue hover:text-white px-4 py-2 rounded-full text-sm transition-colors duration-300">
                            <?php echo esc_html($tag->name); ?>
                        </a>
                        <?php endforeach; ?>
                    </div>
                </div>
                <?php endif; ?>

            </aside>

        </div>
    </div>
</section>

<?php get_footer(); ?>