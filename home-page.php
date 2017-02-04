<?php
/**
 * Template Name: প্রচ্ছদ পাতা
 *
 * @package desher-khobor
 */

get_header(); ?>

<div class="col-md-8">
    <div class="section-wrapper">
        <section class="row">
            <div class="section-title">
                <h4><?php _e('প্রধান খবর', 'desher-khobor') ?></h4>
            </div>
            <div class="col-md-12">
                <?php $category_1 = Kirki::get_option( 'dk', 'category_for_section_1' ); ?>
                <?php query_posts( array ( 'category_name' => $category_1, 'posts_per_page' => 6 ) ); $counter = 0; $layout = 'col-md-6'; ?>
                <div class="news-list">
                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="<?php echo $layout; ?>" id="post-<?php the_ID(); ?>" role="article">
                                <div class="post-thumbnail"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' )); ?></div>
                                <h6><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?> <br> <small><?php echo convert_bengali(get_the_date()); ?></small></a></h6>
                                <p><?php the_excerpt(); ?></p>
                            </article>
                            <?php $counter++;
                            if ($counter % 2 == 0 && $counter < 6) {
                                echo '</div><br><div class="row">';
                            }
                        endwhile; // End the loop ?>
                    </div> <!-- /row -->
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="section-title">
                <h4><?php _e('স্থানীয় শীর্ষ', 'desher-khobor') ?></h4>
            </div>
            <div class="col-md-12">
                <?php $category_2 = Kirki::get_option( 'dk', 'category_for_section_2' ); ?>
                <?php query_posts( array ( 'category_name' => $category_2, 'posts_per_page' => 6 ) ); $counter = 0;?>
                <div class="news-list">
                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="col-md-6" id="post-<?php the_ID(); ?>" role="article">
                                <div class="post-thumbnail"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' )); ?></div>
                                <h6><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?> <br> <small><?php echo convert_bengali(get_the_date()); ?></small></a></h6>
                                <p><?php the_excerpt(); ?></p>
                            </article>
                            <?php $counter++;
                            if ($counter % 2 == 0) {
                                echo '</div><div class="row">';
                            }
                        endwhile; // End the loop ?>
                    </div> <!-- /row -->
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="section-title">
                <h4><?php _e('অন্যান্য খবর', 'desher-khobor') ?></h4>
            </div>
            <div class="col-md-12">
                <?php $category_3 = Kirki::get_option( 'dk', 'category_for_section_3' ); ?>
                <?php query_posts( array ( 'category_name' => $category_3, 'posts_per_page' => 6 ) ); $counter = 0;?>
                <div class="news-list">
                    <div class="row">
                        <?php while (have_posts()) : the_post(); ?>
                            <article class="col-md-6" id="post-<?php the_ID(); ?>" role="article">
                                <div class="post-thumbnail"><?php the_post_thumbnail( 'medium', array( 'class' => 'img-responsive' )); ?></div>
                                <h6><a href="#"><?php the_title(); ?> <br> <small><?php echo convert_bengali(get_the_date()); ?></small></a></h6>
                                <p><?php the_excerpt(); ?></p>
                            </article>
                            <?php $counter++;
                            if ($counter % 2 == 0) {
                                echo '</div><div class="row">';
                            }
                        endwhile; // End the loop ?>
                    </div> <!-- /row -->
                    <?php wp_reset_query(); ?>
                </div>
            </div>
        </section>
    </div>
</div>

<?php
get_sidebar();
get_footer();
