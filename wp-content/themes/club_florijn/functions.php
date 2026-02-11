<?php
/**
 * Simple Posts Theme Functions
 */

// Enqueue TailwindCSS from CDN
function simple_posts_enqueue_scripts() {
    // Add TailwindCSS from CDN
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), null, false);
}
add_action('wp_enqueue_scripts', 'simple_posts_enqueue_scripts');

// Remove comment support
function simple_posts_remove_comment_support() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
}
add_action('init', 'simple_posts_remove_comment_support');

// Close comments on the front-end
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Theme setup
function simple_posts_setup() {
    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails (optional, not displayed but good to have)
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'simple_posts_setup');
