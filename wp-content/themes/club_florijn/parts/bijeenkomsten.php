<?php
// parts/bijeenkomsten.php

require_once __DIR__ . '/../vendor/autoload.php';

use App\BijeenkomstenData;

$bijeenkomsten = BijeenkomstenData::list();
?>

<div class="lg:col-span-4">

    <div class="space-y-6">

        <article class="bg-white rounded-lg p-8 shadow-sm mb-4">
            <h3 class="text-xl font-bold text-gray-900 mb-6"><?php esc_html_e( get_theme_mod( 'club_florijn_programma_title', 'Programma' ) ); ?></h3>

            <ul>
                <?php foreach ($bijeenkomsten as $bijeenkomst) : ?>
                    <li>
                        <a href="<?php echo esc_url($bijeenkomst->permalink); ?>" class="block text-blue-600 hover:text-blue-700 transition-colors text-sm font-medium">
                            <strong><?php echo esc_html($bijeenkomst->post->post_title); ?></strong>

                            <div class="text-xs text-gray-600 mt-1">
                                <?php if (!empty($bijeenkomst->date->format('l d F Y'))) : ?>
                                    <p><?php echo esc_html($bijeenkomst->date->format('l d F Y')); ?></p>
                                <?php endif; ?>

                                <?php if (!empty($bijeenkomst->ambassadors)) : ?>
                                    <p><?php esc_html_e('Ambassadeurs:', 'club_florijn'); ?> <?php echo esc_html($bijeenkomst->ambassadors); ?></p>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>

                <?php endforeach; ?>
            </ul>
        </article>

        <?php foreach ($bijeenkomsten as $bijeenkomst) : ?>
            <article id="post-<?php echo $bijeenkomst->post->ID; ?>" class="bg-white rounded-lg p-8 shadow-sm hover:shadow-md transition-shadow duration-300 border-l-4 border-blue-900">

                <!-- Title -->
                <h2 class="text-2xl font-bold text-gray-900 mb-2">
                    <a href="<?php echo esc_url($bijeenkomst->permalink); ?>" class="hover:text-blue-600 transition-colors">
                        <?php echo esc_html($bijeenkomst->post->post_title); ?>
                    </a>
                </h2>

                <!-- Metadata -->
                <div class="flex items-center gap-4 mb-4 text-sm text-gray-500">
                    <?php if ($bijeenkomst->date) : ?>
                        <time datetime="<?php echo $bijeenkomst->date->format('c'); ?>">
                            <?php echo $bijeenkomst->date->format('F j, Y'); ?>
                        </time>
                    <?php endif; ?>

                    <?php if (get_the_author_meta('display_name', $bijeenkomst->post->post_author)) : ?>
                        <span>|</span>
                        <span><?php esc_html_e('Door', 'club_florijn'); ?> <strong><?php echo esc_html(get_the_author_meta('display_name', $bijeenkomst->post->post_author)); ?></strong></span>
                    <?php endif; ?>
                </div>

                <!-- Excerpt -->
                <?php if (has_excerpt($bijeenkomst->post->ID)) : ?>
                    <div class="text-gray-700 mb-4">
                        <?php echo wp_kses_post($bijeenkomst->post->post_excerpt ?: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.'); ?>
                    </div>
                <?php endif; ?>

                <!-- Read More Link -->
                <a href="<?php echo esc_url($bijeenkomst->permalink); ?>" class="inline-block text-blue-600 hover:text-blue-700 font-semibold transition-colors">
                    <?php esc_html_e('Lees meer', 'club_florijn'); ?> &rarr;
                </a>

            </article>
        <?php endforeach; ?>

    </div>

</div> <!-- .lg:col-span-4 -->
