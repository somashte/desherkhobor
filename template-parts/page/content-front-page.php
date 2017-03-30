<?php
/**
 * Displays content for front page
 *
 * @package desher-khobor
 * @since 2.2.0
 * @version 1.0
 */

get_header(); ?>

<div class="section-wrapper">

    <section class="carousel-area row">
        <div class="col-md-12">
            <?php desher_khobor_show_carousel(); ?>
        </div>
    </section>

    <?php
    // Any inputs that aren't empty are stored in $active_sites array
    for ($i=1; $i <= 3 ; $i++) {
        if ( strlen( get_theme_mod( 'category_' . $i ) ) > 0 ) {
            $active_categories[] = get_theme_mod( 'category_' . $i );
        }
    }

    // For each category, add section
    if ( !empty( $active_categories ) ) {
        foreach ( $active_categories as $active_category ) { ?>
            <section class="row">
                <?php
                    $category = $active_category;
                    $label = get_the_category_by_ID( $category );
                    query_posts( array ( 'cat' => $category, 'posts_per_page' => 6 ) ); ?>
                <div class="col-md-12">
                    <div class="section-title">
                        <h4><?php echo $label; ?></h4>
                    </div>
                    <div class="news-list">
                        <div class="row">
                            <?php desherkhobor_frontpage_news_section(); ?>
                        </div>
                    </div>
                </div>
                <?php wp_reset_query(); ?>
            </section> <?php
        }
    } ?>
</div>

<?php
