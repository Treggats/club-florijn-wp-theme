<?php

declare(strict_types=1);

namespace App;
use WP_Post;
use WP_Query;

final class BijeenkomstenData
{
    /**
     * Get all bijeenkomsten as an array of Bijeenkomst objects.
     *
     * @param int $limit Maximum number of items to return
     * @param array $args Additional WP_Query arguments to merge with defaults
     * @return Bijeenkomst[]
     */
    public static function list(int $limit = 4, array $args = []): array
    {
        $current_year = date('Y');
        $default_args = [
            'post_type' => 'bijeenkomst',
            'posts_per_page' => $limit,
            'meta_key' => '_bijeenkomst_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => [
                [
                    'key' => '_bijeenkomst_date',
                    'value' => [
                        $current_year . '-01-01',
                        $current_year . '-12-31',
                    ],
                    'compare' => 'BETWEEN',
                    'type' => 'DATE',
                ],
            ],
        ];

        $query_args = array_merge($default_args, $args);
        $query = new WP_Query($query_args);

        return array_map(fn (WP_Post $post) => new Bijeenkomst(
            $post,
            get_permalink($post->ID),
            get_post_meta($post->ID, '_bijeenkomst_ambassadors', true) ?: null,
            get_post_meta($post->ID, '_bijeenkomst_date', true) ?: null,
        ), $query->posts);
    }
}
