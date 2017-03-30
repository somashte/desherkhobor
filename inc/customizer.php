<?php
/**
 * Desher Khobor Theme Customizer.
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
 * [desher_khobor_theme_option description]
 * @param  [type] $wp_customize [description]
 */
function desher_khobor_theme_option( $wp_customize ) {
    // panel
    $wp_customize->add_panel( 'theme_options', array(
        'title'          => __( 'Theme Options', 'desherkhobor' ),
        'capability'     => 'edit_theme_options',
        'priority'       => 130,
        'theme_supports' => '',
    ));
}
add_action( 'customize_register', 'desher_khobor_theme_option' );

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
        'panel'       => 'theme_options' // Not typically needed.
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
            'type'              => 'theme_mod',
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
        'priority'    => 20,
        'panel'       => 'theme_options' // Not typically needed.
    ) );

    $tags = array();
    foreach ( get_tags() as $tag ) {
        $tags[$tag->term_id] = $tag->name;
    }

    // setting
    $wp_customize->add_setting( 'tag_selection', array(
        'type'              => 'theme_mod',
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
    $new = new WP_Query( array( 'post_type' => 'post', 'tag_id' => $tag_name, 'posts_per_page' => $post_count, 'caller_get_posts' => 1 ) );
    if( $new->have_posts() ) {
        while ( $new->have_posts() ) : $new->the_post();
            echo'<a href="'; the_permalink(); echo'" class="h5">'.get_the_title().'</a> ** ';
        endwhile;
    }
    wp_reset_query();
}

/**
 * [desher_khbor_homepage_news_slider description]
 * @param  [type] $wp_customize [description]
 */
function desher_khobor_homepage_news_slider( $wp_customize ) {
    // section
    $wp_customize->add_section( 'home_news_slider', array(
        'title'          => __( 'Front Page News Carousel', 'desherkhobor' ),
        'description'    => __( 'Settings for Front Page Image Corousel', 'desherkhobor' ),
        'panel'          => 'theme_options',
        'priority'       => 30,
    ) );

    $tags = array();
    foreach ( get_tags() as $tag ) {
        $tags[$tag->term_id] = $tag->name;
    }

    // setting
    $wp_customize->add_setting( 'slider_tag', array(
        'type'              => 'theme_mod',
        'sanitize_callback' => ''
    ) );
    $wp_customize->add_setting( 'slider_number', array(
        'type'              => 'theme_mod',
        'default'           => 5,
        'sanitize_callback' => ''
    ) );
    // control
    $wp_customize->add_control( 'slider_tag', array(
        'label'       => __('Select Tag', 'desherkhobor'),
        'description' => __( 'Select news tag to show.', 'desherkhobor' ),
        'type'        => 'select',
        'choices'     => $tags,
        'section'     => 'home_news_slider',
        'priority'    => 10
    ) );
    $wp_customize->add_control( 'slider_number', array(
        'label'       => __('Number of Posts', 'desherkhobor'),
        'description' => __( 'Input number of post to show. (Min = 3, Max = 25)', 'desherkhobor' ),
        'type'        => 'number',
        'input_attrs' => array('min' => '3', 'max' => '25'),
        'section'     => 'home_news_slider',
        'priority'    => 20
    ) );
}
add_action( 'customize_register', 'desher_khobor_homepage_news_slider' );

/**
 * [desher_khobor_show_carousel description]
 * @param  [type]  $tag_name   [description]
 * @param  integer $post_count [description]
 */
function desher_khobor_show_carousel() {
    $tag_id     =  get_theme_mod( 'slider_tag' );
    $post_count =  get_theme_mod( 'slider_number' );
    $i = 0;
    $active = 1;

    $carousel = new WP_Query( array( 'post_type' => 'post', 'tag_id' => $tag_id, 'posts_per_page' => $post_count, 'caller_get_posts' => 1 ) );
    ?>
    <div id="front-carousel" class="carousel slide" data-ride="carousel">
    <?php if( $carousel->have_posts() ) { ?>
        <!-- Wrapper for slides -->
        <div class="carousel-inner">
        <?php while ( $carousel->have_posts() ) : $carousel->the_post(); ?>
            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); ?>
            <div style="background: url('<?php echo $image[0]; ?>') no-repeat center top; background-size: cover; height: 400px; width: 100%;" class="item <?php echo ( $active = $active && !$i ) ? 'active' : '' ;?>">
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( '%s', 'desherkhobor' ), the_title_attribute( 'echo=0' ) ) ); ?>" class="carousel-caption" rel="bookmark"><h5><?php the_title(); ?></h5></a>
            </div>
        <?php $i++; endwhile;
    } ?>
        </div>
        <!-- Controls -->
        <a class="left carousel-control" href="#front-carousel" role="button" data-slide="prev">
            <span class="fa fa-chevron-left"></span>
        </a>
        <a class="right carousel-control" href="#front-carousel" role="button" data-slide="next">
            <span class="fa fa-chevron-right"></span>
        </a>
    </div> <!-- end of front-carousel -->
    <?php wp_reset_query();
}

/**
 * [desher_khobor_homepage_news_category description]
 * @param  [type] $wp_customize [description]
 * @return [type]               [description]
 */
function desher_khobor_homepage_news_category( $wp_customize ) {
    // section
    $wp_customize->add_section( 'home_news_category', array(
        'title'          => __( 'Front Page News Categories', 'desherkhobor' ),
        'panel'          => 'theme_options',
        'priority'       => 40,
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
