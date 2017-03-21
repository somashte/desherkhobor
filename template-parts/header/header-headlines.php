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
    <div class="col-sm-11 headlines-posts">
        <marquee onmouseover="this.stop();" onmouseout="this.start();" scrollamount="6">
            <?php
            $tag =  get_theme_mod( 'tag_selection' );
            if ( !empty( $tag ) ) {
                show_headlines( $tag );
            } ?>
        </marquee>
    </div>
</div>
