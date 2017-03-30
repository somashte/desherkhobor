<?php
/**
 * desher-khobor functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package desher-khobor
 */

if ( ! function_exists( 'desher_khobor_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function desher_khobor_setup() {
    /*
     * Make theme available for translation.
     * Translations can be filed in the /languages/ directory.
     */
    load_theme_textdomain( 'desherkhobor', get_template_directory() . '/languages' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    /*
     * Let WordPress manage the document title.
     * By adding theme support, we declare that this theme does not use a
     * hard-coded <title> tag in the document head, and expect WordPress to
     * provide it for us.
     */
    add_theme_support( 'title-tag' );

    /*
     * Enable support for Post Thumbnails on posts and pages.
     *
     * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
     */
    add_theme_support( 'post-thumbnails' );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'desherkhobor' ),
        'top'     => __( 'Top Single Nav', 'desherkhobor' ),
        'footer'  => __( 'Footer Menu', 'desherkhobor' ),
    ) );

    /*
     * Switch default core markup for search form, comment form, and comments
     * to output valid HTML5.
     */
    add_theme_support( 'html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ) );
}
endif;
add_action( 'after_setup_theme', 'desher_khobor_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function desher_khobor_content_width() {
    $GLOBALS['content_width'] = apply_filters( 'desher_khobor_content_width', 1170 );
}
add_action( 'after_setup_theme', 'desher_khobor_content_width', 0 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function desher_khobor_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Front Page', 'desherkhobor' ),
        'id'            => 'sidebar-front',
        'description'   => __( 'Add widgets here.', 'desherkhobor' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Sidebar', 'desherkhobor' ),
        'id'            => 'sidebar-1',
        'description'   => __( 'Add widgets here.', 'desherkhobor' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h5 class="widget-title">',
        'after_title'   => '</h5>',
    ) );
}
add_action( 'widgets_init', 'desher_khobor_widgets_init' );

/**
 * Filter the except length to 20 words.
 *
 * @param int $length Excerpt length.
 * @return int (Maybe) modified excerpt length.
 */
function desher_khobor_custom_excerpt_length( $length ) {
    return 30;
}
add_filter( 'excerpt_length', 'desher_khobor_custom_excerpt_length', 999 );

/**
 * Replaces "[...]" (appended to automatically generated excerpts) with ... and
 * a 'Continue reading' link.
 *
 * @since Twenty Seventeen 1.0
 *
 * @return string 'Continue reading' link prepended with an ellipsis.
 */
function desherkhobor_excerpt_more( $link ) {
    if ( is_admin() ) {
        return $link;
    }

    $link = sprintf( '<a href="%1$s" class="more-link">%2$s</a>',
        esc_url( get_permalink( get_the_ID() ) ),
        /* translators: %s: Name of current post */
        sprintf( __( 'বিস্তারিত', 'desherkhobor' ), get_the_title( get_the_ID() ) )
    );
    return '.....' . $link;
}
add_filter( 'excerpt_more', 'desherkhobor_excerpt_more' );

function desherkhobor_archive_title( $title ) {
    if ( is_category() ) {
        $title = single_cat_title( '', true );
    } elseif ( is_tag() ) {
        $title = single_tag_title( '', true );
    } elseif ( is_author() ) {
        $title = '<span class="author-vcard"' . get_the_author() . '</span>';
    }
    return $title;
}
add_filter( 'get_the_archive_title', 'desherkhobor_archive_title' );

function desherkhobor_image_class( $classes ) {
    return $classes . ' img-responsive';
}

// responsive images auto class
function add_image_responsive_class( $content ) {
   global $post;
   $pattern ="/<img(.*?)class=\"(.*?)\"(.*?)>/i";
   $replacement = '<img$1class="$2 img-responsive center-block"$3>';
   $content = preg_replace($pattern, $replacement, $content);
   return $content;
}
add_filter('the_content', 'add_image_responsive_class');

function add_image_class( $class ){
    $class .= ' img-responsive center-block';
    return $class;
}
add_filter( 'get_image_tag_class', 'add_image_class' );

function desherkhobor_frontpage_news_section() {
    $counter = 0;
    while ( have_posts() ) : the_post(); ?>
        <?php if ($counter < 2) : ?>
            <article class="col-md-6" id="post-<?php the_ID(); ?>" role="article">
                <div class="post-thumbnail-lg"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' )); ?></div>
                <h6><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?> <br> <small><?php echo convert_bengali( get_the_date() ); ?></small></a></h6>
                <p><?php the_excerpt(); ?></p>
            </article>
        <?php else : ?>
            <?php echo '</div><br><div class="row">'; ?>
            <article class="col-md-12" id="post-<?php the_ID(); ?>" role="article">
                <div class="row">
                    <div class="col-md-3">
                        <div class="post-thumbnail-sm"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' )); ?></div>
                    </div> <!-- /post-thumbnail -->
                    <div class="col-md-9">
                        <h6><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?> <br> <small><?php echo convert_bengali( get_the_date() ); ?></small></a></h6>
                        <p><?php the_excerpt(); ?></p>
                    </div> <!-- /post title and excerpt -->
                </div>
            </article>
        <?php endif; $counter++;
    endwhile; // End the loop
}
