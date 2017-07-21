<?php
/**
 * Desher Khobor Custom Widgets
 *
 * @package desherkhobor
 * @version 2.4.2
 */

class DK_Category_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'dk_category_news_widget',
            'description' => __('Desher Khobor Category News Wideget', 'desherkhobor')
        );
        parent::__construct( 'dk_category_news_widget', 'DK Category News List Widgets', $widget_ops );
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {

    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Name', 'desherkhobor' );
        $number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : absint( '5' );
        $category = ! empty( $instance['category'] ) ? $instance['category'] : __( 'Select a category', 'desherkhobor' );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input type=”text” value="<?php echo $title; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('News Category:', 'desherkhobor'); ?></label>
            <select id="<?php echo $this->get_field_id('category'); ?>"  name="<?php echo $this->get_field_name('category'); ?>">
                <?php for($x=1;$x<=10;$x++): ?>
                <option <?php echo $x == $category ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
                <?php endfor;?>
            </select>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts:', 'desherkhobor'); ?></label>
            <select id="<?php echo $this->get_field_id('number'); ?>"  name="<?php echo $this->get_field_name('number'); ?>">
                <?php for($x=1;$x<=10;$x++): ?>
                <option <?php echo $x == $number ? 'selected="selected"' : '';?> value="<?php echo $x;?>"><?php echo $x; ?></option>
                <?php endfor;?>
            </select>
        </p>
        <?php
    }

    /**
     * Processing widget options on save
     *
     * @param array $new_instance The new options
     * @param array $old_instance The previous options
     */
    public function update( $new_instance, $old_instance ) {
        // processes widget options to be saved
    }
}

add_action( 'widgets_init', function(){
    register_widget( 'DK_Category_Widget' );
});

?>
