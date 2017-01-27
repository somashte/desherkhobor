<?php
/**
 * desher-khobor Theme Customizer.
 *
 * @package desher-khobor
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function desher_khobor_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'desher_khobor_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function desher_khobor_customize_preview_js() {
	wp_enqueue_script( 'desher_khobor_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20151215', true );
}
add_action( 'customize_preview_init', 'desher_khobor_customize_preview_js' );

// Adding the configuration
Kirki::add_config( 'dk', array(
    'capability'    => 'edit_theme_options',
    'option_type'   => 'option',
    'option_name'   => 'dk',
) );

// Adding the Product Slider panel
Kirki::add_panel( 'home_page', array(
    'priority'    => 160,
    'title'       => __( 'Homepage Settings', 'desherkhobor' ),
    'description' => __( 'This panel will provide all the options of the home page.', 'desherkhobor' ),
) );

// Adding the Product Slider for Homepage section
Kirki::add_section( 'category_selection_for_homepage', array(
    'title'          => __( 'Choose News Categories', 'desherkhobor' ),
    'description'    => __( 'Select three seperate category and selected news will be shown on the front page of your website', 'desherkhobor' ),
    'panel'          => 'home_page', // Not typically needed.
    'priority'       => 160,
    'capability'     => 'edit_theme_options',
    'theme_supports' => '', // Rarely needed.
) );

function customizer_fields() {
    // Adding the category field
    Kirki::add_field( 'dk', array(
        'type'        => 'text',
        'settings'     => 'category_for_section_1',
        'label'       => __( 'Category for Section 1', 'desherkhobor' ),
        'section'     => 'category_selection_for_homepage',
        'default'     => '',
        'priority'    => 10,
        ) );
    // Adding the category field
    Kirki::add_field( 'dk', array(
        'type'        => 'text',
        'settings'     => 'category_for_section_2',
        'label'       => __( 'Category for Section 2', 'desherkhobor' ),
        'section'     => 'category_selection_for_homepage',
        'default'     => '',
        'priority'    => 20,
        ) );
    // Adding the category field
    Kirki::add_field( 'dk', array(
        'type'        => 'text',
        'settings'     => 'category_for_section_3',
        'label'       => __( 'Category for Section 3', 'desherkhobor' ),
        'section'     => 'category_selection_for_homepage',
        'default'     => '',
        'priority'    => 30,
        ) );
}
add_action( 'init', 'customizer_fields', 500 );
