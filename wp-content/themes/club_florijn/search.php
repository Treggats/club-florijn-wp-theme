<?php
/**
 * The template for displaying search results pages
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <title><?php wp_title(); ?> - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div id="main-container" class="flex flex-col min-h-screen">
        <?php get_template_part('header'); ?>

        <!-- Main Content -->
        <main id="main" class="site-main flex-grow">
            <div class="w-full px-4 sm:px-6 lg:px-8 py-16">
                <!-- Search Bar - Centered -->
                <section class="flex justify-center mb-16">
                    <form role="search" method="get" class="w-full max-w-lg" action="<?php echo esc_url(home_url('/')); ?>">
                        <div class="relative">
                            <input
                                type="search"
                                placeholder="Zoeken"
                                value="<?php echo get_search_query(); ?>"
                                name="s"
                                class="w-full px-6 py-4 border-2 border-yellow-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent text-lg"
                                aria-label="<?php esc_attr_e('Search Posts', 'club_florijn'); ?>"
                            >
                            <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-yellow-500 hover:text-yellow-600 transition-colors">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </section>

                <!-- Results Info -->
                <div class="max-w-4xl mx-auto mb-12">
                    <h2 class="text-2xl font-bold text-gray-900 mb-2">
                        <?php esc_html_e('Search Results for:', 'club_florijn'); ?> "<span class="text-blue-600"><?php echo get_search_query(); ?></span>"
                    </h2>
                    <p class="text-gray-600">
                        <?php printf(
                            esc_html__('Found %s result(s)', 'club_florijn'),
                            number_format_i18n($wp_query->found_posts)
                        ); ?>
                    </p>
                </div>

                <!-- Posts List -->
                <?php if (have_posts()) : ?>
                    <div class="max-w-4xl mx-auto space-y-6">
                        <?php while (have_posts()) : the_post(); ?>
                            <article id="post-<?php the_ID(); ?>" class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-blue-900">
                                <!-- Title -->
                                <h3 class="text-xl font-bold text-gray-900 mb-2">
                                    <a href="<?php the_permalink(); ?>" class="hover:text-blue-600 transition-colors">
                                        <?php the_title(); ?>
                                    </a>
                                </h3>

                                <!-- Metadata -->
                                <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('F j, Y'); ?>
                                    </time>

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
                    </div>

                    <!-- Pagination -->
                    <nav class="flex justify-center gap-4 mt-12" aria-label="Posts">
                        <?php
                        $pagination_args = array(
                            'prev_text' => '&larr; ' . esc_html__('Newer Results', 'club_florijn'),
                            'next_text' => esc_html__('Older Results', 'club_florijn') . ' &rarr;',
                            'type' => 'list',
                        );
                        the_posts_pagination($pagination_args);
                        ?>
                    </nav>

                <?php else : ?>
                    <!-- No Results Message -->
                    <div class="text-center py-12 max-w-lg mx-auto">
                        <svg class="mx-auto h-12 w-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="text-lg font-medium text-gray-900 mb-2">
                            <?php esc_html_e('No search results found', 'club_florijn'); ?>
                        </h3>
                        <p class="text-gray-600 mb-6">
                            <?php esc_html_e('Try a different search term.', 'club_florijn'); ?>
                        </p>
                        <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-6 py-2 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition-colors">
                            <?php esc_html_e('Back to Home', 'club_florijn'); ?>
                        </a>
                    </div>
                <?php endif; ?>
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
