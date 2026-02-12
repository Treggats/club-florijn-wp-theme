<?php
/**
 * Simple Short Text Widget
 *
 * Displays a simple short text with optional title
 */

class ShortTextWidget extends WP_Widget {

    public function __construct() {
        parent::__construct(
            'short_text_widget',
            esc_html__('Short Text', 'club_florijn'),
            array('description' => esc_html__('Display a short text or custom content', 'club_florijn'))
        );
    }

    /**
     * Front-end display of widget.
     */
    public function widget($args, $instance) {
        echo wp_kses_post($args['before_widget']);

        if (!empty($instance['title'])) {
            echo wp_kses_post($args['before_title']);
            echo esc_html($instance['title']);
            echo wp_kses_post($args['after_title']);
        }

        if (!empty($instance['text'])) {
            ?>
            <div class="short-text-widget-content">
                <?php echo wp_kses_post(wpautop($instance['text'])); ?>
            </div>
            <?php
        }

        echo wp_kses_post($args['after_widget']);
    }

    /**
     * Back-end widget form.
     */
    public function form($instance) {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $text = !empty($instance['text']) ? $instance['text'] : '';
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')); ?>">
                <?php esc_html_e('Title:', 'club_florijn'); ?>
            </label>
            <input
                class="widefat"
                id="<?php echo esc_attr($this->get_field_id('title')); ?>"
                name="<?php echo esc_attr($this->get_field_name('title')); ?>"
                type="text"
                value="<?php echo esc_attr($title); ?>"
            />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('text')); ?>">
                <?php esc_html_e('Text:', 'club_florijn'); ?>
            </label>
            <textarea
                class="widefat"
                rows="6"
                id="<?php echo esc_attr($this->get_field_id('text')); ?>"
                name="<?php echo esc_attr($this->get_field_name('text')); ?>"
            ><?php echo esc_textarea($text); ?></textarea>
        </p>
        <?php
    }

    /**
     * Sanitize widget form values as they are saved.
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = !empty($new_instance['title']) ? sanitize_text_field($new_instance['title']) : '';
        $instance['text'] = !empty($new_instance['text']) ? wp_kses_post($new_instance['text']) : '';
        return $instance;
    }
}
