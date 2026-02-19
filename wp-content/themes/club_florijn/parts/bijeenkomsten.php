<?php
// parts/bijeenkomsten.php
// Extracted logic: query for 'bijeenkomst' posts, render sidebar list, posts loop and pagination.

?>
<div class="lg:col-span-4">

    <?php
    $args = [
        'posts_per_page' => 4,
        'post_type'      => 'bijeenkomst',
        'paged'          => get_query_var('paged') ?: 1,
        // Order by the event date saved in postmeta
        'meta_key'       => '_bijeenkomst_date',
        'orderby'        => 'meta_value',
        'order'          => 'ASC',
    ];

    $posts_query = new WP_Query($args);
    ?>

    <div class="space-y-6">

        <aside class="bg-white rounded-lg p-8 shadow-sm mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-6"><?php esc_html_e('Programma', 'club_florijn'); ?></h3>

            <?php
            $bijeenkomsten = get_posts([
                'post_type'   => 'bijeenkomst',
                'numberposts' => 4,
                // Order sidebar list by the event date postmeta
                'meta_key'    => '_bijeenkomst_date',
                'orderby'     => 'meta_value',
                'order'       => 'ASC',
            ]);

            if (!empty($bijeenkomsten)) : ?>
                <ul>
                    <?php foreach ($bijeenkomsten as $bijeenkomst) :
                        $ambassadors = get_post_meta($bijeenkomst->ID, '_bijeenkomst_ambassadors', true);
                        $raw_date = get_post_meta($bijeenkomst->ID, '_bijeenkomst_date', true);

                        $date = false;
                        if (!empty($raw_date)) {
                            $date = date_create_from_format('Y-m-d', $raw_date);
                        }
                        ?>

                        <li>
                            <a href="<?php echo esc_url(get_permalink($bijeenkomst->ID)); ?>" class="block text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                                <strong><?php echo esc_html($bijeenkomst->post_title); ?></strong>

                                <?php if (!empty($ambassadors) || $date) : ?>
                                    <div class="text-xs text-gray-600 mt-1">
                                        <?php if ($date) : ?>
                                            <p><?php echo esc_html($date->format('l d F Y')); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($ambassadors)) : ?>
                                            <p><?php esc_html_e('Ambassadeurs:', 'club_florijn'); ?> <?php echo esc_html($ambassadors); ?></p>
                                        <?php endif; ?>
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

        <?php if ($posts_query->have_posts()) : ?>
            <?php while ($posts_query->have_posts()) : $posts_query->the_post(); ?>
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
                    <?php if (has_excerpt()) : ?>
                        <div class="text-gray-700 mb-4">
                            <?php echo wp_kses_post(get_the_excerpt()); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Read More Link -->
                    <a href="<?php the_permalink(); ?>" class="inline-block text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                        <?php esc_html_e('Lees meer', 'club_florijn'); ?> &rarr;
                    </a>

                </article>
            <?php endwhile; ?>
            <?php wp_reset_postdata(); ?>
        <?php else : ?>
            <p class="text-gray-600"><?php esc_html_e('No posts found.', 'club_florijn'); ?></p>
        <?php endif; ?>

    </div>

    <!-- Pagination -->
    <nav class="flex justify-center gap-4 mt-12" aria-label="Posts">
        <?php
        $pagination_args = [
            'prev_text' => '&larr; ' . esc_html__('Newer Posts', 'club_florijn'),
            'next_text' => esc_html__('Older Posts', 'club_florijn') . ' &rarr;',
            'type'      => 'list',
            'total'     => $posts_query->max_num_pages,
        ];

        echo paginate_links(array_merge($pagination_args, [
            'current' => max(1, get_query_var('paged')),
            'format'  => get_pagenum_link() . '%#%',
        ]));
        ?>
    </nav>

</div> <!-- .lg:col-span-4 -->
