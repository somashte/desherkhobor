<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package desher-khobor
 */

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">

    <?php wp_head(); ?>
    </head>

    <body <?php body_class(); ?>>

        <div id="page" class="site">

            <?php get_template_part( 'template-parts/header/header', 'top' ); ?>

            <header id="masthead" class="site-header" role="banner">
                <div class="site-branding">

                    <div class="custom-header-media">
                        <?php the_custom_header_markup(); ?>
                    </div>

                    <?php
                    if ( is_front_page() && is_home() ) : ?>
                        <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
                    <?php else : ?>
                        <h2 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h2>
                    <?php
                    endif;

                    $description = get_bloginfo( 'description', 'display' );
                    if ( $description || is_customize_preview() ) : ?>
                        <h6 class="site-description"><?php echo $description; ?></h6>
                    <?php
                    endif; ?>
                </div><!-- .site-branding -->

                <div class="col-sm-12">
                    <div class="row">
                        <?php get_template_part( 'template-parts/header/header', 'headlines' ); ?>
                    </div>
                </div>

                <?php if ( has_nav_menu( 'primary' ) ) : ?>
                    <?php get_template_part( 'template-parts/navigation/navigation', 'primary' ); ?>
                <?php endif; ?>
            </header> <!-- #masthead -->

            <div id="content" class="site-content">
