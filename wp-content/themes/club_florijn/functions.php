<?php
/**
 * Simple Posts Theme Functions
 */
 require_once get_template_directory() . '/MenuWalker.php';

 // Enqueue TailwindCSS from CDN
add_action('wp_enqueue_scripts', function() {
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
});

// Theme setup
add_action('after_setup_theme', function() {
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
});

// Remove comment support
add_action('init', function() {
    remove_post_type_support('post', 'comments');
    remove_post_type_support('page', 'comments');
});

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

// Register widget areas
add_action('widgets_init', function() {
    register_sidebar([
        'name' => esc_html__('Ambassadeurs', 'club_florijn'),
        'id' => 'ambassadeurs-sidebar',
        'description' => esc_html__('Sidebar for displaying information about ambassadors.', 'club_florijn'),
        'before_widget' => '<aside class="bg-white rounded-lg p-8 shadow-sm sticky top-24 mb-4">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="text-xl font-bold text-gray-900 mb-6">',
        'after_title' => '</h3>',
    ]);
});

add_action('widgets_init', function() {
    register_sidebar([
        'name' => esc_html__('Title block', 'club_florijn'),
        'id' => 'titel-top-sidebar',
        'description' => esc_html__('Sidebar for displaying a title block.', 'club_florijn'),
        'before_widget' => '<aside class="bg-white rounded-lg p-8 shadow-sm mb-4">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="text-xl font-bold text-gray-900 mb-6">',
        'after_title' => '</h3>',
    ]);
});

// Load and register custom widgets
require_once get_template_directory() . '/widgets/ShortTextWidget.php';

add_action('widgets_init', function() {
    register_widget('ShortTextWidget');
});

// Register custom post type: Bijeenkomst
add_action('init', function() {
    $args = [
        'label' => esc_html__('Bijeenkomsten', 'club_florijn'),
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'query_var' => true,
        'rewrite' => ['slug' => 'bijeenkomsten'],
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'supports' => ['title', 'editor', 'thumbnail', 'excerpt'],
        'taxonomies' => ['category'],
        'menu_icon' => 'dashicons-calendar-alt',
    ];
    register_post_type('bijeenkomst', $args);
});

// Flush rewrite rules when theme is activated
add_action('after_setup_theme', function() {
    flush_rewrite_rules();
});

// Register custom meta fields for Bijeenkomst post type
add_action('init', function() {
    // Ambassadors meta field (comma-separated or multiple entries)
    register_meta('post', '_bijeenkomst_ambassadors', array(
        'object_subtype' => 'bijeenkomst',
        'type' => 'string',
        'description' => esc_html__('Names of ambassadors organizing this bijeenkomst', 'club_florijn'),
        'show_in_rest' => true,
        'single' => true,
    ));
});

// Add custom meta box for ambassadors in the post editor
add_action('add_meta_boxes', function() {
    add_meta_box(
        'bijeenkomst_ambassadors',
        esc_html__('Ambassadors', 'club_florijn'),
        function($post) {
            $ambassadors = get_post_meta($post->ID, '_bijeenkomst_ambassadors', true);
            wp_nonce_field('bijeenkomst_ambassadors_nonce', 'bijeenkomst_ambassadors_nonce');
            ?>
            <div style="margin: 10px 0;">
                <label for="bijeenkomst_ambassadors" style="display: block; margin-bottom: 5px; font-weight: bold;">
                    <?php esc_html_e('Ambassador Names (comma-separated)', 'club_florijn'); ?>
                </label>
                <textarea
                    id="bijeenkomst_ambassadors"
                    name="bijeenkomst_ambassadors"
                    rows="4"
                    style="width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; font-family: monospace;"
                    placeholder="<?php esc_attr_e('Enter ambassador names separated by commas', 'club_florijn'); ?>"
                ><?php echo esc_textarea($ambassadors); ?></textarea>
                <p style="margin-top: 5px; color: #666; font-size: 12px;">
                    <?php esc_html_e('Example: John Doe, Jane Smith, Bob Johnson', 'club_florijn'); ?>
                </p>
            </div>
            <?php
        },
        'bijeenkomst',
        'normal',
        'high'
    );
});

// Save ambassadors meta data
add_action('save_post_bijeenkomst', function($post_id) {
    // Verify nonce
    if (!isset($_POST['bijeenkomst_ambassadors_nonce']) ||
        !wp_verify_nonce($_POST['bijeenkomst_ambassadors_nonce'], 'bijeenkomst_ambassadors_nonce')) {
        return;
    }

    // Check user capability
    if (!current_user_can('edit_post', $post_id)) {
        return;
    }

    // Sanitize and save the ambassadors field
    if (isset($_POST['bijeenkomst_ambassadors'])) {
        $ambassadors = sanitize_textarea_field($_POST['bijeenkomst_ambassadors']);
        update_post_meta($post_id, '_bijeenkomst_ambassadors', $ambassadors);
    } else {
        delete_post_meta($post_id, '_bijeenkomst_ambassadors');
    }
});
