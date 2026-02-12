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
        <?php get_template_part('parts/header'); ?>

        <!-- Main Content -->
        <main id="main" class="site-main flex-grow">
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <article id="post-<?php the_ID(); ?>" class="bg-white">
                        <!-- Featured Image -->
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="w-full h-96 overflow-hidden bg-gray-100">
                                <?php the_post_thumbnail('full', array('class' => 'w-full h-full object-cover')); ?>
                            </div>
                        <?php endif; ?>

                        <!-- Content Wrapper -->
                        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                            <!-- Breadcrumb -->
                            <nav class="mb-6 text-sm">
                                <a href="<?php echo esc_url(home_url('/')); ?>" class="text-blue-600 hover:text-blue-700">
                                    <?php bloginfo('name'); ?>
                                </a>
                                <span class="text-gray-400 mx-2">/</span>
                                <span class="text-gray-600"><?php the_title(); ?></span>
                            </nav>

                            <!-- Title -->
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-900 mb-6">
                                <?php the_title(); ?>
                            </h1>

                            <!-- Page Content -->
                            <div class="prose prose-lg max-w-none text-gray-700">
                                <?php the_content(); ?>
                            </div>
                        </div>
                    </article>
                <?php endwhile; ?>
            <?php endif; ?>
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
