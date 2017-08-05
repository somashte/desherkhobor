<?php
/**
 * Template part for displaying a message that posts cannot be found.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package desher-khobor-unv
 */

?>

<section class="no-results not-found">

    <div class="page-content">
        <?php
        if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>

            <p><?php printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'desher-khobor-unv' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'post-new.php' ) ) ); ?></p>

        <?php elseif ( is_search() ) : ?>

            <p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'desher-khobor-unv' ); ?></p>
            <?php
                get_search_form();

        else : ?>
            <h2 class="no-results-text"><?php esc_html_e( 'কোন পোষ্ট খুঁজে পাওয়া যায়নি', 'desher-khobor-unv' ); ?></h2>

            <?php endif; ?>
    </div><!-- .page-content -->
</section><!-- .no-results -->
