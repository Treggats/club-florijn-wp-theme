<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div id="main-container" class="flex flex-col min-h-screen">
        <?php get_template_part('parts/header'); ?>

        <!-- Main Content -->
        <main id="main" class="site-main flex-grow">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-16">
                <!-- Main Content with Sidebar -->
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        <!-- Left Column - Posts (3 columns width) -->
                        <div class="lg:col-span-3">
                            <?php
                            // Configure which category to display posts from
                            // Change the value in the array below to your desired category ID
                            // Example: array( 2, 3 ) for multiple categories
                            $category_ids = [1];

                            $args = [
                                    'category__in' => $category_ids,
                                    'posts_per_page' => 10,
                                    'paged' => get_query_var( 'paged' ) ?: 1
                            ];
                            $posts = new WP_Query( $args );
                            if ($posts->have_posts()) : ?>
                                <div class="space-y-6">
                                    <?php
                                    if (is_active_sidebar('titel-top-sidebar')) {
                                        dynamic_sidebar('titel-top-sidebar');
                                    }
                                    ?>
                                    <?php while ($posts->have_posts()) : $posts->the_post(); ?>
                                        <article id="post-<?php the_ID(); ?>" class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-blue-900">
                                            <!-- Title -->
                                            <h2 class="text-2xl font-bold text-gray-900 mb-2">
                                                <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                                    <?php the_title(); ?>
                                                </a>
                                            </h2>

                                            <!-- Metadata -->
                                            <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                                                <time datetime="<?php echo get_the_date('c'); ?>">
                                                    <?php echo get_the_date('F j, Y'); ?>
                                                </time>
                                                <?php if (get_the_author()) : ?>
                                                    <span>|</span>
                                                    <span><?php esc_html_e('By', 'club_florijn'); ?> <strong><?php the_author(); ?></strong></span>
                                                <?php endif; ?>
                                            </div>

                                            <!-- Excerpt -->
                                            <div class="text-gray-700 mb-4">
                                                <?php
                                                if (has_excerpt()) {
                                                    echo get_the_excerpt();
                                                } else {
                                                    echo wp_trim_words(get_the_content(), 30);
                                                }
                                                ?>
                                            </div>

                                            <!-- Read More Link -->
                                            <a href="<?php the_permalink(); ?>" class="inline-block text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                                <?php esc_html_e('Read More', 'club_florijn'); ?> &rarr;
                                            </a>
                                        </article>
                                    <?php endwhile; ?>
                                    <?php wp_reset_postdata(); ?>
                                </div>

                                <!-- Pagination -->
                                <nav class="flex justify-center gap-4 mt-12" aria-label="Posts">
                                    <?php
                                    $pagination_args = array(
                                        'prev_text' => '&larr; ' . esc_html__('Newer Posts', 'club_florijn'),
                                        'next_text' => esc_html__('Older Posts', 'club_florijn') . ' &rarr;',
                                        'type' => 'list',
                                        'total' => $posts->max_num_pages,
                                    );
                                    echo paginate_links(array_merge($pagination_args, array(
                                        'current' => max(1, get_query_var('paged')),
                                        'format' => get_pagenum_link() . '%#%',
                                    )));
                                    ?>
                                </nav>

                            <?php else : ?>
                                <!-- No Posts Message -->
                                <div class="text-center py-12">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <h3 class="text-lg font-medium text-gray-900 mb-2">
                                        <?php esc_html_e('No posts found', 'club_florijn'); ?>
                                    </h3>
                                    <p class="text-gray-600 mb-6">
                                        <?php esc_html_e('Try using the search above or check back later.', 'club_florijn'); ?>
                                    </p>
                                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition-colors">
                                        <?php esc_html_e('Back to Home', 'club_florijn'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Right Sidebar - Agenda (1 column width) -->
                        <div class="lg:col-span-1">
                            <aside class="bg-white rounded-lg shadow-sm sticky top-24 mb-4">
                                <div>
                                <h3 class="text-xl font-bold text-gray-900 mx-8 pt-4">
                                    <?php esc_html_e('Ambassadeurs', 'club_florijn'); ?>
                                </h3>
                                    <?php
                                    if (is_active_sidebar('ambassadeurs-sidebar')) {
                                        dynamic_sidebar('ambassadeurs-sidebar');
                                    }
                                    ?>
                                </div>
                            </aside>
                            <aside class="bg-white rounded-lg p-8 shadow-sm sticky top-24 border-t-4 border-gray-50">
                                <h3 class="text-xl font-bold text-gray-900 mb-6">
                                    <?php esc_html_e('Bijeenkomsten', 'club_florijn'); ?>
                                </h3>

                                <!-- Dynamic Agenda from Categories or Custom Widget -->
                                <div class="space-y-3">
                                    <?php
                                    $categories = get_categories([
                                        'number' => 5,
                                        'hide_empty' => false,
                                    ]);

                                    if ($categories) :
                                        foreach ($categories as $category) : ?>
                                            <a href="<?php echo esc_url(get_category_link($category->term_id)); ?>" class="block text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                                                • <?php echo esc_html($category->name); ?>
                                                <span class="text-gray-500">(<?php echo $category->count; ?>)</span>
                                            </a>
                                        <?php endforeach;
                                    else : ?>
                                        <p class="text-gray-600 text-sm"><?php esc_html_e('No categories available', 'club_florijn'); ?></p>
                                    <?php endif; ?>
                                </div>
                            </aside>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer id="footer" class="bg-blue-900 text-blue-100 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <p class="text-sm">
                        &copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?>
                    </p>
                    <nav class="flex space-x-6">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'footer',
                            'fallback_cb' => false,
                            'container_class' => 'flex space-x-6',
                            'depth' => 1
                        ));
                        ?>
                    </nav>
                </div>
            </div>
        </footer>
    </div>

    <?php wp_footer(); ?>
</body>
</html>
