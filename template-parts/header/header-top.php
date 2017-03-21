<?php
/**
 * Displays top header
 *
 * @package Desher_Khobor
 * @version 1.0
 */

?>
<div class="row top-bar-content">
    <div class="col-md-3">
        <div class="date-widget bg-gray-darker"><p class="text-center">আজ <?php echo convert_bengali(date('D, F j, Y')); ?></p></div>
    </div>

    <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>

    <div class="col-md-3 <?php if ( ! has_nav_menu( 'top' ) ) : ?> col-md-offset-6 <?php endif; ?>">
        <div class="social-links pull-right">
            <?php desher_khobor_show_social_icons(); ?>
        </div>
    </div>
</div> <!-- .top-header-bar -->
