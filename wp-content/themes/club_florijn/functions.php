<?php
/**
 * Simple Posts Theme Functions
 */

// Enqueue TailwindCSS from CDN
function simple_posts_enqueue_scripts() {
    // Add TailwindCSS from CDN with optimizations
    wp_enqueue_script('tailwindcss', 'https://cdn.tailwindcss.com', array(), null, false);

    // Add Tailwind line clamp plugin for excerpt truncation
    wp_add_inline_script('tailwindcss', '
        tailwind.config = {
            theme: {
                extend: {
                    lineClamp: {
                        3: "3",
                    }
                }
            }
        }
    ');
}
add_action('wp_enqueue_scripts', 'simple_posts_enqueue_scripts');

// Theme setup
function simple_posts_setup() {
    // Add support for title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Set featured image sizes
    set_post_thumbnail_size(400, 300, true);
    add_image_size('simple-posts-medium', 600, 400, true);
    add_image_size('simple-posts-large', 1200, 700, true);

    // Register navigation menus
    register_nav_menus(array(
        'primary' => esc_html__('Primary Menu', 'simple-posts'),
        'footer' => esc_html__('Footer Menu', 'simple-posts'),
    ));

    // Add theme support for custom logo
    add_theme_support('custom-logo', array(
        'height' => 100,
        'width' => 300,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Add HTML5 support for forms and search
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
}
add_action('after_setup_theme', 'simple_posts_setup');

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

// Add custom menu walker for better styling
class Simple_Posts_Menu_Walker extends Walker_Nav_Menu {
    function start_lvl(&$output, $depth = 0, $args = null) {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"submenu bg-white border border-gray-200 rounded-lg shadow-lg\">\n";
    }

    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'text-blue-600 font-semibold';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $item->ID, $item, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = ! empty($item->target) ? $item->target : '';
        $atts['rel']    = ! empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = ! empty($item->url) ? $item->url : '';
        $atts['class']  = 'hover:text-blue-600 transition-colors';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('nav_menu_item_title', $item->title, $item, $args, $depth);
        $title = apply_filters('nav_menu_item_text', $title, $item, $args, $depth);

        $output .= '<a'. $attributes .'>';
        $output .= $title;
        $output .= '</a>';

        if (isset($args->walker)) {
            $output .= "\n";
        }
    }
}

// Add support for gutenberg blocks
add_theme_support('wp-block-styles');
add_theme_support('responsive-embeds');
