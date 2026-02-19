<!DOCTYPE html>
<html lang="<?php echo esc_attr( get_bloginfo( 'language' ) ); ?>" <?php echo is_rtl() ? 'dir="rtl"' : 'dir="ltr"'; ?>>
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
                <div class="max-w-7xl mx-auto">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
                        <!-- Content Column (full width here) -->
                        <div class="lg:col-span-4">

                            <?php get_template_part('parts/bijeenkomsten'); ?>

                        </div> <!-- .lg:col-span-4 -->

                    </div> <!-- .grid -->
                </div> <!-- .max-w-7xl -->
            </div> <!-- .w-full -->
        </main>

        <!-- Footer -->
        <footer id="footer" class="bg-blue-900 text-blue-100 mt-auto">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                    <p class="text-sm">&copy; <?php echo date('Y'); ?> - <?php bloginfo('name'); ?></p>

                    <nav class="flex space-x-6">
                        <?php
                        wp_nav_menu([
                            'theme_location'  => 'footer',
                            'fallback_cb'     => false,
                            'container_class' => 'flex space-x-6',
                            'depth'           => 1,
                        ]);
                        ?>
                    </nav>
                </div>
            </div>
        </footer>
    </div> <!-- #main-container -->

    <?php wp_footer(); ?>
</body>
</html>
