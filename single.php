<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package desher-khobor-unv
 */

get_header(); ?>

    <div id="primary" class="content-area col-md-9">
        <main id="main" class="site-main" role="main">
            <div class="post-single-wrapper">

            <?php
            while ( have_posts() ) : the_post();

                get_template_part( 'template-parts/post/content-single', get_post_format() );

                ?> </div> <?php

                wp_bootstrap_pagination();

                ?>
                <div class="comment-wrapper"> <?php
                    // If comments are open or we have at least one comment, load up the comment template.
                    if ( comments_open() || get_comments_number() ) :
                        comments_template();
                    endif;
                ?> </div> <?php

            endwhile; // End of the loop.
            ?>
        </main><!-- #main -->
    </div><!-- #primary -->

<?php
get_sidebar();
get_footer();
