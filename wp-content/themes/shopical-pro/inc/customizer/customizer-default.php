<?php
/**
 * Default theme options.
 *
 * @package Shopical
 */

if (!function_exists('shopical_get_default_theme_options')):

/**
 * Get default theme options
 *
 * @since 1.0.0
 *
 * @return array Default theme options.
 */
function shopical_get_default_theme_options() {

    $defaults = array();
    // Preloader options section
    $defaults['enable_site_preloader'] = 1;
    $defaults['site_preloader_background'] = '#f1f1f1';
    $defaults['site_preloader_spinner_color'] = '#dd3333';

    // Header options section
    $defaults['header_layout'] = 'header-style-1';
    $defaults['disable_sticky_header_option'] = 0;

    $defaults['show_top_header'] = 1;
    $defaults['show_top_header_store_contacts'] = 1;
    $defaults['show_top_header_social_contacts'] = 1;
    $defaults['top_header_background_color'] = "#222222";
    $defaults['top_header_text_color'] = "#ffffff";

    $defaults['show_top_menu'] = 0;
    $defaults['show_social_menu_section'] = 1;
    $defaults['show_minicart_section'] = 1;
    $defaults['show_store_contact_section'] = 1;


    $defaults['add_to_wishlist_icon'] = 'fa fa-heart-o';
    $defaults['already_in_wishlist_icon'] = 'fa fa-heart';

    $defaults['enable_header_image_tint_overlay'] = 0;
    $defaults['show_offpanel_menu_section'] = 1;


    $defaults['banner_advertisement_section'] = '';
    $defaults['banner_advertisement_section_url'] = '';
    $defaults['banner_advertisement_open_on_new_tab'] = 1;
    $defaults['banner_advertisement_scope'] = 'front-page-only';


    // breadcrumb options section
    $defaults['enable_general_breadcrumb'] = 'yes';
    $defaults['select_breadcrumb_mode'] = 'simple';


    $defaults['show_latest_product_section'] = 1;
    $defaults['latest_product_categories'] = 0;
    $defaults['number_of_latest_product'] = 5;
    $defaults['show_latest_product_lists_button'] = 1;


    $defaults['top_categories_section_title'] = 'Top Categories';
    $defaults['top_categories_1'] = 0;
    $defaults['top_categories_2'] = 0;
    $defaults['top_categories_3'] = 0;
    $defaults['top_categories_4'] = 0;
    $defaults['top_categories_5'] = 0;
    $defaults['top_categories_6'] = 0;
    $defaults['top_categories_7'] = 0;
    $defaults['top_categories_8'] = 0;
    $defaults['top_categories_9'] = 0;
    $defaults['top_categories_10'] = 0;
    $defaults['show_top_categories_product_count'] = 'true';
    $defaults['show_top_categories_product_onsale_count'] = 'true';
    $defaults['select_top_categories_section_mode'] = 'list-only';

    $defaults['select_top_categories_on_hover'] = 'top-5-products';
    $defaults['select_top_categories_orderby'] = 'name';
    $defaults['select_top_categories_order'] = 'ASC';




    // Slider.
    $defaults['slider_status']                  = false;
    $defaults['button_text_1']                  = esc_html__( 'Shop Now', 'shopical' );
    $defaults['button_text_2']                  = esc_html__( 'Shop Now', 'shopical' );
    $defaults['button_text_3']                  = esc_html__( 'Shop Now', 'shopical' );
    $defaults['button_text_4']                  = esc_html__( 'Shop Now', 'shopical' );
    $defaults['button_text_5']                  = esc_html__( 'Shop Now', 'shopical' );
    $defaults['button_link_1']                  = '';
    $defaults['button_link_2']                  = '';
    $defaults['button_link_3']                  = '';
    $defaults['button_link_4']                  = '';
    $defaults['button_link_5']                  = '';
    $defaults['page_caption_position_1']             = 'left';
    $defaults['page_caption_position_2']             = 'left';
    $defaults['page_caption_position_3']             = 'left';
    $defaults['page_caption_position_4']             = 'left';
    $defaults['page_caption_position_5']             = 'left';
    $defaults['slider_autoplay_status']         = true;
    $defaults['slider_pager_status']            = true;
    $defaults['slider_transition_effect']       = 'fade';
    $defaults['slider_transition_delay']        = 3;

//    $defaults['slider_page_1']             = 2;
//    $defaults['slider_page_2']             = 2;
//    $defaults['slider_page_3']             = 2;
//    $defaults['slider_page_4']             = 2;
//    $defaults['slider_page_5']             = 2;

    $defaults['slider_product_1']             = '';
    $defaults['slider_product_2']             = '';
    $defaults['slider_product_3']             = '';
    $defaults['slider_product_4']             = '';
    $defaults['slider_product_5']             = '';

    $defaults['product_caption_position_1']             = 'left';
    $defaults['product_caption_position_2']             = 'left';
    $defaults['product_caption_position_3']             = 'left';
    $defaults['product_caption_position_4']             = 'left';
    $defaults['product_caption_position_5']             = 'left';

    // Frontpage Section.

    $defaults['show_flash_news_section'] = 1;
    $defaults['flash_news_title'] = __('Flash Story', 'shopical');
    $defaults['select_flash_news_category'] = 0;
    $defaults['number_of_flash_news'] = 5;
    $defaults['banner_flash_news_scope'] = 'front-page-only';



    $defaults['main_news_slider_title'] = __('Main Story', 'shopical');
    $defaults['select_slider_news_category'] = 0;
    $defaults['select_main_slider_section_mode'] = 'page-slider';
    $defaults['number_of_slides'] = 5;




//    $defaults['first_thumbnail_slider_1'] = 2;
//    $defaults['first_thumbnail_slider_2'] = 2;
//    $defaults['first_thumbnail_slider_3'] = 2;
    $defaults['first_thumbnail_slider_link_1'] = '';
    $defaults['first_thumbnail_slider_link_2'] = '';
    $defaults['first_thumbnail_slider_link_3'] = '';
    $defaults['first_thumbnail_slider_button_texts_1'] = 'Shop Now';
    $defaults['first_thumbnail_slider_button_texts_2'] = 'Shop Now';
    $defaults['first_thumbnail_slider_button_texts_3'] = 'Shop Now';
    $defaults['show_first_thumbnail_slider_page_title_1'] = 'true';
    $defaults['show_first_thumbnail_slider_page_title_2'] = 'true';
    $defaults['show_first_thumbnail_slider_page_title_3'] = 'true';


//    $defaults['second_thumbnail_slider_1'] = 2;
//    $defaults['second_thumbnail_slider_2'] = 2;
//    $defaults['second_thumbnail_slider_3'] = 2;
    $defaults['second_thumbnail_slider_link_1'] = '';
    $defaults['second_thumbnail_slider_link_2'] = '';
    $defaults['second_thumbnail_slider_link_3'] = '';
    $defaults['second_thumbnail_slider_button_texts_1'] = 'Shop Now';
    $defaults['second_thumbnail_slider_button_texts_2'] = 'Shop Now';
    $defaults['second_thumbnail_slider_button_texts_3'] = 'Shop Now';
    $defaults['show_second_thumbnail_slider_page_title_1'] = 'true';
    $defaults['show_second_thumbnail_slider_page_title_2'] = 'true';
    $defaults['show_second_thumbnail_slider_page_title_3'] = 'true';


    $defaults['show_main_banner_section'] = 0;
    $defaults['frontpage_main_banner_layout'] = 'main-banner-style-1';
    $defaults['show_horizontal_page_grid_section'] = 1;
    $defaults['show_horizontal_category_section'] = 1;



    $defaults['show_store_features_section'] = 1;
    $defaults['store_features_icon_1'] = 'fa fa-paper-plane';
    $defaults['store_features_icon_2'] = 'fa fa-gift';
    $defaults['store_features_icon_3'] = 'fa fa-life-ring';
    $defaults['store_features_icon_4'] = 'fa fa-repeat';
    $defaults['store_features_title_1'] = 'Free Shipping';
    $defaults['store_features_title_2'] = 'Get Discount';
    $defaults['store_features_title_3'] = '24/7 Suport';
    $defaults['store_features_title_4'] = '30 Days Returns';
    $defaults['store_features_desc_1'] = 'On all orders over $75.00';
    $defaults['store_features_desc_2'] = 'Get Coupon & Discount';
    $defaults['store_features_desc_3'] = 'We will be at your service';
    $defaults['store_features_desc_4'] = '30 days money back';


    $defaults['show_featured_categories_section'] = 0;
    $defaults['featured_categories_section_title'] = 'Featured Categories';
    $defaults['featured_categories_section_title_note'] = '';
    $defaults['featured_categories_1'] = 0;
    $defaults['featured_categories_2'] = 0;
    $defaults['featured_categories_3'] = 0;
    $defaults['featured_categories_4'] = 0;
    $defaults['featured_categories_5'] = 0;
    $defaults['featured_categories_6'] = 0;
    $defaults['show_featured_categories_product_count'] = 'true';
    $defaults['show_featured_categories_product_onsale_count'] = 'true';

    $defaults['show_offer_pages_section'] = 1;
    $defaults['show_offer_pages_section_title'] = 'Store Offers';
    $defaults['show_offer_pages_section_note'] = '';
//    $defaults['offer_page_1'] = '';
//    $defaults['offer_page_2'] = '';
//    $defaults['offer_page_3'] = '';
    $defaults['offer_pages_link_1'] = '';
    $defaults['offer_pages_link_2'] = '';
    $defaults['offer_pages_link_3'] = '';
    $defaults['offer_pages_button_texts_1'] = 'Shop Now';
    $defaults['offer_pages_button_texts_2'] = 'Shop Now';
    $defaults['offer_pages_button_texts_3'] = 'Shop Now';
    $defaults['show_offer_pages_page_title_1'] = 'true';
    $defaults['show_offer_pages_page_title_2'] = 'true';
    $defaults['show_offer_pages_page_title_3'] = 'true';


    $defaults['show_featured_product_section'] = 0;
    $defaults['featured_product_section_title'] = 'Featured Products';
    $defaults['featured_product_section_title_note'] = '';
    $defaults['featured_product_categories'] = 0;
    $defaults['number_of_featured_product'] = 6;


    $defaults['show_onsale_product_section'] = 0;
    $defaults['onsale_product_section_title'] = 'On-sale Products';
    $defaults['onsale_product_section_title_note'] = 'Offer';
    $defaults['onsale_product_categories'] = 0;
    $defaults['number_of_onsale_product'] = 6;





    $defaults['frontpage_content_alignment'] = 'align-content-left';

    //layout options
    $defaults['global_content_layout'] = 'default-content-layout';
    $defaults['global_content_alignment'] = 'align-content-left';
    $defaults['global_image_alignment'] = 'full-width-image';
    $defaults['global_post_date_author_setting'] = 'show-date-author';
    $defaults['global_excerpt_length'] = 20;
    $defaults['global_read_more_texts'] = __('Read more', 'shopical');

    $defaults['archive_layout'] = 'archive-layout-grid';
    $defaults['archive_image_alignment'] = 'archive-image-left';
    $defaults['archive_content_view'] = 'archive-content-excerpt';
    $defaults['disable_main_banner_on_blog_archive'] = 0;


    //Related posts
    $defaults['single_show_related_posts'] = 1;
    $defaults['single_related_posts_title']     = __( 'More Stories', 'shopical' );
    $defaults['single_number_of_related_posts']  = 6;

    //Related posts
    $defaults['store_contact_name'] = '';
    $defaults['store_contact_address'] = '107-95 West Brooklyn, USA';
    $defaults['store_contact_phone']     = '+1 212-0123456789';
    $defaults['store_contact_email']  = 'contact@shopemail.com';
    $defaults['store_contact_hours']  = '10am-8pm';
    $defaults['store_contact_website']  = '';
    $defaults['store_contact_other_informations']  = '';
    $defaults['store_contact_form']  = '';
    $defaults['store_contact_map']  = '';
    $defaults['store_contact_page']  = '';

    //Secure Payment Options
    $defaults['secure_payment_badge'] = '';
    $defaults['secure_payment_badge_url'] = '';
    $defaults['secure_payment_badge_open_in_new_tab'] = 1;

    //Pagination.
    $defaults['site_pagination_type'] = 'default';

    //Mailchimp
    $defaults['footer_show_mailchimp_subscriptions'] = 1;
    $defaults['footer_mailchimp_subscriptions_scopes'] = 'front-page';
    $defaults['footer_mailchimp_title']     = __( 'Subscribe To  Our Newsletter', 'shopical' );
    $defaults['footer_mailchimp_subtitle']     = __( 'Magna aspernatur eget potenti molestias beatae!', 'shopical' );
    $defaults['footer_mailchimp_shortcode']  = '';
    $defaults['footer_mailchimp_background_color']  = '#1f2125';
    $defaults['footer_mailchimp_field_border_color']  = '#4d5b73';


    // Footer.
    // Latest posts
    $defaults['frontpage_show_latest_posts'] = 1;
    $defaults['frontpage_latest_posts_section_title'] = __('You may missed', 'shopical');
    $defaults['frontpage_latest_posts_category'] = 0;
    $defaults['number_of_frontpage_latest_posts'] = 4;

    //Instagram
    $defaults['footer_show_instagram_post_carousel'] = 1;
    $defaults['footer_instagram_post_carousel_scopes'] = 'front-page';
    $defaults['instagram_username'] = 'wpafthemes';
    $defaults['instagram_access_token'] = '7510889272.577c420.c6d613a1e7d24499ae6432d8e2e6fe9f';
    $defaults['number_of_instagram_posts'] = 10;

    $defaults['footer_scroll_to_top_position'] = 'right-side';
    $defaults['footer_scroll_to_top_icon'] = 'fa fa-angle-up';



    $defaults['footer_copyright_text'] = esc_html__('Copyright &copy; All rights reserved.', 'shopical');
    $defaults['hide_footer_menu_section']  = 0;
    $defaults['hide_footer_site_title_section']  = 0;
    $defaults['hide_footer_copyright_credits']  = 0;
    $defaults['number_of_footer_widget']  = 3;
    $defaults['primary_footer_background_color']  = '#1f2125';
    $defaults['primary_footer_texts_color']  = '#ffffff';
    $defaults['secondary_footer_background_color']  = '#404040';
    $defaults['secondary_footer_texts_color']  = '#ffffff';
    $defaults['footer_credits_background_color']  = '#000000';
    $defaults['footer_credits_texts_color']  = '#ffffff';



    // font and color options

    $defaults['primary_color']     = '#404040';
    $defaults['secondary_title_color']     = '#404040';
    $defaults['secondary_color']     = '#cc0000';
    $defaults['secondary_background_color']     = '#ffffff';
    $defaults['tertiary_background_color']     = '#e6e6e6';
    $defaults['link_color']     = '#404040';
    $defaults['primary_title_color']     = '#000000';
    $defaults['secondary_title_color']     = '#404040';
    $defaults['tertiary_title_color']     = '#ffffff';
    $defaults['primary_border_color']     = '#ffffff';
    $defaults['secondary_border_color']     = '#ebebeb';

    $defaults['main_navigation_background_color']     = '#af0000';
    $defaults['main_navigation_link_color']     = '#ffffff';
    $defaults['menu_badge_background']     = '#ffc107';
    $defaults['menu_badge_color']     = '#23282d';
    $defaults['global_badge_background']     = '#ffc107';
    $defaults['global_badge_color']     = '#23282d';
    $defaults['title_link_color']     = '#404040';
    $defaults['title_over_image_color']     = '#ffffff';

    $defaults['main_header_background_color']     = '#23282d';



    //font option




//font options additional value
    global $shopical_google_fonts;
    $shopical_google_fonts = array(
        'ABeeZee:400,400italic'                     => 'ABeeZee',
        'Abel'                                      => 'Abel',
        'Abril+Fatface'                             => 'Abril Fatface',
        'Aldrich'                                   => 'Aldrich',
        'Alegreya:400,400italic,700,900'            => 'Alegreya',
        'Alex+Brush'                                => 'Alex Brush',
        'Alfa+Slab+One'                             => 'Alfa Slab One',
        'Amaranth:400,400italic,700'                => 'Amaranth',
        'Andada'                                    => 'Andada',
        'Anton'                                     => 'Anton',
        'Archivo+Black'                             => 'Archivo Black',
        'Archivo+Narrow:400,400italic,700'          => 'Archivo Narrow',
        'Arimo:400,400italic,700'                   => 'Arimo',
        'Arvo:400,400italic,700'                    => 'Arvo',
        'Asap:400,400italic,700'                    => 'Asap',
        'Bangers'                                   => 'Bangers',
        'BenchNine:400,700'                         => 'BenchNine',
        'Bevan'                                     => 'Bevan',
        'Bitter:400,400italic,700'                  => 'Bitter',
        'Bree+Serif'                                => 'Bree Serif',
        'Cabin:400,400italic,500,600,700'           => 'Cabin',
        'Cabin+Condensed:400,500,600,700'           => 'Cabin Condensed',
        'Cantarell:400,400italic,700'               => 'Cantarell',
        'Carme'                                     => 'Carme',
        'Cherry+Cream+Soda'                         => 'Cherry Cream Soda',
        'Cinzel:400,700,900'                        => 'Cinzel',
        'Comfortaa:400,300,700'                     => 'Comfortaa',
        'Cookie'                                    => 'Cookie',
        'Covered+By+Your+Grace'                     => 'Covered By Your Grace',
        'Crete+Round:400,400italic'                 => 'Crete Round',
        'Crimson+Text:400,400italic,600,700'        => 'Crimson Text',
        'Cuprum:400,400italic'                      => 'Cuprum',
        'Dancing+Script:400,700'                    => 'Dancing Script',
        'Didact+Gothic'                             => 'Didact Gothic',
        'Droid+Sans:400,700'                        => 'Droid Sans',
        'Dosis:400,300,600,800'                     => 'Dosis',
        'Droid+Serif:400,400italic,700'             => 'Droid Serif',
        'Economica:400,700,400italic'               => 'Economica',
        'Expletus+Sans:400,400i,700,700i'           => 'Expletus Sans',
        'EB+Garamond'                               => 'EB Garamond',
        'Exo:400,300,400italic,600,800'             => 'Exo',
        'Exo+2:400,300,400italic,600,700,900'       => 'Exo 2',
        'Fira+Sans:400,500'                         => 'Fira Sans',
        'Fjalla+One'                                => 'Fjalla One',
        'Francois+One'                              => 'Francois One',
        'Fredericka+the+Great'                      => 'Fredericka the Great',
        'Fredoka+One'                               => 'Fredoka One',
        'Fugaz+One'                                 => 'Fugaz One',
        'Great+Vibes'                               => 'Great Vibes',
        'Handlee'                                   => 'Handlee',
        'Hammersmith+One'                           => 'Hammersmith One',
        'Hind:400,300,600,700'                      => 'Hind',
        'Inconsolata:400,700'                       => 'Inconsolata',
        'Indie+Flower'                              => 'Indie Flower',
        'Istok+Web:400,400italic,700'               => 'Istok Web',
        'Josefin+Sans:400,600,700,400italic'        => 'Josefin Sans',
        'Josefin+Slab:400,400italic,700,600'        => 'Josefin Slab',
        'Jura:400,300,500,600'                      => 'Jura',
        'Karla:400,400italic,700'                   => 'Karla',
        'Kaushan+Script'                            => 'Kaushan Script',
        'Kreon:400,300,700'                         => 'Kreon',
        'Lateef'                                    => 'Lateef',
        'Lato:400,300,400italic,900,700'            => 'Lato',
        'Libre+Baskerville:400,400italic,700'       => 'Libre Baskerville',
        'Limelight'                                 => 'Limelight',
        'Lobster'                                   => 'Lobster',
        'Lobster+Two:400,700,700italic'             => 'Lobster Two',
        'Lora:400,400italic,700,700italic'          => 'Lora',
        'Maven+Pro:400,500,700,900'                 => 'Maven Pro',
        'Merriweather:400,400italic,300,900,700'    => 'Merriweather',
        'Merriweather+Sans:400,400italic,700,800'   => 'Merriweather Sans',
        'Monda:400,700'                             => 'Monda',
        'Montserrat:400,700'                        => 'Montserrat',
        'Muli:400,300italic,300'                    => 'Muli',
        'News+Cycle:400,700'                        => 'News Cycle',
        'Noticia+Text:400,400italic,700'            => 'Noticia Text',
        'Noto+Sans:400,400italic,700'               => 'Noto Sans',
        'Noto+Serif:400,400italic,700'              => 'Noto Serif',
        'Nunito:400,300,700'                        => 'Nunito',
        'Old+Standard+TT:400,400italic,700'         => 'Old Standard TT',
        'Open+Sans:400,400italic,600,700'           => 'Open Sans',
        'Open+Sans+Condensed:300,300italic,700'     => 'Open Sans Condensed',
        'Oswald:300,400,700'                        => 'Oswald',
        'Oxygen:400,300,700'                        => 'Oxygen',
        'Pacifico'                                  => 'Pacifico',
        'Passion+One:400,700,900'                   => 'Passion One',
        'Pathway+Gothic+One'                        => 'Pathway Gothic One',
        'Patua+One'                                 => 'Patua One',
        'Poiret+One'                                => 'Poiret One',
        'Pontano+Sans'                              => 'Pontano Sans',
        'Poppins:300,400,500,600,700'               => 'Poppins',
        'Play:400,700'                              => 'Play',
        'Playball'                                  => 'Playball',
        'Playfair+Display:400,400italic,700,900'    => 'Playfair Display',
        'PT+Sans:400,400italic,700'                 => 'PT Sans',
        'PT+Sans+Caption:400,700'                   => 'PT Sans Caption',
        'PT+Sans+Narrow:400,700'                    => 'PT Sans Narrow',
        'PT+Serif:400,400italic,700'                => 'PT Serif',
        'Quattrocento+Sans:400,700,400italic'       => 'Quattrocento Sans',
        'Questrial'                                 => 'Questrial',
        'Quicksand:400,700'                         => 'Quicksand',
        'Raleway:400,300,500,600,700,900'           => 'Raleway',
        'Righteous'                                 => 'Righteous',
        'Roboto:100,300,400,500,700'                => 'Roboto',
        'Roboto+Condensed:400,300,400italic,700'    => 'Roboto Condensed',
        'Roboto+Slab:400,300,700'                   => 'Roboto Slab',
        'Rokkitt:400,700'                           => 'Rokkitt',
        'Ropa+Sans:400,400italic'                   => 'Ropa Sans',
        'Russo+One'                                 => 'Russo One',
        'Sanchez:400,400italic'                     => 'Sanchez',
        'Satisfy'                                   => 'Satisfy',
        'Shadows+Into+Light'                        => 'Shadows Into Light',
        'Sigmar+One'                                => 'Sigmar One',
        'Signika:400,300,700'                       => 'Signika',
        'Six+Caps'                                  => 'Six Caps',
        'Slabo+27px'                                => 'Slabo 27px',
        'Source+Sans+Pro:400,400i,700,700i' => 'Source Sans Pro',
        'Source+Serif+Pro:400,700'                  => 'Source Serif Pro',
        'Squada+One'                                => 'Squada One',
        'Tangerine:400,700'                         => 'Tangerine',
        'Tinos:400,400italic,700'                   => 'Tinos',
        'Titillium+Web:400,300,400italic,700,900'   => 'Titillium Web',
        'Ubuntu:400,400italic,500,700'              => 'Ubuntu',
        'Ubuntu+Condensed'                          => 'Ubuntu Condensed',
        'Varela+Round'                              => 'Varela Round',
        'Vollkorn:400,400italic,700'                => 'Vollkorn',
        'Voltaire'                                  => 'Voltaire',
        'Yanone+Kaffeesatz:400,300,700'             => 'Yanone Kaffeesatz',
    );

    //font option
    $defaults['primary_font']      = 'Source+Sans+Pro:400,400i,700,700i';
    $defaults['secondary_font']    = 'Montserrat:400,700';
    $defaults['post_format_color']    = '#ffffff';

    //font size
    $defaults['site_title_font_size']    = 36;
    $defaults['letter_spacing']    = 0;
    $defaults['line_height']    = 1.3;
    $defaults['font_weight']    = 700;
    $defaults['main_banner_silder_caption_font_size']    = 48;

    $defaults['shopical_primary_title_font_size']    = 20;
    $defaults['shopical_secondary_title_font_size']    = 18;
    $defaults['shopical_tertiary_title_font_size']    = 16;
    $defaults['content_widget_article_title_font_size']    = 18;

    //woocommerce
    $defaults['store_global_alignment']    = 'align-content-left';
    $defaults['store_enable_breadcrumbs']    = 'yes';
    $defaults['store_single_sale_text']    = 'Sale!';
    $defaults['store_single_add_to_cart_text']    = 'Add to cart';
    $defaults['store_simple_add_to_cart_text']    = 'Add to cart';
    $defaults['store_variable_add_to_cart_text']    = 'Select options';
    $defaults['store_grouped_add_to_cart_text']    = 'View options';
    $defaults['store_external_add_to_cart_text']    = 'Read More';

    $defaults['store_product_search_autocomplete']    = 'yes';
    $defaults['store_product_search_placeholder']    = 'Search Products...';
    $defaults['store_product_search_category_placeholder']    = 'Select Category';
    $defaults['store_product_search_show_popular_tags']    = 'yes';

    $defaults['store_product_search_color']    = 'secondary-background-color';
    $defaults['store_product_search_custom_background_color']    = '#ffffff';
    $defaults['store_product_search_custom_text_color']    = '#404040';
    $defaults['store_product_search_custom_border_color']    = '#d9d9d9';

    $defaults['aft_enable_minicart']    = 1;
    $defaults['aft_product_minicart_counter']    = 'yes';
    $defaults['aft_product_minicart_total']    = 'yes';
    $defaults['aft_product_minicart_contents']    = 'yes';
    $defaults['aft_language_switcher_shortcode']    = '';
    $defaults['aft_currency_switcher_shortcode']    = '';


    $defaults['aft_product_loop_button_display']    = 'show-on-hover';
    $defaults['aft_product_loop_category']    = 'yes';
    $defaults['aft_product_loop_color']    = 'secondary-color';
    $defaults['aft_product_loop_custom_color']    = '#cc0000';
    $defaults['store_product_shop_page_row']    = '5';
    $defaults['store_product_shop_page_product_per_page']    = '15';
    $defaults['store_product_shop_page_product_sort']    = 'yes';

    $defaults['store_product_page_product_zoom']    = 'yes';
    $defaults['store_product_page_gallery_thumbnail_columns']    = '4';
    $defaults['store_product_page_related_products']    = 'yes';
    $defaults['store_product_page_related_products_per_row']    = '5';
    $defaults['store_product_page_related_products_per_page']    = '5';
    $defaults['store_product_page_review_tab']    = 'yes';



    // Pass through filter.
    $defaults = apply_filters('shopical_filter_default_theme_options', $defaults);

	return $defaults;

}

endif;
