<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package desher-khobor
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( 'post-index' ); ?>>
    <header class="entry-header">
        <?php
        if ( is_single() ) :
            the_title( '<h3 class="entry-title single-post">', '</h3>' );
        else :
            the_title( '<h4 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h4>' );
        endif;

        if ( 'post' === get_post_type() ) : ?>
            <div class="entry-meta">
                <?php desher_khobor_posted_on(); ?>
            </div><!-- .entry-meta -->
        <?php
        endif; ?>
    </header><!-- .entry-header -->

    <div class="entry-content row">
            <?php
                if ( is_single() ) : ?>
                    <div class="col-md-12"> <?php
                    the_content( sprintf(
                        /* translators: %s: Name of current post. */
                        wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'desherkhobor' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );
                else : ?>
                    <div class="col-md-3">
                        <div class="post-thumbnail"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive center-block' )); ?></div>
                    </div><!-- .post-thumbnail -->
                    <div class="col-md-9"> <?php
                    the_excerpt( sprintf(
                        /* translators: %s: Name of current post. */
                        wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'desherkhobor' ), array( 'span' => array( 'class' => array() ) ) ),
                        the_title( '<span class="screen-reader-text">"', '"</span>', false )
                    ) );
                endif;
                wp_link_pages( array(
                    'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'desherkhobor' ),
                    'after'  => '</div>',
                ) );
            ?>
        </div><!-- .post-excerpt -->
    </div><!-- .entry-content -->

    <!-- <footer class="entry-footer">
        <?php // desher_khobor_entry_footer(); ?>
    </footer> --> <!-- .entry-footer -->
</article><!-- #post-## -->
