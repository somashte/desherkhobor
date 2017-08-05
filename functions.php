<?php
/**
 * desher-khobor-unv functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package desher-khobor-unv
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
        $config = array(
            'slug' => 'desherkhobor',
            'owner' => 'somashte',
            'api_url' => 'https://api.github.com/repos/somashte/desherkhobor/releases'
        );
        new Theme_Updater( $config );
    }
}
