<?php
/**
 * Displays top header
 *
 * @package Desher_Khobor
 * @version 1.0
 */

?>
<div class="row top-header-bar">
    <div class="col-md-3">
        <div class="date-widget bg-gray-darker"><p class="text-center">আজ <?php echo convert_bengali(date('D, F j, Y')); ?></p></div>
    </div>

    <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>

    <div class="col-md-3 <?php if ( ! has_nav_menu( 'top' ) ) : ?> col-md-offset-6 <?php endif; ?>">
        <div class="social-links pull-right">
            <ul class="list-inline">
                <li><a href="#" class="facebook"><i class="fa fa-fw fa-facebook" aria-hidden="true"></i></a></li>
                <li><a href="#" class="twitter"><i class="fa fa-fw fa-twitter" aria-hidden="true"></i></a></li>
                <li><a href="#" class="google-plus"><i class="fa fa-fw fa-google-plus" aria-hidden="true"></i></a></li>
                <li><a href="#" class="linkedin"><i class="fa fa-fw fa-linkedin" aria-hidden="true"></i></a></li>
                <li><a href="#" class="rss"><i class="fa fa-fw fa-rss" aria-hidden="true"></i></a></li>
            </ul>
        </div>
    </div>
</div> <!-- .top-header-bar -->
