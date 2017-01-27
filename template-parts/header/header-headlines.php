<?php
/**
 * Displays headlines
 *
 * @package Desher_Khobor
 * @version 1.0
 */

?>

<div class="headlines-area">
    <div class="col-sm-1 headlines-title"><h5 class="text-center">শিরোনাম</h5></div>
    <div class="col-sm-11 headlines-posts"><h6>মোংলায় সেনা এলপিজি প্ল্যান্ট ও সেনা সিমেন্ট ফাক্টরির উদ্বোধন করলেন সেনাবাহিনী প্রধান </h6></div>
</div>

<div class="simple-marquee-container">
    <div class="marquee-sibling">
        শিরোনাম
    </div>
    <?php query_posts( array ( 'posts_per_page' => 15 ) ); ?>
    <div class="marquee">
        <ul class="marquee-content-items">
            <?php while (have_posts()) : the_post(); ?>
                <li><a href="<?php echo esc_url( get_permalink( get_the_ID() ) ); ?>"><?php the_title(); ?></a></li>
            <?php endwhile; // End the loop ?>
        </ul>
    </div>
    <?php wp_reset_query(); ?>
</div>
