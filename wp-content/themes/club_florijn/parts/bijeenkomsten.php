<?php
// parts/bijeenkomsten.php
// Presentation-only template: uses helper functions from `bijeenkomsten-data.php` for data.

require_once __DIR__ . '/bijeenkomsten-data.php';

// Pull data (WP_Query + sidebar array)
$data = club_florijn_get_bijeenkomsten_data(4, 4);
/** @var WP_Query $posts_query */
$posts_query = $data['query'];
$sidebar_items = $data['sidebar'];
?>

<div class="lg:col-span-4">

    <div class="space-y-6">

        <aside class="bg-white rounded-lg p-8 shadow-sm mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-6"><?php esc_html_e( get_theme_mod( 'club_florijn_programma_title', 'Programma' ) ); ?></h3>

            <?php if (!empty($sidebar_items)) : ?>
                <ul>
                    <?php foreach ($sidebar_items as $item) : ?>
                        <li>
                            <a href="<?php echo esc_url($item['permalink']); ?>" class="block text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                                <strong><?php echo esc_html($item['title']); ?></strong>

                                <?php if (!empty($item['ambassadors']) || !empty($item['formatted_date'])) : ?>
                                    <div class="text-xs text-gray-600 mt-1">
                                        <?php if (!empty($item['formatted_date'])) : ?>
                                            <p><?php echo esc_html($item['formatted_date']); ?></p>
                                        <?php endif; ?>

                                        <?php if (!empty($item['ambassadors'])) : ?>
                                            <p><?php esc_html_e('Ambassadeurs:', 'club_florijn'); ?> <?php echo esc_html($item['ambassadors']); ?></p>
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
                            <?php echo date_i18n('F j, Y', strtotime(get_post_meta(get_the_ID(), '_bijeenkomst_date', true))); ?>
                        </time>

                        <?php if (get_the_author()) : ?>
                            <span>|</span>
                            <span><?php esc_html_e('Door', 'club_florijn'); ?> <strong><?php the_author(); ?></strong></span>
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
        <?php else : ?>
            <p class="text-gray-600"><?php esc_html_e('No posts found.', 'club_florijn'); ?></p>
        <?php endif; ?>

    </div>

</div> <!-- .lg:col-span-4 -->
