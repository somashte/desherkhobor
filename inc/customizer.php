<?php
/**
 * desher-khobor Theme Customizer.
 *
 * @package desher-khobor
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function desher_khobor_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
}
add_action( 'customize_register', 'desher_khobor_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function desher_khobor_customize_preview_js() {
	wp_enqueue_script( 'desher_khobor_customizer_preview', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
// add_action( 'customize_preview_init', 'desher_khobor_customize_preview_js' );

/**
 * [desher_khobor_homepage_news_category description]
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function desher_khobor_homepage_news_category( $wp_customize ) {
    // panel
    $wp_customize->add_panel( 'theme_options', array(
        'title'          => __( 'Theme Options', 'desherkhobor' ),
        'capability'     => 'edit_theme_options',
        'priority'       => 130,
        'theme_supports' => '',
    ));
    // section
    $wp_customize->add_section( 'home_news_category', array(
        'title'          => __( 'Front Page News Categories', 'desherkhobor' ),
        'panel'          => 'theme_options',
        'priority'       => 20,
    ) );
    // set a priority used to order the social sites
    $priority = 5;

    // we loop over the categories and set the names and
    // labels we need
    $cats = array();
    foreach ( get_categories() as $categories => $category ) {
        $cats[$category->term_id] = $category->name;
    }

    for ($i=1; $i <= 3 ; $i++) {
        // setting
        $wp_customize->add_setting( 'category_' . $i, array(
            'sanitize_callback' => ''
        ) );
        // control
        $wp_customize->add_control('category_' . $i, array(
            'label'    => sprintf( __( 'Section %d', 'desherkhobor'), $i ),
            'section'  => __( 'home_news_category' ),
            'type'     => 'select',
            'choices'  => $cats,
            'priority' => $priority,
        ) );
        // increment the priority for next site
        $priority = $priority + 5;
    }
}
add_action( 'customize_register', 'desher_khobor_homepage_news_category' );

/**
 * [desher_khobor_social_array description]
 * @return [type] [description]
 */
function desher_khobor_social_array() {

    $social_sites = array(
        'facebook'      => 'dk_facebook_profile',
        'twitter'       => 'dk_twitter_profile',
        'google-plus'   => 'dk_googleplus_profile',
        'linkedin'      => 'dk_linkedin_profile',
        'rss'           => 'dk_rss_profile'
    );

    return apply_filters( 'desher_khobor_social_array_filter', $social_sites );
}
/**
 * [desher_khobor_social_link_section description]
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function desher_khobor_social_link_section( $wp_customize ) {

    $social_sites = desher_khobor_social_array();

    // set a priority used to order the social sites
    $priority = 5;

    // section
    $wp_customize->add_section( 'desher_khobor_social_icon', array(
        'title'       => __( 'Social Media Links', 'desherkhobor' ),
        'description' => __( 'Add the URL for each of your social profiles.', 'desherkhobor' ),
        'priority'    => 10,
        'panel'          => 'theme_options' // Not typically needed.
    ) );

    // create a setting and control for each social site
    foreach ( $social_sites as $social_site => $value ) {

        $label = ucfirst( $social_site );

        if ( $social_site == 'google-plus' ) {
            $label = 'Google Plus';
        } elseif ( $social_site == 'rss' ) {
            $label = 'RSS';
        }
        // setting
        $wp_customize->add_setting( $social_site, array(
            'sanitize_callback' => 'esc_url_raw'
        ) );
        // control
        $wp_customize->add_control( $social_site, array(
            'type'     => 'url',
            'label'    => $label,
            'section'  => 'desher_khobor_social_icon',
            'priority' => $priority
        ) );
        // increment the priority for next site
        $priority = $priority + 5;
    }
}
add_action( 'customize_register', 'desher_khobor_social_link_section' );

/**
 * [desher_khobor_show_social_icons description]
 * @return [type] [description]
 */
function desher_khobor_show_social_icons() {

    $social_sites = desher_khobor_social_array();

    // Any inputs that aren't empty are stored in $active_sites array
    foreach( $social_sites as $social_site => $value ) {
        if ( strlen( get_theme_mod( $social_site ) ) > 0 ) {
            $active_sites[] = $social_site;
        }
    }

    // For each active social site, add it as a list item
    if ( !empty( $active_sites ) ) {
        echo "<ul class='list-inline'>";

        foreach ( $active_sites as $active_site ) {
            $label = ucfirst( $active_site );
            if ( $active_site == 'google-plus' ) {
                $label = 'Google Plus';
            } elseif ( $active_site == 'linkedin' ) {
                $label = 'LinkedIn';
            } elseif ( $active_site == 'rss' ) {
                $label = 'RSS';
            } ?>
            <li>
                <a href="<?php echo get_theme_mod( $active_site ); ?>" class="<?php echo $active_site; ?>" target="_blank" data-toggle="tooltip" data-placement="left" title="<?php echo $label; ?>">
                    <i class="fa fa-fw fa-<?php echo $active_site; ?>" aria-hidden="true"></i>
                </a>
            </li> <?php
        }
        echo "</ul>";
    }
}

/**
 * [desher_khobor_marquee_newsfeed description]
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function desher_khobor_marquee_newsfeed( $wp_customize ) {
    // section
    $wp_customize->add_section( 'marquee_newsfeed', array(
        'title'       => __( 'Top Scrolling Newsfeed', 'desherkhobor' ),
        'description' => __( 'Select Tag for Top Scrolling Newsfeed', 'desherkhobor' ),
        'priority'    => 30,
        'panel'       => 'theme_options' // Not typically needed.
    ) );

    $tags = array();
    foreach ( get_tags() as $tag ) {
        $tags[$tag->term_id] = $tag->name;
    }

    // setting
    $wp_customize->add_setting( 'tag_selection', array(
        'sanitize_callback' => ''
    ) );
    // control
    $wp_customize->add_control( 'tag_selection', array(
        'label'       => __('Select Tag', 'desherkhobor'),
        'type'        => 'select',
        'choices'     => $tags,
        'section'     => 'marquee_newsfeed',
    ) );
}
add_action( 'customize_register', 'desher_khobor_marquee_newsfeed' );

/**
 * [show_headlines description]
 * @return [type] [description]
 */
function show_headlines( $tag_name, $post_count = 15 ) {
    $new = new WP_Query( array( 'post_type' => 'post', 'tag_id' => $tag_name, 'posts_per_page' => $post_count, 'caller_get_posts'=> 1 ) );
    if( $new->have_posts() ) {
        while ( $new->have_posts() ) : $new->the_post();
            echo'<a href="'; the_permalink(); echo'" class="h5">'.get_the_title().'</a> ** ';
        endwhile;
    }
    wp_reset_query();
}
