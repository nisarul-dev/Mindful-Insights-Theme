<?php get_header(); ?>

<!-- Single Post Hero Section -->
<section class="single-post-hero bg-theme-light-gray py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            
            <!-- Breadcrumb -->
            <div class="breadcrumb text-font-gray text-sm mb-6">
                <a href="<?php echo esc_url(home_url('/')); ?>" class="hover:text-theme-blue">Home</a>
                <span class="mx-2">/</span>
                <a href="<?php echo esc_url(get_permalink(get_option('page_for_posts'))); ?>" class="hover:text-theme-blue">Blog</a>
                <span class="mx-2">/</span>
                <span class="text-black"><?php the_title(); ?></span>
            </div>

            <!-- Post Title -->
            <h1 class="text-black text-balance text-2xl md:text-4xl xl:text-5xl font-semibold mb-6">
                <?php the_title(); ?>
            </h1>

            <!-- Post Meta -->
            <div class="post-meta flex flex-wrap items-center gap-4 text-font-gray text-md mb-8">
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0ZM8 14.4C4.5 14.4 1.6 11.5 1.6 8C1.6 4.5 4.5 1.6 8 1.6C11.5 1.6 14.4 4.5 14.4 8C14.4 11.5 11.5 14.4 8 14.4Z" fill="#666"/>
                        <path d="M8.8 4H7.2V8.8L11.2 11.2L12 9.9L8.8 8V4Z" fill="#666"/>
                    </svg>
                    <span><?php echo esc_html(get_the_date('M j, Y')); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M8 0C3.6 0 0 3.6 0 8C0 12.4 3.6 16 8 16C12.4 16 16 12.4 16 8C16 3.6 12.4 0 8 0ZM8 4C9.1 4 10 4.9 10 6C10 7.1 9.1 8 8 8C6.9 8 6 7.1 6 6C6 4.9 6.9 4 8 4ZM8 14C6 14 4.3 12.8 3.5 11C3.5 9 7.5 7.9 8 7.9C8.5 7.9 12.5 9 12.5 11C11.7 12.8 10 14 8 14Z" fill="#666"/>
                    </svg>
                    <span>By <?php echo esc_html(get_the_author()); ?></span>
                </div>
                <?php if (has_category()): ?>
                <div class="flex items-center gap-2">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14 2H9L8 0H2C0.9 0 0 0.9 0 2V14C0 15.1 0.9 16 2 16H14C15.1 16 16 15.1 16 14V4C16 2.9 15.1 2 14 2Z" fill="#666"/>
                    </svg>
                    <span><?php echo wp_kses_post(get_the_category_list(', ')); ?></span>
                </div>
                <?php endif; ?>
            </div>

        <?php endwhile; endif; ?>
    </div>
</section>

<!-- Post Content Section -->
<section class="single-post-content py-[78px] max-md:py-[40px]">
    <div class="container mx-auto px-5 lg:px-2">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            
            <!-- Main Content Area -->
            <div class="lg:col-span-8">
                <?php if (have_posts()): while (have_posts()): the_post(); ?>
                    <?php
                    $is_video = has_category('video'); // category slug
                    ?>
                    <?php if ( has_post_thumbnail() && ! $is_video ): ?>
                    <div class="featured-image mb-10 rounded-[20px] overflow-hidden">
                        <?php the_post_thumbnail('full', array('class' => 'w-full h-auto object-cover')); ?>
                    </div>
                    <?php endif; ?>

                    <div class="post-content prose prose-lg max-w-none text-font-gray leading-[32px]">
                        <?php the_content(); ?>
                    </div>

                    <!-- Tags -->
                    <?php if (has_tag()): ?>
                    <div class="post-tags mt-12 pt-8 border-t border-gray-200">
                        <div class="flex flex-wrap gap-3 items-center">
                            <span class="text-black font-semibold">Tags:</span>
                            <?php
                            $tags = get_the_tags();
                            if ($tags):
                                foreach ($tags as $tag): ?>
                                    <a href="<?php echo esc_url(get_tag_link($tag->term_id)); ?>" 
                                       class="bg-theme-light-gray hover:bg-theme-blue hover:text-white px-4 py-2 rounded-full text-sm transition-colors duration-300">
                                        <?php echo esc_html($tag->name); ?>
                                    </a>
                                <?php endforeach;
                            endif; ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Post Navigation -->
                    <div class="post-navigation mt-12 pt-8 border-t border-gray-200">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php
                            $prev_post = get_previous_post();
                            $next_post = get_next_post();
                            ?>
                            
                            <?php if (!empty($prev_post)): ?>
                            <a href="<?php echo esc_url(get_permalink($prev_post->ID)); ?>" 
                               class="flex items-center gap-3 p-5 bg-theme-light-gray hover:bg-gray-200 rounded-[20px] group">
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M0.81299 7.72461L7.68799 0.849608C7.9458 0.591796 8.28955 0.46289 8.6333 0.46289C9.02002 0.46289 9.36377 0.591796 9.62158 0.849608C10.1802 1.36523 10.1802 2.26758 9.62158 2.7832L5.10986 7.33789L18.2583 7.33789C19.0317 7.33789 19.6333 7.93945 19.6333 8.71289C19.6333 9.44336 19.0317 10.0879 18.2583 10.0879L5.10986 10.0879L9.62158 14.5996C10.1802 15.1152 10.1802 16.0176 9.62158 16.5332C9.10596 17.0918 8.20361 17.0918 7.68799 16.5332L0.812989 9.6582C0.254396 9.14258 0.254396 8.24023 0.81299 7.72461Z" fill="black"/>
                                </svg>
                                <div>
                                    <span class="text-sm text-font-gray block mb-1">Previous Post</span>
                                    <span class="text-black font-medium group-hover:text-theme-blue"><?php echo esc_html(get_the_title($prev_post->ID)); ?></span>
                                </div>
                            </a>
                            <?php endif; ?>

                            <?php if (!empty($next_post)): ?>
                            <a href="<?php echo esc_url(get_permalink($next_post->ID)); ?>" 
                               class="flex items-center justify-end gap-3 p-5 bg-theme-light-gray hover:bg-gray-200 rounded-[20px] group text-right">
                                <div>
                                    <span class="text-sm text-font-gray block mb-1">Next Post</span>
                                    <span class="text-black font-medium group-hover:text-theme-blue"><?php echo esc_html(get_the_title($next_post->ID)); ?></span>
                                </div>
                                <svg width="20" height="18" viewBox="0 0 20 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.2036 10.2012L12.3286 17.0762C12.0708 17.334 11.7271 17.4629 11.3833 17.4629C10.9966 17.4629 10.6528 17.334 10.395 17.0762C9.83643 16.5605 9.83643 15.6582 10.395 15.1426L14.9067 10.5879H1.7583C0.984863 10.5879 0.383301 9.98633 0.383301 9.21289C0.383301 8.48242 0.984863 7.83789 1.7583 7.83789H14.9067L10.395 3.32617C9.83643 2.81055 9.83643 1.9082 10.395 1.39258C10.9106 0.833984 11.813 0.833984 12.3286 1.39258L19.2036 8.26758C19.7622 8.7832 19.7622 9.68555 19.2036 10.2012Z" fill="black"/>
                                </svg>
                            </a>
                            <?php endif; ?>
                        </div>
                    </div>

                <?php endwhile; endif; ?>
            </div>

            <!-- Sidebar -->
            <aside class="lg:col-span-4">
                
                <!-- Recent Posts Widget -->
                <div class="widget bg-theme-light-gray rounded-[20px] p-8 mb-8">
                    <h3 class="text-black text-xl font-semibold mb-6">Recent Posts</h3>
                    <?php
                    $recent_posts = new WP_Query(array(
                        'post_type' => 'post',
                        'posts_per_page' => 5,
                        'post__not_in' => array(get_the_ID())
                    ));
                    
                    if ($recent_posts->have_posts()):
                        while ($recent_posts->have_posts()): $recent_posts->the_post(); ?>
                            <div class="recent-post-item mb-5 pb-5 border-b border-gray-200 last:border-0">
                                <a href="<?php echo esc_url(get_the_permalink()); ?>" 
                                   class="text-font-gray hover:text-theme-blue font-medium leading-[138%]">
                                    <?php the_title(); ?>
                                </a>
                                <div class="text-sm text-gray-500 mt-2">
                                    <?php echo esc_html(get_the_date('M j, Y')); ?>
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>

                <!-- Categories Widget -->
                <?php
                $categories = get_categories(array('hide_empty' => true));
                if (!empty($categories)):
                ?>
                <div class="widget bg-theme-light-gray rounded-[20px] p-8">
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

            </aside>

        </div>
    </div>
</section>

<style>
    .wp-block-embed.is-type-video iframe {
        width: 100%;
        height: 500px;
        object-fit: cover;
        border-radius: 20px;
    }
</style>

<?php get_footer(); ?>