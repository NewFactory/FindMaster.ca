<?php

/**
 * Option Panel
 *
 * @package Shopical
 */

$default = shopical_get_default_theme_options();
/*theme option panel info*/
require get_template_directory().'/inc/customizer/theme-options-frontpage.php';

//contact page options
require get_template_directory().'/inc/customizer/theme-options-contacts.php';

//woocommerce options
require get_template_directory().'/inc/customizer/theme-options-woocommerce.php';

//font and color options
require get_template_directory().'/inc/customizer/theme-options-fonts-colors.php';

// Add Theme Options Panel.
$wp_customize->add_panel('theme_option_panel',
	array(
		'title'      => esc_html__('Theme Options', 'shopical'),
		'priority'   => 200,
		'capability' => 'edit_theme_options',
	)
);


// Preloader Section.
$wp_customize->add_section('site_preloader_settings',
    array(
        'title'      => esc_html__('Preloader Options', 'shopical'),
        'priority'   => 4,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - preloader.
$wp_customize->add_setting('enable_site_preloader',
    array(
        'default'           => $default['enable_site_preloader'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('enable_site_preloader',
    array(
        'label'    => esc_html__('Enable preloader', 'shopical'),
        'section'  => 'site_preloader_settings',
        'type'     => 'checkbox',
        'priority' => 10,
    )
);


/**
 * Header section
 *
 * @package Shopical
 */

// Frontpage Section.
$wp_customize->add_section('top_header_options_settings',
	array(
		'title'      => esc_html__('Top Header Options', 'shopical'),
		'priority'   => 49,
		'capability' => 'edit_theme_options',
		'panel'      => 'theme_option_panel',
	)
);


// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header',
    array(
        'default'           => $default['show_top_header'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header',
    array(
        'label'    => esc_html__('Show Top Header', 'shopical'),
        'section'  => 'top_header_options_settings',
        'type'     => 'checkbox',
        'priority' => 5,

    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header_store_contacts',
    array(
        'default'           => $default['show_top_header_store_contacts'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header_store_contacts',
    array(
        'label'    => esc_html__('Show Store Address and Contacts', 'shopical'),
        'section'  => 'top_header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,
        'active_callback' => 'shopical_top_header_status'
    )
);


// Setting - show_site_title_section.
$wp_customize->add_setting('show_top_header_social_contacts',
    array(
        'default'           => $default['show_top_header_social_contacts'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_top_header_social_contacts',
    array(
        'label'    => esc_html__('Show Social Menu', 'shopical'),
        'section'  => 'top_header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,
        'active_callback' => 'shopical_top_header_status'
    )
);

// Frontpage Section.
$wp_customize->add_section('header_options_settings',
    array(
        'title'      => esc_html__('Header Options', 'shopical'),
        'priority'   => 49,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('header_layout',
    array(
        'default'           => $default['header_layout'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control( 'header_layout',
    array(
        'label'       => esc_html__('Header Layout', 'shopical'),
        'description' => esc_html__('Select global header layout', 'shopical'),
        'section'     => 'header_options_settings',
        'type'        => 'select',
        'choices'               => array(
            'header-style-1' => esc_html__( 'Header - Default', 'shopical' ),
            'header-style-2' => esc_html__( 'Header - Express', 'shopical' ),
            'header-style-3' => esc_html__( 'Header - Centered', 'shopical' ),
            'header-style-4' => esc_html__( 'Header - Compressed', 'shopical' ),

        ),
        'priority'    => 10,
    ));


// Setting - sticky_header_option.
$wp_customize->add_setting('disable_sticky_header_option',
    array(
        'default'           => $default['disable_sticky_header_option'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);
$wp_customize->add_control('disable_sticky_header_option',
    array(
        'label'    => esc_html__('Disable Sticky Header', 'shopical'),
        'section'  => 'header_options_settings',
        'type'     => 'checkbox',
        'priority' => 10,

    )
);




/**
 * Layout options section
 *
 * @package Shopical
 */

// Layout Section.
$wp_customize->add_section('site_layout_settings',
    array(
        'title'      => esc_html__('Global Layout Options', 'shopical'),
        'priority'   => 9,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('global_content_alignment',
    array(
        'default'           => $default['global_content_alignment'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control( 'global_content_alignment',
    array(
        'label'       => esc_html__('Global Content Alignment', 'shopical'),
        'description' => esc_html__('Select global content alignment', 'shopical'),
        'section'     => 'site_layout_settings',
        'type'        => 'select',
        'choices'               => array(
            'align-content-left' => esc_html__( 'Content - Primary Sidebar', 'shopical' ),
            'align-content-right' => esc_html__( 'Primary Sidebar - Content', 'shopical' ),
            'full-width-content' => esc_html__( 'Full Width Content', 'shopical' )
        ),
        'priority'    => 130,
    ));

//========= secure payment icon option
// Advertisement Section.
$wp_customize->add_section('secure_payment_badge_settings',
    array(
        'title'      => esc_html__('Secure Payment Badge Options', 'shopical'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);



// Setting banner_advertisement_section.
$wp_customize->add_setting('secure_payment_badge',
    array(
        'default'           => $default['secure_payment_badge'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'secure_payment_badge',
        array(
            'label'       => esc_html__('Banner Section Advertisement', 'shopical'),
            'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'shopical'), 600, 190),
            'section'     => 'secure_payment_badge_settings',
            'width' => 600,
            'height' => 190,
            'flex_width' => true,
            'flex_height' => true,
            'priority'    => 120,
        )
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('secure_payment_badge_url',
    array(
        'default'           => $default['secure_payment_badge_url'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('secure_payment_badge_url',
    array(
        'label'    => esc_html__('URL Link', 'shopical'),
        'section'  => 'secure_payment_badge_settings',
        'type'     => 'text',
        'priority' => 130,
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('secure_payment_badge_open_in_new_tab',
    array(
        'default'           => $default['secure_payment_badge_open_in_new_tab'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);
$wp_customize->add_control('secure_payment_badge_open_in_new_tab',
    array(
        'label'    => esc_html__('Open in new tab', 'shopical'),
        'section'  => 'secure_payment_badge_settings',
        'type'     => 'checkbox',
        'priority' => 130,
    )
);



//========== mailchimp subscription box options ===============

// Footer Section.
$wp_customize->add_section('site_footer_mailchimp_settings',
    array(
        'title'      => esc_html__('Mailchimp Subscriptions', 'shopical'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - mailchimp.
$wp_customize->add_setting('footer_show_mailchimp_subscriptions',
    array(
        'default'           => $default['footer_show_mailchimp_subscriptions'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control( 'footer_show_mailchimp_subscriptions',
    array(
        'label'    => __( 'Show above footer', 'shopical' ),
        'section'  => 'site_footer_mailchimp_settings',
        'type'     => 'checkbox',
        'priority' => 100,
    )
);

// Setting - mailchimp.
$wp_customize->add_setting('footer_mailchimp_title',
    array(
        'default'           => $default['footer_mailchimp_title'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_mailchimp_title',
    array(
        'label'    => __( 'Title', 'shopical' ),
        'section'  => 'site_footer_mailchimp_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_mailchimp_subscriptions_status'
    )
);

// Setting - mailchimp.
$wp_customize->add_setting('footer_mailchimp_subtitle',
    array(
        'default'           => $default['footer_mailchimp_subtitle'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_mailchimp_subtitle',
    array(
        'label'    => __( 'Subitle', 'shopical' ),
        'section'  => 'site_footer_mailchimp_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_mailchimp_subscriptions_status'
    )
);


// Setting - mailchimp.
$wp_customize->add_setting('footer_mailchimp_shortcode',
    array(
        'default'           => $default['footer_mailchimp_shortcode'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_mailchimp_shortcode',
    array(
        'label'    => __( 'Shortcode', 'shopical' ),
        'section'  => 'site_footer_mailchimp_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_mailchimp_subscriptions_status'
    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('footer_mailchimp_background_color',
    array(
        'default'           => $default['footer_mailchimp_background_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'footer_mailchimp_background_color',
        array(
            'label'      => esc_html__( 'Mailchimp background color', 'shopical' ),
            'section'    => 'site_footer_mailchimp_settings',
            'settings'   => 'footer_mailchimp_background_color',
            'priority' => 100,
            'active_callback' => 'shopical_mailchimp_subscriptions_status'

        )
    )
);

// Setting - show_site_title_section.
$wp_customize->add_setting('footer_mailchimp_field_border_color',
    array(
        'default'           => $default['footer_mailchimp_field_border_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(
    new WP_Customize_Color_Control(
        $wp_customize,
        'footer_mailchimp_field_border_color',
        array(
            'label'      => esc_html__( 'Mailchimp Field Border color', 'shopical' ),
            'section'    => 'site_footer_mailchimp_settings',
            'settings'   => 'footer_mailchimp_field_border_color',
            'priority' => 100,
            'active_callback' => 'shopical_mailchimp_subscriptions_status'

        )
    )
);

// Setting number_of_footer_widget.
$wp_customize->add_setting('footer_mailchimp_subscriptions_scopes',
    array(
        'default'           => $default['footer_mailchimp_subscriptions_scopes'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);


$wp_customize->add_control('footer_mailchimp_subscriptions_scopes',
    array(
        'label'    => esc_html__('Visible in:', 'shopical'),
        'section'  => 'site_footer_mailchimp_settings',
        'type'     => 'select',
        'priority' => 100,
        'choices'  => array(
            'front-page' => esc_html__('Front page only', 'shopical'),
            'all-pages'        => esc_html__('All pages', 'shopical'),

        ),
        'active_callback' => 'shopical_mailchimp_subscriptions_status'
    )
);




//========== footer instagram options ===============

// Footer Section.
$wp_customize->add_section('site_footer_instagram_settings',
    array(
        'title'      => esc_html__('Instagram carousel', 'shopical'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - instagram posts.
$wp_customize->add_setting('footer_show_instagram_post_carousel',
    array(
        'default'           => $default['footer_show_instagram_post_carousel'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control( 'footer_show_instagram_post_carousel',
    array(
        'label'    => __( 'Show above footer', 'shopical' ),
        'section'  => 'site_footer_instagram_settings',
        'type'     => 'checkbox',
        'priority' => 100,
    )
);

// Setting - instagram username of news.
$wp_customize->add_setting('instagram_username',
    array(
        'default'           => $default['instagram_username'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'instagram_username',
    array(
        'label'    => __( 'Instagram username', 'shopical' ),
        'section'  => 'site_footer_instagram_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_footer_instagram_posts_status'
    )
);

// Setting - instagram username of news.
$wp_customize->add_setting('instagram_access_token',
    array(
        'default'           => $default['instagram_access_token'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'instagram_access_token',
    array(
        'label'    => __( 'Instagram access token', 'shopical' ),
        'description' => esc_html__('Please use your instagram app access token if you aleady have, Otherwise create new: "https://www.instagram.com/developer".', 'shopical'),
        'section'  => 'site_footer_instagram_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_footer_instagram_posts_status'
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('number_of_instagram_posts',
    array(
        'default'           => $default['number_of_instagram_posts'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control( 'number_of_instagram_posts',
    array(
        'label'    => __( 'Number of Instagram posts', 'shopical' ),
        'section'  => 'site_footer_instagram_settings',
        'type'     => 'text',
        'priority' => 100,
        'active_callback' => 'shopical_footer_instagram_posts_status'
    )
);

// Setting number_of_footer_widget.
$wp_customize->add_setting('footer_instagram_post_carousel_scopes',
    array(
        'default'           => $default['footer_instagram_post_carousel_scopes'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);


$wp_customize->add_control('footer_instagram_post_carousel_scopes',
    array(
        'label'    => esc_html__('Visible in:', 'shopical'),
        'section'  => 'site_footer_instagram_settings',
        'type'     => 'select',
        'priority' => 100,
        'choices'  => array(
            'front-page' => esc_html__('Front page only', 'shopical'),
            'all-pages'        => esc_html__('All pages', 'shopical'),

        ),
        'active_callback' => 'shopical_footer_instagram_posts_status'
    )
);


//========== footer scroll to top options ===============

// Footer Section.
$wp_customize->add_section('site_scroll_to_top_settings',
    array(
        'title'      => esc_html__('Scroll to Top', 'shopical'),
        'priority'   => 100,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting number_of_footer_widget.
$wp_customize->add_setting('footer_scroll_to_top_position',
    array(
        'default'           => $default['footer_scroll_to_top_position'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);


$wp_customize->add_control('footer_scroll_to_top_position',
    array(
        'label'    => esc_html__('Select Position', 'shopical'),
        'section'  => 'site_scroll_to_top_settings',
        'type'     => 'select',
        'priority' => 100,
        'choices'  => array(
            'right-side'        => esc_html__('Right', 'shopical'),
            'left-side' => esc_html__('Left', 'shopical'),

        ),

    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('footer_scroll_to_top_icon',
    array(
        'default'           => $default['footer_scroll_to_top_icon'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_scroll_to_top_icon',
    array(
        'label'    => __( 'Icon', 'shopical' ),
        'section'  => 'site_scroll_to_top_settings',
        'type'     => 'text',
        'priority' => 100,
    )
);

//========== footer section options ===============
// Footer Section.
$wp_customize->add_section('site_footer_settings',
    array(
        'title'      => esc_html__('Footer Options', 'shopical'),
        'priority'   => 50,
        'capability' => 'edit_theme_options',
        'panel'      => 'theme_option_panel',
    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('footer_copyright_text',
    array(
        'default'           => $default['footer_copyright_text'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control( 'footer_copyright_text',
    array(
        'label'    => __( 'Copyright Text', 'shopical' ),
        'section'  => 'site_footer_settings',
        'type'     => 'text',
        'priority' => 50,
    )
);





// Setting - global content alignment of news.
$wp_customize->add_setting('hide_footer_menu_section',
    array(
        'default'           => $default['hide_footer_menu_section'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control( 'hide_footer_menu_section',
    array(
        'label'    => __( 'Hide footer menu section', 'shopical' ),
        'section'  => 'site_footer_settings',
        'type'     => 'checkbox',
        'priority' => 50,
    )
);


// Setting - global content alignment of news.
$wp_customize->add_setting('hide_footer_copyright_credits',
    array(
        'default'           => $default['hide_footer_copyright_credits'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control( 'hide_footer_copyright_credits',
    array(
        'label'    => __( 'Hide theme credits', 'shopical' ),
        'section'  => 'site_footer_settings',
        'type'     => 'checkbox',
        'priority' => 50,
    )
);


//Navigation Color Details
//Slide Details
$wp_customize->add_setting('main_navigation_section_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new Shopical_Section_Title(
        $wp_customize,
        'main_navigation_section_title',
        array(
            'label' 			=> esc_html__( 'Main Navigation Color Section ', 'shopical' ),
            'section' 			=> 'header_options_settings',
            'priority' 			=> 100,
        )
    )
);


// Setting - slider_caption_bg_color.
$wp_customize->add_setting('main_navigation_background_color',
    array(
        'default'           => $default['main_navigation_background_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(

    new WP_Customize_Color_Control(
        $wp_customize,
        'main_navigation_background_color',
        array(
            'label'    => esc_html__('Background Color', 'shopical'),
            'section'  => 'header_options_settings',
            'type'     => 'color',
            'priority' => 100,
        )
    )
);

// Setting - slider_caption_bg_color.
$wp_customize->add_setting('main_navigation_link_color',
    array(
        'default'           => $default['main_navigation_link_color'],
        'capability'        => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_hex_color',
    )
);
$wp_customize->add_control(

    new WP_Customize_Color_Control(
        $wp_customize,
        'main_navigation_link_color',
        array(
            'label'    => esc_html__('Menu Item Color', 'shopical'),
            'section'  => 'header_options_settings',
            'type'     => 'color',
            'priority' => 100,
        )
    )
);
