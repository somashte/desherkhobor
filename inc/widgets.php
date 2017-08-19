<?php
/**
 * Desher Khobor Custom Widgets
 *
 * @package desher-khobor-unv
 */

class DK_Category_Widget extends WP_Widget {

    /**
     * Sets up the widgets name etc
     */
    public function __construct() {
        $widget_ops = array(
            'classname' => 'dk_category_news_widget',
            'description' => __('Desher Khobor Category News Sidebar Wideget', 'desher-khobor-unv')
        );
        parent::__construct( 'dk_category_news_widget', 'DK Category News Widgets', $widget_ops );
    }

    /**
     * Outputs the options form on admin
     *
     * @param array $instance The widget options
     */
    public function form( $instance ) {
        $title    = ! empty( $instance['title'] ) ? $instance['title'] : esc_html__( 'Widget Name', 'desher-khobor-unv' );
        $category = ! empty( $instance['category'] ) ? $instance['category'] : __( 'Select a category', 'desher-khobor-unv' );
        $number   = ! empty( $instance['number'] ) ? absint( $instance['number'] ) : absint( '5' );
        ?>

        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?></label>
            <input type=”text” value="<?php echo $title; ?>" name="<?php echo $this->get_field_name('title'); ?>" id="<?php echo $this->get_field_id('title'); ?>" />
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('category'); ?>"><?php _e('News Category:', 'desher-khobor-unv'); ?></label>
            <?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
        </p>

        <p>
            <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e('Number of Posts:', 'desher-khobor-unv'); ?></label>
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
        $instance = $old_instance;

        $instance['title']    = $new_instance['title'];
        $instance['category'] = $new_instance['category'];
        $instance['number']   = $new_instance['number'];

        return $instance;
    }

    /**
     * Outputs the content of the widget
     *
     * @param array $args
     * @param array $instance
     */
    public function widget( $args, $instance ) {
        extract( $args );

        $cat_id = $instance['category'];

        $title = apply_filters('widget_title', empty($instance['title']) ? __('Recent Posts') : get_cat_name( $cat_id ), $instance, $this->id_base);


        if( empty( $instance['number'] ) || ! $number = absint( $instance['number'] ) )
            $number = 5;

        $widget_post = new WP_Query( apply_filters( 'widget_posts_args', array( 'posts_per_page' => $number, 'cat' => $cat_id, 'no_found_rows' => true, 'post_status' => 'publish', 'ignore_sticky_posts' => true ) ) );

        echo $before_widget;

        echo $before_title . $title . $after_title;

        if ($widget_post->have_posts() ) :
            ?>
            <ul>
                <?php while( $widget_post->have_posts() ) : $widget_post->the_post(); ?>
                <li><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_title(); ?></a></li>
                <?php endwhile; ?>
            </ul>

            <?php

        wp_reset_postdata();
        endif;

        echo $after_widget;
    }
}

add_action( 'widgets_init', function(){
    register_widget( 'DK_Category_Widget' );
});

?>
