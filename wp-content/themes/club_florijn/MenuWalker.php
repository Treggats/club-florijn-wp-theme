<?php

declare(strict_types=1);

final class MenuWalker extends Walker_Nav_Menu
{
    public function start_el(&$output, $data_object, $depth = 0, $args = null, $id = 0): void
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($data_object->classes) ? array() : (array) $data_object->classes;
        $classes[] = 'menu-item-' . $data_object->ID;

        if (in_array('current-menu-item', $classes)) {
            $classes[] = 'text-blue-600 font-semibold';
        }

        $class_names = implode(' ', apply_filters('nav_menu_css_class', array_filter($classes), $data_object, $args, $depth));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-'. $data_object->ID, $data_object, $args, $depth);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names .'>';

        $atts = array();
        $atts['title']  = ! empty($data_object->attr_title) ? $data_object->attr_title : '';
        $atts['target'] = ! empty($data_object->target) ? $data_object->target : '';
        $atts['rel']    = ! empty($data_object->xfn) ? $data_object->xfn : '';
        $atts['href']   = ! empty($data_object->url) ? $data_object->url : '';
        $atts['class']  = 'text-white hover:text-blue-600 transition-colors';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $data_object, $args, $depth);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('nav_menu_item_title', $data_object->title, $data_object, $args, $depth);
        $title = apply_filters('nav_menu_item_text', $title, $data_object, $args, $depth);

        $output .= '<a'. $attributes .'>';
        $output .= $title;
        $output .= '</a>';

        if (isset($args->walker)) {
            $output .= "\n";
        }
    }
}
