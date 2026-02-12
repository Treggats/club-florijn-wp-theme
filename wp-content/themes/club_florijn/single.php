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

                            <!-- Post Meta -->
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8 pb-8 border-b border-gray-200">
                                <div class="flex items-center space-x-4">
                                    <time class="text-gray-600" datetime="<?php echo get_the_date('c'); ?>">
                                        <?php echo get_the_date('F j, Y'); ?>
                                    </time>

                                </div>
                                <div class="mt-4 md:mt-0">
                                    <span class="inline-block px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        <?php the_category(', '); ?>
                                    </span>
                                </div>
                            </div>

                            <!-- Post Content -->
                            <div class="prose prose-lg max-w-none text-gray-700 mb-12">
                                <?php the_content(); ?>
                            </div>

                            <!-- Tags -->
                            <?php if (has_tag()) : ?>
                                <div class="mb-12 pb-12 border-b border-gray-200">
                                    <div class="flex flex-wrap gap-2">
                                        <?php the_tags('<span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">', '</span><span class="inline-block px-3 py-1 bg-gray-100 text-gray-700 rounded-lg text-sm hover:bg-gray-200 transition-colors">', '</span>'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <!-- Post Navigation -->
                            <nav class="flex justify-between items-center mb-12">
                                <div class="w-1/2">
                                    <?php
                                    // Configure which category to filter previous/next posts by
                                    // Change the value in the array below to match your desired category ID
                                    $category_ids = [1];

                                    $prev_post = get_previous_post();
                                    // Filter by category
                                    $prev_post ??= get_previous_post(false, $category_ids);
                                    if ($prev_post) {
                                        echo '<a href="' . get_permalink($prev_post->ID) . '" class="text-blue-600 hover:text-blue-700 transition-colors">';
                                        echo '&larr; ' . esc_html__('Previous Post', 'club_florijn');
                                        echo '</a>';
                                    }
                                    ?>
                                </div>
                                <div class="w-1/2 text-right">
                                    <?php
                                    $next_post = get_next_post(true, $category_ids);
                                    if ($next_post) {
                                        echo '<a href="' . get_permalink($next_post->ID) . '" class="text-blue-600 hover:text-blue-700 transition-colors">';
                                        echo esc_html__('Next Post', 'club_florijn') . ' &rarr;';
                                        echo '</a>';
                                    }
                                    ?>
                                </div>
                            </nav>
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
