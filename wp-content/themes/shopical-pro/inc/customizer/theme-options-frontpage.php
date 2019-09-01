<?php

/**
 * Option Panel
 *
 * @package Shopical
 */

$default = shopical_get_default_theme_options();

/**
 * Frontpage options section
 *
 * @package Shopical
 */


// Add Frontpage Options Panel.
$wp_customize->add_panel('frontpage_option_panel',
    array(
        'title' => esc_html__('Frontpage Main Banner Options', 'shopical'),
        'priority' => 199,
        'capability' => 'edit_theme_options',
    )
);


// Advertisement Section.
$wp_customize->add_section('frontpage_advertisement_settings',
    array(
        'title' => esc_html__('Banner Advertisement', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);


// Setting banner_advertisement_section.
$wp_customize->add_setting('banner_advertisement_section',
    array(
        'default' => $default['banner_advertisement_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);


$wp_customize->add_control(
    new WP_Customize_Cropped_Image_Control($wp_customize, 'banner_advertisement_section',
        array(
            'label' => esc_html__('Banner Section Advertisement', 'shopical'),
            'description' => sprintf(esc_html__('Recommended Size %1$s px X %2$s px', 'shopical'), 1500, 100),
            'section' => 'frontpage_advertisement_settings',
            'width' => 1500,
            'height' => 100,
            'flex_width' => true,
            'flex_height' => true,
            'priority' => 120,
        )
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_section_url',
    array(
        'default' => $default['banner_advertisement_section_url'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'esc_url_raw',
    )
);
$wp_customize->add_control('banner_advertisement_section_url',
    array(
        'label' => esc_html__('URL Link', 'shopical'),
        'section' => 'frontpage_advertisement_settings',
        'type' => 'text',
        'priority' => 130,
    )
);

/*banner_advertisement_section_url*/
$wp_customize->add_setting('banner_advertisement_open_on_new_tab',
    array(
        'default' => $default['banner_advertisement_open_on_new_tab'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);
$wp_customize->add_control('banner_advertisement_open_on_new_tab',
    array(
        'label' => esc_html__('Open in new tab', 'shopical'),
        'section' => 'frontpage_advertisement_settings',
        'type' => 'checkbox',
        'priority' => 130,
    )
);


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('banner_advertisement_scope',
    array(
        'default' => $default['banner_advertisement_scope'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('banner_advertisement_scope',
    array(
        'label' => esc_html__('Show banner advertisement on', 'shopical'),
        'description' => esc_html__('Select scope to display on banner advertisement section', 'shopical'),
        'section' => 'frontpage_advertisement_settings',
        'type' => 'select',
        'choices' => array(
            'front-page-only' => esc_html__('Show on Homepage only', 'shopical'),
            'site-wide' => esc_html__('Show sitewide', 'shopical'),
        ),
        'priority' => 130,

    ));


/**
 * Main Banner Layout Options ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_main_banner_layout_section_settings',
    array(
        'title' => esc_html__('Layout Options', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('show_main_banner_section',
    array(
        'default' => $default['show_main_banner_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_main_banner_section',
    array(
        'label' => esc_html__('Enable Main Banner Section', 'shopical'),
        'section' => 'frontpage_main_banner_layout_section_settings',
        'type' => 'checkbox',
        'priority' => 100,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('show_latest_product_section',
    array(
        'default' => $default['show_latest_product_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_latest_product_section',
    array(
        'label' => esc_html__('Enable Latest Products Section', 'shopical'),
        'section' => 'frontpage_main_banner_layout_section_settings',
        'type' => 'checkbox',
        'priority' => 100,
        'active_callback' => function ($control) {
            return (
                shopical_show_main_banner_section_status($control)
                &&
                shopical_frontpage_main_banner_layout_latest_product_status($control)
            );
        },

    )
);

// Setting - global content alignment of news.
$wp_customize->add_setting('frontpage_main_banner_layout',
    array(
        'default' => $default['frontpage_main_banner_layout'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_radio_sanitization',
    )
);

$wp_customize->add_control(new Shopical_Image_Radio_Button_Custom_Control($wp_customize, 'frontpage_main_banner_layout',
    array(
        'label' => esc_html__('Main Banner Layouts', 'shopical'),
        'description' => esc_html__('Select global header layout', 'shopical'),
        'section' => 'frontpage_main_banner_layout_section_settings',
        'type' => 'radio-image',
        'priority' => 100,
        'choices' => array(

            'main-banner-style-1' => array(  // Required. Value for this particular radio button choice
                'image' => trailingslashit(get_template_directory_uri()) . 'inc/customizer/images/banner-layouts1.png', // Required. URL for the image
                'name' => __('Default', 'shopical') // Required. Title text to display
            ),
            'main-banner-style-2' => array(
                'image' => trailingslashit(get_template_directory_uri()) . 'inc/customizer/images/banner-layouts2.png',
                'name' => __('Top Categories and Main Slider', 'shopical')
            ),
            'main-banner-style-3' => array(
                'image' => trailingslashit(get_template_directory_uri()) . 'inc/customizer/images/banner-layouts3.png',
                'name' => __('Main Slider and Thumbnail Slider', 'shopical')
            ),
            'main-banner-style-4' => array(
                'image' => trailingslashit(get_template_directory_uri()) . 'inc/customizer/images/banner-layouts4.png',
                'name' => __('Main Slider', 'shopical')
            ),
            'main-banner-style-5' => array(
                'image' => trailingslashit(get_template_directory_uri()) . 'inc/customizer/images/banner-layouts5.png',
                'name' => __('Top Categories, Main Slider with Product', 'shopical')
            )
        ),
        'active_callback' => 'shopical_show_main_banner_section_status'

    )

));




// Setting - show_main_banner_section.
$wp_customize->add_setting('show_horizontal_category_section',
    array(
        'default' => $default['show_horizontal_category_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_horizontal_category_section',
    array(
        'label' => esc_html__('Show Category Section', 'shopical'),
        'section' => 'frontpage_main_banner_layout_section_settings',
        'type' => 'checkbox',
        'priority' => 100,
        'active_callback' => function ($control) {
            return (
                shopical_show_main_banner_section_status($control)
                &&
                shopical_frontpage_main_banner_layout_category_status($control)
            );
        },
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_horizontal_page_grid_section',
    array(
        'default' => $default['show_horizontal_page_grid_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_horizontal_page_grid_section',
    array(
        'label' => esc_html__('Show Page Thumbs Section', 'shopical'),
        'section' => 'frontpage_main_banner_layout_section_settings',
        'type' => 'checkbox',
        'priority' => 100,
        'active_callback' => function ($control) {
            return (
                shopical_show_main_banner_section_status($control)
                &&
                shopical_frontpage_main_banner_layout_page_thumb_status($control)
            );
        },
    )
);

/**
 * Latest Products Section ===============================================================
 * */

// Latest Products Section
$wp_customize->add_section('frontpage_latest_product_section_settings',
    array(
        'title' => esc_html__('Latest Products', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);




$wp_customize->add_setting("latest_product_categories",
    array(
        'default' => $default["latest_product_categories"],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(new Shopical_Dropdown_Taxonomies_Control($wp_customize, 'latest_product_categories',
    array(
        'label' => esc_html__('Product Categories', 'shopical'),
        'section' => 'frontpage_latest_product_section_settings',
        'type' => 'dropdown-taxonomies',
        'taxonomy' => 'product_cat',
        'priority' => 100,
        //'active_callback' => 'shopical_trending_news_section_status'
    )));

// Setting - show_main_banner_section.
$wp_customize->add_setting('show_latest_product_lists_button',
    array(
        'default' => $default['show_latest_product_lists_button'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_latest_product_lists_button',
    array(
        'label' => esc_html__('Show Buttons', 'shopical'),
        'section' => 'frontpage_latest_product_section_settings',
        'type' => 'checkbox',
        'priority' => 100,

    )
);

/**
 * Top Categories Section ===============================================================
 * */

// Top Categories Section
$wp_customize->add_section('frontpage_top_categories_section_settings',
    array(
        'title' => esc_html__('Top Categories', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('top_categories_section_title',
    array(
        'default' => $default['top_categories_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('top_categories_section_title',
    array(
        'label' => esc_html__('Top Category Section Title', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('select_top_categories_section_mode',
    array(
        'default' => $default['select_top_categories_section_mode'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('select_top_categories_section_mode',
    array(
        'label' => esc_html__('Select Category Display Mode', 'shopical'),
        'description' => esc_html__('This option will be applicable for vertical lists of categories only.', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'list-only' => esc_html__("Categories List Only", 'shopical'),
            'show-nested-subcategories' => esc_html__("Nested Categories", 'shopical'),
            'show-subcategories-and-products' => esc_html__("Categories, Subcategories and Products", 'shopical'),
            'selected-categories' => esc_html__("Selected Categories List", 'shopical'),
        ),
        'priority' => 100,
        //'active_callback' => 'shopical_top_categories_section_status'
    ));


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('select_top_categories_on_hover',
    array(
        'default' => $default['select_top_categories_on_hover'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('select_top_categories_on_hover',
    array(
        'label' => esc_html__('Category List Hover Mode', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'plain-list' => esc_html__("None - List Only", 'shopical'),
            'top-5-products' => esc_html__("Show Top 5 Products", 'shopical'),

        ),
        'priority' => 100,
        'active_callback' => 'shopical_on_hover_top_categories_section_status'
    ));


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('select_top_categories_orderby',
    array(
        'default' => $default['select_top_categories_orderby'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('select_top_categories_orderby',
    array(
        'label' => esc_html__('Orderby', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'id' => esc_html__("ID", 'shopical'),
            'slug' => esc_html__("Slug", 'shopical'),
            'name' => esc_html__("Name", 'shopical'),

        ),
        'priority' => 100,
        'active_callback' => 'shopical_list_top_categories_section_status'
    ));


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('select_top_categories_order',
    array(
        'default' => $default['select_top_categories_order'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('select_top_categories_order',
    array(
        'label' => esc_html__('Order', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'DESC' => esc_html__("DESC", 'shopical'),
            'ASC' => esc_html__("ASC", 'shopical'),


        ),
        'priority' => 100,
        'active_callback' => 'shopical_list_top_categories_section_status'
    ));

//Slide Details
$wp_customize->add_setting('top_categories_selection_section_title',
    array(
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control(
    new Shopical_Section_Title(
        $wp_customize,
        'top_categories_selection_section_title',
        array(
            'label' => esc_html__('Set Top Categories', 'shopical'),
            'description' => esc_html__('Select Top Categories', 'shopical'),
            'section' => 'frontpage_top_categories_section_settings',
            'priority' => 100,
            'active_callback' => 'shopical_selected_top_categories_section_status'
        )
    )
);

$top_categories_number = 10;

for ($i = 1; $i <= $top_categories_number; $i++) {

    //Slide Details
    $wp_customize->add_setting("top_categories_" . $i,
        array(
            'default' => $default["top_categories_" . $i],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(new Shopical_Dropdown_Taxonomies_Control($wp_customize, 'top_categories_' . $i,
        array(
            'label' => esc_html__('Product Category', 'shopical') . ' - ' . $i,
            'section' => 'frontpage_top_categories_section_settings',
            'type' => 'dropdown-taxonomies',
            'taxonomy' => 'product_cat',
            'priority' => 100,
            'active_callback' => 'shopical_selected_top_categories_section_status'
        )));

}


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('show_top_categories_product_count',
    array(
        'default' => $default['show_top_categories_product_count'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('show_top_categories_product_count',
    array(
        'label' => esc_html__('Show Product Count', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__("Yes", 'shopical'),
            'false' => esc_html__("No", 'shopical'),
        ),
        'priority' => 100,
        //'active_callback' => 'shopical_main_slider_section_status'
    ));

// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('show_top_categories_product_onsale_count',
    array(
        'default' => $default['show_top_categories_product_onsale_count'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('show_top_categories_product_onsale_count',
    array(
        'label' => esc_html__('Show On-sale Product Count', 'shopical'),
        'section' => 'frontpage_top_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__("Yes", 'shopical'),
            'false' => esc_html__("No", 'shopical'),
        ),
        'priority' => 100,
        //'active_callback' => 'shopical_main_slider_section_status'
    ));

/**
 * Main Slider Slider Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_main_slider_section_settings',
    array(
        'title' => esc_html__('Main Slider', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);


// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('select_main_slider_section_mode',
    array(
        'default' => $default['select_main_slider_section_mode'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('select_main_slider_section_mode',
    array(
        'label' => esc_html__('Select Slider Mode', 'shopical'),
        'description' => esc_html__('Page Slider or Product Slider', 'shopical'),
        'section' => 'frontpage_main_slider_section_settings',
        'type' => 'select',
        'choices' => array(
            'page-slider' => esc_html__("Page Slider", 'shopical'),
            'product-slider' => esc_html__("Product Slider", 'shopical'),
        ),
        'priority' => 23,
        'active_callback' => 'shopical_main_slider_section_status'
    ));


$slider_number = 5;

for ($i = 1; $i <= $slider_number; $i++) {

    //Slide Details
    $wp_customize->add_setting('page_slide_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'page_slide_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Slide ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_main_slider_section_settings',
                'priority' => 100,
                'active_callback' => function ($control) {
                    return (
                        shopical_main_slider_section_status($control)
                        &&
                        shopical_page_slider_banner_mode_status($control)
                    );
                },
            )
        )
    );

    $wp_customize->add_setting("slider_page_$i",
        array(
            'sanitize_callback' => 'shopical_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control("slider_page_$i",
        array(
            'label' => esc_html__('Select Page', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'dropdown-pages',
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_page_slider_banner_mode_status($control)
                );
            },
        )
    );

    $wp_customize->add_setting("page_caption_position_$i",
        array(
            'default' => 'left',
            'sanitize_callback' => 'shopical_sanitize_select',
        )
    );

    $wp_customize->add_control("page_caption_position_$i",
        array(
            'label' => esc_html__('Caption Position', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'left' => esc_html__('Left', 'shopical'),
                'right' => esc_html__('Right', 'shopical'),
                'center' => esc_html__('Center', 'shopical'),
            ),
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_page_slider_banner_mode_status($control)
                );
            },
        )
    );

    // Setting slider readmore text.
    $wp_customize->add_setting("button_text_$i",
        array(
            'default' => esc_html__('Shop Now', 'shopical'),
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("button_text_$i",
        array(
            'label' => esc_html__('Button Text', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_page_slider_banner_mode_status($control)
                );
            },
        )
    );

    // Setting slider readmore link.
    $wp_customize->add_setting("button_link_$i",
        array(
            'default' => '',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("button_link_$i",
        array(
            'label' => esc_html__('Button Link', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_page_slider_banner_mode_status($control)
                );
            },
        )
    );

}


$slider_number = 5;

for ($i = 1; $i <= $slider_number; $i++) {

    //Slide Details
    $wp_customize->add_setting('product_slide_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'product_slide_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Slide ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_main_slider_section_settings',
                'priority' => 100,
                'active_callback' => function ($control) {
                    return (
                        shopical_main_slider_section_status($control)
                        &&
                        shopical_product_slider_banner_mode_status($control)
                    );
                },
            )
        )
    );

    $wp_customize->add_setting("slider_product_$i",
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("slider_product_$i",
        array(
            'label' => esc_html__('Product Id', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_product_slider_banner_mode_status($control)
                );
            },
        )
    );

    $wp_customize->add_setting("product_caption_position_$i",
        array(
            'default' => 'left',
            'sanitize_callback' => 'shopical_sanitize_select',
        )
    );

    $wp_customize->add_control("product_caption_position_$i",
        array(
            'label' => esc_html__('Caption Position', 'shopical'),
            'section' => 'frontpage_main_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'left' => esc_html__('Left', 'shopical'),
                'right' => esc_html__('Right', 'shopical'),
                'center' => esc_html__('Center', 'shopical'),
            ),
            'priority' => 100,
            'active_callback' => function ($control) {
                return (
                    shopical_main_slider_section_status($control)
                    &&
                    shopical_product_slider_banner_mode_status($control)
                );
            },
        )
    );

}

/**
 * First Thumbnail Slider Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_first_thumbnail_slider_section_settings',
    array(
        'title' => esc_html__('First Thumb Slider', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);

$first_thumbnail_slider_number = 3;

for ($i = 1; $i <= $first_thumbnail_slider_number; $i++) {


    //Slide Details
    $wp_customize->add_setting('first_thumbnail_slider_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'first_thumbnail_slider_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Slide ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_first_thumbnail_slider_section_settings',
                'priority' => 100,
            )
        )
    );

    //Slide Details
    $wp_customize->add_setting("first_thumbnail_slider_" . $i,
        array(
            'sanitize_callback' => 'shopical_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control("first_thumbnail_slider_" . $i,
        array(
            'label' => esc_html__('Select Page', 'shopical'),
            'section' => 'frontpage_first_thumbnail_slider_section_settings',
            'type' => 'dropdown-pages',
            'priority' => 100,

        )
    );

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('show_first_thumbnail_slider_page_title_' . $i,
        array(
            'default' => $default['show_first_thumbnail_slider_page_title_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'shopical_sanitize_select',
        )
    );

    $wp_customize->add_control('show_first_thumbnail_slider_page_title_' . $i,
        array(
            'label' => esc_html__('Show Page Title', 'shopical'),
            'section' => 'frontpage_first_thumbnail_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'true' => esc_html__("Yes", 'shopical'),
                'false' => esc_html__("No", 'shopical'),
            ),
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('first_thumbnail_slider_button_texts_' . $i,
        array(
            'default' => $default['first_thumbnail_slider_button_texts_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control('first_thumbnail_slider_button_texts_' . $i,
        array(
            'label' => esc_html__('Button Text', 'shopical'),
            'section' => 'frontpage_first_thumbnail_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('first_thumbnail_slider_link_' . $i,
        array(
            'default' => $default['first_thumbnail_slider_link_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control('first_thumbnail_slider_link_' . $i,
        array(
            'label' => esc_html__('Slide Link', 'shopical'),
            'section' => 'frontpage_first_thumbnail_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

}

/**
 * Second Thumbnail Slider Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_second_thumbnail_slider_section_settings',
    array(
        'title' => esc_html__('Second Thumb Slider', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_option_panel',
    )
);

$second_thumbnail_slider_number = 3;

for ($i = 1; $i <= $second_thumbnail_slider_number; $i++) {


    //Slide Details
    $wp_customize->add_setting('second_thumbnail_slider_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'second_thumbnail_slider_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Slide ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_second_thumbnail_slider_section_settings',
                'priority' => 100,
            )
        )
    );

    //Slide Details
    $wp_customize->add_setting("second_thumbnail_slider_" . $i,
        array(
            'sanitize_callback' => 'shopical_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control("second_thumbnail_slider_" . $i,
        array(
            'label' => esc_html__('Select Page', 'shopical'),
            'section' => 'frontpage_second_thumbnail_slider_section_settings',
            'type' => 'dropdown-pages',
            'priority' => 100,

        )
    );

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('show_second_thumbnail_slider_page_title_' . $i,
        array(
            'default' => $default['show_second_thumbnail_slider_page_title_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'shopical_sanitize_select',
        )
    );

    $wp_customize->add_control('show_second_thumbnail_slider_page_title_' . $i,
        array(
            'label' => esc_html__('Show Page Title', 'shopical'),
            'section' => 'frontpage_second_thumbnail_slider_section_settings',
            'type' => 'select',
            'choices' => array(
                'true' => esc_html__("Yes", 'shopical'),
                'false' => esc_html__("No", 'shopical'),
            ),
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('second_thumbnail_slider_button_texts_' . $i,
        array(
            'default' => $default['second_thumbnail_slider_button_texts_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control('second_thumbnail_slider_button_texts_' . $i,
        array(
            'label' => esc_html__('Button Text', 'shopical'),
            'section' => 'frontpage_second_thumbnail_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('second_thumbnail_slider_link_' . $i,
        array(
            'default' => $default['second_thumbnail_slider_link_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control('second_thumbnail_slider_link_' . $i,
        array(
            'label' => esc_html__('Slide Link', 'shopical'),
            'section' => 'frontpage_second_thumbnail_slider_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

}





// Add Frontpage Options Panel.
$wp_customize->add_panel('frontpage_featured_section_panel',
    array(
        'title' => esc_html__('Frontpage Featured Section', 'shopical'),
        'priority' => 199,
        'capability' => 'edit_theme_options',
    )
);

/**
 * Store Features Section ===========================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_store_features_section_settings',
    array(
        'title' => esc_html__('Store Features and Facilities', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_featured_section_panel',
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_store_features_section',
    array(
        'default' => $default['show_store_features_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_store_features_section',
    array(
        'label' => esc_html__('Enable Store Features Section', 'shopical'),
        'section' => 'frontpage_store_features_section_settings',
        'type' => 'checkbox',
        'priority' => 22,

    )
);

$features_number = 4;

for ($i = 1; $i <= $features_number; $i++) {

    //Slide Details
    $wp_customize->add_setting('store_features_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'store_features_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Features ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_store_features_section_settings',
                'priority' => 100,
                'active_callback' => 'shopical_store_features_section_status'

            )
        )
    );

    $wp_customize->add_setting("store_features_title_" . $i,
        array(
            'default' => $default["store_features_title_" . $i],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("store_features_title_" . $i,
        array(
            'label' => esc_html__('Feature Title', 'shopical'),
            'section' => 'frontpage_store_features_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => 'shopical_store_features_section_status'

        )
    );

    $wp_customize->add_setting("store_features_icon_" . $i,
        array(
            'default' => $default["store_features_icon_" . $i],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("store_features_icon_" . $i,
        array(
            'label' => esc_html__('Feature icon (Font Awesome)', 'shopical'),
            'section' => 'frontpage_store_features_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => 'shopical_store_features_section_status'

        )
    );

    $wp_customize->add_setting("store_features_desc_" . $i,
        array(
            'default' => $default["store_features_desc_" . $i],
            'sanitize_callback' => 'sanitize_text_field',
        )
    );
    $wp_customize->add_control("store_features_desc_" . $i,
        array(
            'label' => esc_html__('Feature descriptions', 'shopical'),
            'section' => 'frontpage_store_features_section_settings',
            'type' => 'text',
            'priority' => 100,
            'active_callback' => 'shopical_store_features_section_status'

        )
    );

}

/**
 * Featured Categories Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_featured_categories_section_settings',
    array(
        'title' => esc_html__('Featured Categories', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_featured_section_panel',
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_featured_categories_section',
    array(
        'default' => $default['show_featured_categories_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_featured_categories_section',
    array(
        'label' => esc_html__('Enable Featured Category Section', 'shopical'),
        'section' => 'frontpage_featured_categories_section_settings',
        'type' => 'checkbox',
        'priority' => 22,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('featured_categories_section_title',
    array(
        'default' => $default['featured_categories_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('featured_categories_section_title',
    array(
        'label' => esc_html__('Featured Category Section Title', 'shopical'),
        'section' => 'frontpage_featured_categories_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('featured_categories_section_title_note',
    array(
        'default' => $default['featured_categories_section_title_note'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('featured_categories_section_title_note',
    array(
        'label' => esc_html__('Featured Category Section Title Note', 'shopical'),
        'section' => 'frontpage_featured_categories_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

$featured_categories_number = 6;

for ($i = 1; $i <= $featured_categories_number; $i++) {

    //Slide Details
    $wp_customize->add_setting("featured_categories_" . $i,
        array(
            'default' => $default["featured_categories_" . $i],
            'sanitize_callback' => 'absint',
        )
    );
    $wp_customize->add_control(new Shopical_Dropdown_Taxonomies_Control($wp_customize, 'featured_categories_' . $i,
        array(
            'label' => esc_html__('Product Category', 'shopical') . ' - ' . $i,
            'section' => 'frontpage_featured_categories_section_settings',
            'type' => 'dropdown-taxonomies',
            'taxonomy' => 'product_cat',
            'priority' => 100,
            //'active_callback' => 'shopical_trending_news_section_status'
        )));

}

// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('show_featured_categories_product_count',
    array(
        'default' => $default['show_featured_categories_product_count'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('show_featured_categories_product_count',
    array(
        'label' => esc_html__('Show Product Count', 'shopical'),
        'section' => 'frontpage_featured_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__("Yes", 'shopical'),
            'false' => esc_html__("No", 'shopical'),
        ),
        'priority' => 100,
        //'active_callback' => 'shopical_main_slider_section_status'
    ));

// Setting - select_main_slider_section_mode.
$wp_customize->add_setting('show_featured_categories_product_onsale_count',
    array(
        'default' => $default['show_featured_categories_product_onsale_count'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_select',
    )
);

$wp_customize->add_control('show_featured_categories_product_onsale_count',
    array(
        'label' => esc_html__('Show On-sale Product Count', 'shopical'),
        'section' => 'frontpage_featured_categories_section_settings',
        'type' => 'select',
        'choices' => array(
            'true' => esc_html__("Yes", 'shopical'),
            'false' => esc_html__("No", 'shopical'),
        ),
        'priority' => 100,
        //'active_callback' => 'shopical_main_slider_section_status'
    ));


/**
 * Offer Page Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_offer_pages_section_settings',
    array(
        'title' => esc_html__('Store Offers', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_featured_section_panel',
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_offer_pages_section',
    array(
        'default' => $default['show_offer_pages_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_offer_pages_section',
    array(
        'label' => esc_html__('Enable Store Offers Section', 'shopical'),
        'section' => 'frontpage_offer_pages_section_settings',
        'type' => 'checkbox',
        'priority' => 22,

    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_offer_pages_section_title',
    array(
        'default' => $default['show_offer_pages_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('show_offer_pages_section_title',
    array(
        'label' => esc_html__('Store Offers Section Title', 'shopical'),
        'section' => 'frontpage_offer_pages_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('show_offer_pages_section_note',
    array(
        'default' => $default['show_offer_pages_section_note'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('show_offer_pages_section_note',
    array(
        'label' => esc_html__('Store Offers Section Title Note', 'shopical'),
        'section' => 'frontpage_offer_pages_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);


$offer_pages_number = 3;

for ($i = 1; $i <= $offer_pages_number; $i++) {


    //Slide Details
    $wp_customize->add_setting('store_offers_' . $i . '_section_title',
        array(
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control(
        new Shopical_Section_Title(
            $wp_customize,
            'store_offers_' . $i . '_section_title',
            array(
                'label' => esc_html__('Set Offer ', 'shopical') . ' - ' . $i,
                'section' => 'frontpage_offer_pages_section_settings',
                'priority' => 100,

            )
        )
    );

    //Slide Details
    $wp_customize->add_setting("offer_page_" . $i,
        array(
            'sanitize_callback' => 'shopical_sanitize_dropdown_pages',
        )
    );
    $wp_customize->add_control("offer_page_" . $i,
        array(
            'label' => esc_html__('Select Offer Page', 'shopical'),
            'section' => 'frontpage_offer_pages_section_settings',
            'type' => 'dropdown-pages',
            'priority' => 100,

        )
    );

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('show_offer_pages_page_title_' . $i,
        array(
            'default' => $default['show_offer_pages_page_title_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'shopical_sanitize_select',
        )
    );

    $wp_customize->add_control('show_offer_pages_page_title_' . $i,
        array(
            'label' => esc_html__('Show Page Title', 'shopical'),
            'section' => 'frontpage_offer_pages_section_settings',
            'type' => 'select',
            'choices' => array(
                'true' => esc_html__("Yes", 'shopical'),
                'false' => esc_html__("No", 'shopical'),
            ),
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('offer_pages_button_texts_' . $i,
        array(
            'default' => $default['offer_pages_button_texts_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'sanitize_text_field',
        )
    );

    $wp_customize->add_control('offer_pages_button_texts_' . $i,
        array(
            'label' => esc_html__('Button Text', 'shopical'),
            'section' => 'frontpage_offer_pages_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

    // Setting - select_main_slider_section_mode.
    $wp_customize->add_setting('offer_pages_link_' . $i,
        array(
            'default' => $default['offer_pages_link_' . $i],
            'capability' => 'edit_theme_options',
            'sanitize_callback' => 'esc_url_raw',
        )
    );

    $wp_customize->add_control('offer_pages_link_' . $i,
        array(
            'label' => esc_html__('Offer Link', 'shopical'),
            'section' => 'frontpage_offer_pages_section_settings',
            'type' => 'text',
            'priority' => 100,
            //'active_callback' => 'shopical_main_slider_section_status'
        ));

}

/**
 * Featured Categories Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_featured_product_section_settings',
    array(
        'title' => esc_html__('Featured Products', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_featured_section_panel',
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_featured_product_section',
    array(
        'default' => $default['show_featured_product_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_featured_product_section',
    array(
        'label' => esc_html__('Enable Featured Product Section', 'shopical'),
        'section' => 'frontpage_featured_product_section_settings',
        'type' => 'checkbox',
        'priority' => 22,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('featured_product_section_title',
    array(
        'default' => $default['featured_product_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('featured_product_section_title',
    array(
        'label' => esc_html__('Section Title', 'shopical'),
        'section' => 'frontpage_featured_product_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('featured_product_section_title_note',
    array(
        'default' => $default['featured_product_section_title_note'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('featured_product_section_title_note',
    array(
        'label' => esc_html__('Section Title Note', 'shopical'),
        'section' => 'frontpage_featured_product_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

$wp_customize->add_setting("featured_product_categories",
    array(
        'default' => $default["featured_product_categories"],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(new Shopical_Dropdown_Taxonomies_Control($wp_customize, 'featured_product_categories',
    array(
        'label' => esc_html__('Product Categories', 'shopical'),
        'section' => 'frontpage_featured_product_section_settings',
        'type' => 'dropdown-taxonomies',
        'taxonomy' => 'product_cat',
        'priority' => 100,
        //'active_callback' => 'shopical_trending_news_section_status'
    )));

// Setting - show_main_banner_section.
$wp_customize->add_setting('number_of_featured_product',
    array(
        'default' => $default['number_of_featured_product'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control('number_of_featured_product',
    array(
        'label' => esc_html__('No. of Products', 'shopical'),
        'section' => 'frontpage_featured_product_section_settings',
        'type' => 'number',
        'priority' => 100,

    )
);

/**
 * On-sale Products Categories Section ===============================================================
 * */

// Main banner Sider Section.
$wp_customize->add_section('frontpage_onsale_product_section_settings',
    array(
        'title' => esc_html__('On-sale Products', 'shopical'),
        'priority' => 50,
        'capability' => 'edit_theme_options',
        'panel' => 'frontpage_featured_section_panel',
    )
);


// Setting - show_main_banner_section.
$wp_customize->add_setting('show_onsale_product_section',
    array(
        'default' => $default['show_onsale_product_section'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'shopical_sanitize_checkbox',
    )
);

$wp_customize->add_control('show_onsale_product_section',
    array(
        'label' => esc_html__('Enable On-sale Product Section', 'shopical'),
        'section' => 'frontpage_onsale_product_section_settings',
        'type' => 'checkbox',
        'priority' => 22,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('onsale_product_section_title',
    array(
        'default' => $default['onsale_product_section_title'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('onsale_product_section_title',
    array(
        'label' => esc_html__('Section Title', 'shopical'),
        'section' => 'frontpage_onsale_product_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

// Setting - show_main_banner_section.
$wp_customize->add_setting('onsale_product_section_title_note',
    array(
        'default' => $default['onsale_product_section_title_note'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'sanitize_text_field',
    )
);

$wp_customize->add_control('onsale_product_section_title_note',
    array(
        'label' => esc_html__('Section Title Note', 'shopical'),
        'section' => 'frontpage_onsale_product_section_settings',
        'type' => 'text',
        'priority' => 100,

    )
);

$wp_customize->add_setting("onsale_product_categories",
    array(
        'default' => $default["onsale_product_categories"],
        'sanitize_callback' => 'absint',
    )
);
$wp_customize->add_control(new Shopical_Dropdown_Taxonomies_Control($wp_customize, 'onsale_product_categories',
    array(
        'label' => esc_html__('Product Categories', 'shopical'),
        'section' => 'frontpage_onsale_product_section_settings',
        'type' => 'dropdown-taxonomies',
        'taxonomy' => 'product_cat',
        'priority' => 100,
        //'active_callback' => 'shopical_trending_news_section_status'
    )));

// Setting - show_main_banner_section.
$wp_customize->add_setting('number_of_onsale_product',
    array(
        'default' => $default['number_of_onsale_product'],
        'capability' => 'edit_theme_options',
        'sanitize_callback' => 'absint',
    )
);

$wp_customize->add_control('number_of_onsale_product',
    array(
        'label' => esc_html__('No. of Products', 'shopical'),
        'section' => 'frontpage_onsale_product_section_settings',
        'type' => 'number',
        'priority' => 100,

    )
);