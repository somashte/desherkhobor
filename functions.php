<?php
/**
 * desher-khobor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package desher-khobor
 */

// Implement the Custom Header feature.
include_once( get_template_directory() . '/inc/custom-header.php' );

// Customizer additions.
include_once( get_template_directory() . '/inc/customizer.php' );

// Enqueue scripts and styles.
include_once( get_template_directory() . '/inc/enqueue.php' );

// Custom functions that act independently of the theme templates.
include_once( get_template_directory() . '/inc/extras.php' );

// Load Jetpack compatibility file.
include_once( get_template_directory() . '/inc/jetpack.php' );

// Register Bootstrap Navigation Walker
include_once( get_template_directory() . '/inc/navwalker.php' );

// Theme functions and definitions.
include_once( get_template_directory() . '/inc/setup.php' );

// Custom template tags for this theme.
include_once( get_template_directory() . '/inc/template-tags.php' );

// Bangla date converter.
include_once( get_template_directory() . '/inc/bangla-date.php' );

// Bootstrap pagination
include_once( get_template_directory() . '/inc/bootstrap-pagination.php' );

// Theme Widgets
include_once( get_template_directory() . '/inc/widgets.php' );

// Theme Updater
if( ! class_exists( 'Theme_Updater' ) ) {
    require_once( get_template_directory() . '/inc/theme-updater.php' );

    if ( is_admin() ) {
        $updater = new Theme_Updater( 'somashte', 'desherkhobor', 'e8da06417ed30f222d7a03e7f61a33c3e5ca9a16' );
    }
}
