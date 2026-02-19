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
                        <div class="lg:col-span-4">
                            <?php
                            $args = [
                                    'posts_per_page' => 4,
                                    'post_type' => 'bijeenkomst',
                                    'paged' => get_query_var( 'paged' ) ?: 1
                            ];
                            $posts = new WP_Query( $args ); ?>
                                <div class="space-y-6">
                                    <aside class="bg-white rounded-lg p-8 shadow-sm mb-4">
                                        <h3 class="text-xl font-bold text-gray-900 mb-6">Programma</h3>
                                        <?php
                                        $bijeenkomsten = get_posts([
                                                'post_type' => 'bijeenkomst',
                                                'numberposts' => 4,
                                                'orderby' => 'date',
                                                'order' => 'DESC',
                                        ]);
//                                        print_r($bijeenkomsten);

                                        if ($bijeenkomsten) : ?>
                                            <ul>
                                                <?php foreach ($bijeenkomsten as $bijeenkomst) :
                                                    $ambassadors = get_post_meta($bijeenkomst->ID, '_bijeenkomst_ambassadors', true);
                                                    $date = date_create_from_format('Y-m-d', get_post_meta($bijeenkomst->ID, '_bijeenkomst_date', true));
                                                    ?>
                                                    <li>
                                                        <a href="<?php echo esc_url(get_permalink($bijeenkomst->ID)); ?>" class="block text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                                                            <strong><?php echo esc_html($bijeenkomst->post_title); ?></strong>
                                                            <?php if ($ambassadors) : ?>
                                                                <div class="text-xs text-gray-600 mt-1">
                                                                    <p>
                                                                        Op <?php echo esc_html($date->format('l d F Y')); ?>
                                                                    </p>
                                                                    Ambassadeurs: <?php echo esc_html($ambassadors); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </a>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else : ?>
                                            <p class="text-gray-600 text-sm"><?php esc_html_e('No bijeenkomsten available', 'club_florijn'); ?></p>
                                        <?php endif; ?>
                                    </aside>
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
                                                }
                                                ?>
                                            </div>

                                            <!-- Read More Link -->
                                            <a href="<?php the_permalink(); ?>" class="inline-block text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                                                <?php esc_html_e('Lees meer', 'club_florijn'); ?> &rarr;
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
