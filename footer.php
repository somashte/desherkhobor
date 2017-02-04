<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package desher-khobor
 */

?>

        <?php get_template_part( 'template-parts/navigation/navigation', 'footer' ); ?>

        </div> <!-- #content -->

        <footer id="colophon" class="site-footer row" role="contentinfo">
            <div class="site-info col-md-12 text-center">
                <h5>সম্পাদক: মীর মাসরুর জামান</h5>
                <h5>একটি সমষ্টি প্রকাশনা <span class="sep"> | </span> <a href="<?php echo esc_url( __( '//www.somashte.org/', 'desherkhobor' ) ); ?>"><?php printf( esc_html__( 'www.somashte.org', 'desherkhobor' )); ?></a></h5>
                <h5>ইমেইল: <a href="mailto:desherkhobor.net@gmail.com">desherkhobor.net@gmail.com</a></h5>
                <h5>&copy; দেশের খবর</h5>
            </div><!-- .site-info -->
            <div class="author-info col-md-12 text-center">
                <h6><?php printf( esc_html__( '%1$s by: %2$s', 'desherkhobor' ), 'Site developed', '<a href="//jobayerarman.github.io/" rel="developer">Jobayer Arman</a>, United Nations Online Volunteer Service' ); ?></h6>
            </div>
        </footer><!-- #colophon -->
    </div><!-- #page -->

    <?php wp_footer(); ?>

    </body>
</html>
