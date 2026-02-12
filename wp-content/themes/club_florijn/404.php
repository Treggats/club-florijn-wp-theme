<?php
/**
 * The template for displaying 404 pages (not found)
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5, viewport-fit=cover">
    <title><?php esc_html_e('Page Not Found', 'club_florijn'); ?> - <?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body class="bg-gray-50 text-gray-900 antialiased">
    <div id="main-container" class="flex flex-col min-h-screen">
        <?php get_template_part('parts/header'); ?>

        <!-- Main Content -->
        <main id="main" class="site-main flex-grow flex items-center justify-center">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
                <!-- 404 Error -->
                <div class="mb-8">
                    <h1 class="text-9xl md:text-12xl font-bold text-gray-200 mb-4">404</h1>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mb-4">
                        <?php esc_html_e('Page Not Found', 'club_florijn'); ?>
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        <?php esc_html_e('Sorry, the page you are looking for does not exist.', 'club_florijn'); ?>
                    </p>
                </div>

                <!-- Navigation -->
                <div class="flex flex-col sm:flex-row justify-center gap-4 mb-12">
                    <a href="<?php echo esc_url(home_url('/')); ?>" class="inline-block px-6 py-3 bg-blue-900 text-white rounded-lg hover:bg-blue-800 transition-colors font-semibold">
                        <?php esc_html_e('Go Home', 'club_florijn'); ?>
                    </a>
                </div>

                <!-- Search -->
                <section class="max-w-md mx-auto">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        <?php esc_html_e('Try searching:', 'club_florijn'); ?>
                    </h3>
                    <form role="search" method="get" class="relative" action="<?php echo esc_url(home_url('/')); ?>">
                        <input
                            type="search"
                            placeholder="Zoeken"
                            name="s"
                            class="w-full px-6 py-4 border-2 border-yellow-500 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-transparent"
                            aria-label="<?php esc_attr_e('Search Posts', 'club_florijn'); ?>"
                        >
                        <button type="submit" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-yellow-500 hover:text-yellow-600 transition-colors">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </form>
                </section>
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
