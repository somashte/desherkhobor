<?php
/**
 * Sample implementation of the Custom Header feature.
 *
 * You can add an optional custom header image to header.php like so ...
 *
 *  <?php if ( get_header_image() ) : ?>
 *  <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home">
 *      <img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
 *  </a>
 *  <?php endif; // End header image check. ?>
 *
 * @link https://developer.wordpress.org/themes/functionality/custom-headers/
 * @link https://codex.wordpress.org/Custom_Headers
 *
 * @package desher-khobor
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses desher_khobor_header_style()
 */
function desher_khobor_custom_header_setup() {
    add_theme_support( 'custom-header', apply_filters( 'desher_khobor_custom_header_args', array(
        'default-image'          => get_parent_theme_file_uri( '/assets/images/header.png' ),
        'width'                  => 600,
        'height'                 => 160,
        'flex-height'            => true,
        'wp-head-callback'       => 'desher_khobor_header_style',
    ) ) );

    register_default_headers( array(
        'default-image' => array(
            'url'           => '%s/assets/images/header.png',
            'thumbnail_url' => '%s/assets/images/header.png',
            'description'   => __( 'Default Header Image', 'desherkhobor' ),
        ),
    ) );
}
add_action( 'after_setup_theme', 'desher_khobor_custom_header_setup' );

if ( ! function_exists( 'desher_khobor_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog.
 *
 * @see desher_khobor_custom_header_setup().
 */
function desher_khobor_header_style() {
    $header_text_color = get_header_textcolor();

    /*
     * If no custom options for text are set, let's bail.
     * get_header_textcolor() options: add_theme_support( 'custom-header' ) is default, hide text (returns 'blank') or any hex value.
     */
    if ( get_theme_support( 'custom-header', 'default-text-color' ) == $header_text_color ) {
        return;
    }

    // If we get this far, we have custom styles. Let's do this.
    ?>
    <style id="desherkhobor-custom-header-styles" type="text/css">
    <?php
        // Has the text been hidden?
        if ( 'blank' == $header_text_color ) :
    ?>
        .site-title,
        .site-description {
            position: absolute;
            clip: rect(1px, 1px, 1px, 1px);
        }
    <?php
        // If the user has set a custom color for the text use that.
        else :
    ?>
        .site-title a,
        .site-description {
            color: #<?php echo esc_attr( $header_text_color ); ?>;
        }
    <?php endif; ?>
    </style>
    <?php
}
endif;
