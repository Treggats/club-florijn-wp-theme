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
                <div class="max-w-4xl mx-auto">
                    <?php
                    if (have_posts()) :
                        while (have_posts()) : the_post();
                            ?>
                            <article id="post-<?php the_ID(); ?>" class="bg-white rounded-lg p-8 shadow-sm border-l-4 border-blue-900">
                                <!-- Title -->
                                <h1 class="text-4xl font-bold text-gray-900 mb-4">
                                    <?php the_title(); ?>
                                </h1>

                                <!-- Featured Image -->
                                <?php if (has_post_thumbnail()) : ?>
                                    <div class="mb-8">
                                        <?php
                                        the_post_thumbnail('club_florijn-large', array(
                                            'class' => 'w-full rounded-lg shadow-md',
                                            'alt' => get_the_title()
                                        ));
                                        ?>
                                    </div>
                                <?php endif; ?>

                                <!-- Metadata -->
                                <div class="flex items-center gap-4 mb-6 text-sm text-gray-500 pb-6 border-b border-gray-200">
                                    <time datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('F j, Y'); ?>
                                    </time>
                                    <?php if (get_the_author()) : ?>
                                        <span>|</span>
                                        <span><?php esc_html_e('By', 'club_florijn'); ?> <strong><?php the_author(); ?></strong></span>
                                    <?php endif; ?>
                                </div>

                                <!-- Ambassadors Section -->
                                <?php
                                $ambassadors = get_post_meta(get_the_ID(), '_bijeenkomst_ambassadors', true);
                                if ($ambassadors) :
                                    $ambassador_list = array_map('trim', explode(',', $ambassadors));
                                    ?>
                                    <div class="mb-8 p-6 bg-blue-50 rounded-lg border-l-4 border-blue-900">
                                        <h3 class="text-lg font-bold text-gray-900 mb-3">
                                            <?php esc_html_e('Ambassadors', 'club_florijn'); ?>
                                        </h3>
                                        <ul class="space-y-2">
                                            <?php foreach ($ambassador_list as $ambassador) : ?>
                                                <li class="text-gray-700">
                                                    <span class="inline-block w-2 h-2 bg-blue-900 rounded-full mr-2"></span>
                                                    <?php echo esc_html($ambassador); ?>
                                                </li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                <?php endif; ?>

                                <!-- Content -->
                                <div class="prose prose-lg max-w-none mb-8">
                                    <?php the_content(); ?>
                                </div>
                            </article>
                            <?php
                        endwhile;
                    endif;
                    ?>
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
