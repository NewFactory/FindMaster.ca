<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}


/**
 * Customizer
 *
 * @class   shopical
 */

if (!function_exists('shopical_custom_style')) {

    function shopical_custom_style()
    {
        $shopical_background_color = get_background_color();
        $shopical_background_color = '#' . $shopical_background_color;
        $shopical_preloader_background = shopical_get_option('site_preloader_background');
        $shopical_preloader_spinner_color = shopical_get_option('site_preloader_spinner_color');

        $top_header_background = shopical_get_option('top_header_background_color');
        $top_text_color = shopical_get_option('top_header_text_color');

        $shopical_main_header_background_color = shopical_get_option('main_header_background_color');


        global $shopical_google_fonts;
        $shopical_primary_color = shopical_get_option('primary_color');
        $shopical_secondary_color = shopical_get_option('secondary_color');

        $shopical_primary_border_color = shopical_get_option('primary_border_color');
        $shopical_secondary_border_color = shopical_get_option('secondary_border_color');

        $shopical_global_badge_background = shopical_get_option('global_badge_background');
        $shopical_global_badge_color = shopical_get_option('global_badge_color');

        $secondary_background_color = shopical_get_option('secondary_background_color');
        $tertiary_background_color = shopical_get_option('tertiary_background_color');

        $shopical_primary_title_color = shopical_get_option('primary_title_color');
        $shopical_secondary_title_color = shopical_get_option('secondary_title_color');
        $shopical_tertiary_title_color = shopical_get_option('tertiary_title_color');

        $link_color = shopical_get_option('link_color');

        $shopical_product_loop_color = shopical_get_option('aft_product_loop_color');
        $shopical_store_product_search_color = shopical_get_option('store_product_search_color');


        $shopical_primary_footer_background_color = shopical_get_option('primary_footer_background_color');
        $shopical_primary_footer_texts_color = shopical_get_option('primary_footer_texts_color');
        $shopical_secondary_footer_background_color = shopical_get_option('secondary_footer_background_color');
        $shopical_secondary_footer_texts_color = shopical_get_option('secondary_footer_texts_color');
        $shopical_footer_credits_background_color = shopical_get_option('footer_credits_background_color');
        $shopical_footer_credits_texts_color = shopical_get_option('footer_credits_texts_color');

        $shopical_mainbanner_silder_caption_font_size = shopical_get_option('main_banner_silder_caption_font_size');
        $shopical_primary_title_font_size = shopical_get_option('shopical_primary_title_font_size');
        $shopical_secondary_title_font_size = shopical_get_option('shopical_secondary_title_font_size');
        $shopical_tertiary_title_font_size = shopical_get_option('shopical_tertiary_title_font_size');


        $shopical_mailchimp_background_color = shopical_get_option('footer_mailchimp_background_color');
        $shopical_mailchimp_filed_border_color = shopical_get_option('footer_mailchimp_field_border_color');

        $main_navigation_background_color = shopical_get_option('main_navigation_background_color');
        $main_navigation_link_color = shopical_get_option('main_navigation_link_color');
        $menu_badge_background = shopical_get_option('menu_badge_background');
        $menu_badge_color = shopical_get_option('menu_badge_color');

        $shopical_title_color = shopical_get_option('title_link_color');
        $shopical_title_over_image_color = shopical_get_option('title_over_image_color');


        $shopical_primary_font = $shopical_google_fonts[shopical_get_option('primary_font')];
        $shopical_secondary_font = $shopical_google_fonts[shopical_get_option('secondary_font')];
        $shopical_letter_spacing = shopical_get_option('letter_spacing');
        $shopical_line_height = shopical_get_option('line_height');
        $shopical_font_weight = shopical_get_option('font_weight');

        ob_start();
        ?>

    <?php if (!empty($shopical_background_color)): ?>
        #sidr,    
        .category-dropdown li.aft-category-list > ul
        {
        background-color: <?php echo $shopical_background_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_primary_border_color)): ?>

        .right-list-section .category-dropdown  > ul > li,
        .widget-title, .section-title
        {
        border-color: <?php echo $shopical_primary_border_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_secondary_border_color)): ?>
        .main-navigation ul.children  li,
        .main-navigation ul .sub-menu li,    
        input[type="text"], input[type="email"],
        input[type="url"], input[type="password"],
        input[type="search"], input[type="number"],
        input[type="tel"], input[type="range"],
        input[type="date"], input[type="month"],
        input[type="week"], input[type="time"],
        input[type="datetime"], input[type="datetime-local"],
        input[type="color"], textarea,select,
        #add_payment_method table.cart td.actions .coupon .input-text,
        .woocommerce-cart table.cart td.actions .coupon .input-text,
        .woocommerce-checkout table.cart td.actions .coupon .input-text,
        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single,
        #wp-calendar tbody td,
        .style-3-search button[type="submit"],
        .woocommerce form.checkout_coupon,
        li.woocommerce-MyAccount-navigation-link,
        .woocommerce form.login,
        .woocommerce form.register,
        .woocommerce table.shop_table,
        .woocommerce table.shop_table tbody th,
        .woocommerce table.shop_table tfoot td,
        .woocommerce table.shop_table tfoot th,
        #add_payment_method #payment ul.payment_methods,
        .woocommerce-cart #payment ul.payment_methods,
        .woocommerce-checkout #payment ul.payment_methods,
        #add_payment_method .cart-collaterals .cart_totals tr td,
        #add_payment_method .cart-collaterals .cart_totals tr th,
        .woocommerce-cart .cart-collaterals .cart_totals tr td,
        .woocommerce-cart .cart-collaterals .cart_totals tr th,
        .woocommerce-checkout .cart-collaterals .cart_totals tr td,
        .woocommerce-checkout .cart-collaterals .cart_totals tr th,
        .woocommerce table.wishlist_table thead th,
        .woocommerce table.wishlist_table tbody td,
        .woocommerce table.shop_table td,
        .categories-mega-list-wrapper > span,
        .show-nested-subcategories.category-dropdown  li.aft-category-list li,
        .product_store_faq_widget .ui-accordion .ui-accordion-header,
        .product_store_faq_widget .ui-accordion .ui-accordion-content[aria-hidden="false"],
        .product_store_faq_widget .ui-accordion .ui-accordion-header[aria-expanded="true"]
        {
        border-color: <?php echo $shopical_secondary_border_color; ?> !important;
        }

        .singlewrap:after{
            background-color: <?php echo $shopical_secondary_border_color; ?>;
        }
        @media screen and (max-width: 991px){
            .support-wrap .singlewrap:nth-child(2), 
            .support-wrap .singlewrap:nth-child(1) {
                border-color: <?php echo $shopical_secondary_border_color; ?>;
            }
        }
        @media screen and (max-width: 480px){
            .support-wrap .singlewrap{
                border-color: <?php echo $shopical_secondary_border_color; ?>;
            }
        }

    <?php endif; ?>

        <?php if (!empty($top_header_background)): ?>

        body .top-header {
        background-color: <?php echo $top_header_background; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($shopical_main_header_background_color)): ?>

        body .desktop-header {
        background-color: <?php echo $shopical_main_header_background_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_preloader_background)): ?>

        body #af-preloader

        {
        background-color: <?php echo $shopical_preloader_background; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_preloader_spinner_color)): ?>
        body .af-spinners .af-spinner

        {
        background-color: <?php echo $shopical_preloader_spinner_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($top_text_color)): ?>

        body .top-header,
        body .top-header a,
        body .top-header a:hover,
        body .top-header a:active,
        body .top-header a:visited

        {
        color: <?php echo $top_text_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($link_color)): ?>

        a:visited,
        a{
        color: <?php echo $link_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_primary_color)): ?>
        body .data-bg,
        body .primary-color
        {
        background-color: <?php echo $shopical_primary_color; ?>;
        }

        body,.woocommerce-store-notice, p.demo_store,
        .woocommerce .category-badge-wrapper span.onsale,
        .category-badge-wrapper span.onsale,
        .woocommerce nav.woocommerce-pagination ul li a:focus,
        .woocommerce nav.woocommerce-pagination ul li a:hover,
        .woocommerce nav.woocommerce-pagination ul li span.current,
        body .title-role,
        p.stars:hover a:before,
        body .section-subtitle,
        body .woocommerce-info,
        body .woocommerce-error,
        body .woocommerce-message,
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:before,
        body .testi-details span.expert,
        p.stars.selected a.active:before,
        p.stars.selected a:not(.active):before,
        body .style-3-search .search-field::placeholder,
        .input-text::placeholder,
        input[type="text"]::placeholder,
        input[type="email"]::placeholder,
        input[type="url"]::placeholder,
        input[type="password"]::placeholder,
        input[type="search"]::placeholder,
        input[type="number"]::placeholder,
        input[type="tel"]::placeholder,
        input[type="range"]::placeholder,
        input[type="date"]::placeholder,
        input[type="month"]::placeholder,
        input[type="week"]::placeholder,
        input[type="time"]::placeholder,
        input[type="datetime"]::placeholder,
        input[type="datetime-local"]::placeholder,
        input[type="color"]::placeholder,
        textarea::placeholder,
        input[type="text"]:focus,
        input[type="email"]:focus,
        input[type="url"]:focus,
        input[type="password"]:focus,
        input[type="search"]:focus,
        input[type="number"]:focus,
        input[type="tel"]:focus,
        input[type="range"]:focus,
        input[type="date"]:focus,
        input[type="month"]:focus,
        input[type="week"]:focus,
        input[type="time"]:focus,
        input[type="datetime"]:focus,
        input[type="datetime-local"]:focus,
        input[type="color"]:focus,
        textarea:focus,
        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        input[type="tel"],
        input[type="range"],
        input[type="date"],
        input[type="month"],
        input[type="week"],
        input[type="time"],
        input[type="datetime"],
        input[type="datetime-local"],
        input[type="color"],
        textarea,
        ul.product-item-meta li:hover a.added_to_cart,
        #add_payment_method #payment div.payment_box,
        .woocommerce-cart #payment div.payment_box,
        .woocommerce-checkout #payment div.payment_box,
        .woocommerce nav.woocommerce-breadcrumb, nav.woocommerce-breadcrumb,
        span#select2-billing_country-container,
        ul.product-item-meta li a,
        .testimonial-slider .owl-nav button span,.owl-nav button span,
        .support-content p,
        .header-right-part .cart-shop span,
        .header-right-part .cart-shop .widget_shopping_cart_content,
        .woocommerce .widget_shopping_cart .total strong,
        .woocommerce.widget_shopping_cart .total strong,
        #wp-calendar caption,
        .widget_product_categories ul li,
        div.sharedaddy .sd-content ul li[class*='share-'] a.share-icon.no-text,
        div.sharedaddy h3.sd-title,
        footer .blog-content,
        .nav-tabs>li>a,
        #secondary .nav-tabs>li.active>a.font-family-1, 
        .site-footer .nav-tabs>li.active>a.font-family-1, 
        .nav-tabs>li.active>a.font-family-1, .nav-tabs>li.active>a,
        #sidr .aft-carousel .owl-nav button span, 
        #secondary .aft-carousel .owl-nav button span, 
        footer .aft-carousel .owl-nav button span,
        .insta-carousel .owl-nav button span, 
        .main-banner-slider .owl-nav button span,
        .aft-slider .owl-nav button span,
        .store-contact .contact-details-wrapper h5, 
        .store-faq .contact-details-wrapper h5,
        .woocommerce-info, .woocommerce-noreviews, p.no-comments,
        body .woocommerce-product-details__short-description p
        {
        color: <?php echo $shopical_primary_color; ?>;
        }

        .prime-color li a,
        #primary-menu ul.children li a,
        #primary-menu ul.sub-menu li a,
        .main-navigation ul.children li a,
        .main-navigation ul .sub-menu li a{
        color: <?php echo $shopical_primary_color; ?> !important;
        }

        body .owl-theme .owl-dots .owl-dot span{
        background: <?php echo $shopical_primary_color; ?>;
        opacity: 0.5;
        }

        body .owl-theme .owl-dots .owl-dot span:hover{
        background: <?php echo $shopical_primary_color; ?>;
        opacity: 0.75;
        }

        body .owl-theme .owl-dots .owl-dot.active span{
        background: <?php echo $shopical_primary_color; ?>;
        opacity: 1;
        }

        body .cat-links a,
        body .cat-links a:active,
        body .cat-links a:visited,
        body .cat-links li a,
        body .cat-links li a:active,
        body .cat-links li a:visited,
        body .entry-meta > span:after,
        body .cat-links li:after,
        body span.tagged_as a,
        body span.tagged_as a:active,
        body span.tagged_as a:visited,
        body span.posted_in a,
        body span.posted_in a:active,
        body span.posted_in a:visited,
        .section-head span.aft-view-all a,
        .entry-footer span.cat-links a, .entry-footer span.tags-links a,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a,
        .woocommerce .woocommerce-breadcrumb a, .woocommerce-breadcrumb a,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:active,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:visited
        {
        color: <?php echo $shopical_primary_color; ?>;
        opacity: 0.75;
        }

        select,
        .woocommerce .quantity .qty,
        .blog-content span p,
        .insta-feed-head a .instagram-username,
        body .cat-links a:hover,
        body .cat-links li a:hover,
        body span.tagged_as a:hover,
        body span.posted_in a:hover,
        .nav-tabs>li>a:hover,
        span.price ins,
        ins,
        body.woocommerce div.product .woocommerce-tabs ul.tabs li a:hover
        {
        color: <?php echo $shopical_primary_color; ?>;
        opacity: 1;
        }

        .woocommerce div.product .woocommerce-tabs ul.tabs li.active{
        border-color: <?php echo $shopical_primary_color; ?>;
        }

        @media screen and (max-width: 768px){
            .aft-carousel .owl-nav button span{
                color: <?php echo $shopical_primary_color; ?>;
            }
        }

    <?php endif; ?>

        <?php if (!empty($shopical_secondary_color)): ?>

        body .secondary-color,
        .right-list-section h3,
        .horizontal ul.product-item-meta li a:hover,
        .aft-notification-button a,
        .aft-notification-button a:hover,
        .product-wrapper ul.product-item-meta.verticle .yith-btn .yith-wcwl-wishlistexistsbrowse.show a:before,
        .woocommerce table.shop_table.cart.wishlist_table a.button:hover,
        .woocommerce table.shop_table.cart.wishlist_table a.button,
        body button,
        body input[type="button"],
        body input[type="reset"],
        body input[type="submit"],
        body .site-content .search-form .search-submit,
        body .site-footer .search-form .search-submit,
        body span.header-after:after,
        body #secondary .widget-title span:after,
        body .exclusive-posts .exclusive-now,
        body span.trending-no,
        body .wpcf7-form .wpcf7-submit,
        body #scroll-up,
        body .sale-background.no-image,
        body .shopical-post-format,
        body span.offer-time.btn-style1 a:hover,
        body .content-caption .aft-add-to-wishlist.btn-style1 a:hover,
        body ul.product-item-meta li:hover,
        .woocommerce #respond input#submit:hover,
        table.compare-list .add-to-cart td a,
        .woocommerce .widget_shopping_cart_content a.button.wc-forward,
        .woocommerce .widget_shopping_cart_content a.button.checkout,
        .yith-woocompare-widget a.compare:hover,
        .woocommerce .widget_price_filter .ui-slider .ui-slider-range,
        .style-3-search button[type="submit"]:hover,
        .woocommerce button[type="submit"]:hover,
        .woocommerce button.button,
        .woocommerce button.button.alt,
        .woocommerce a.button.alt,
        .woocommerce a.button.alt:hover,
        .woocommerce button.button:disabled:hover,
        .woocommerce button.button:disabled,
        .woocommerce button.button:disabled[disabled]:hover,
        .woocommerce button.button:disabled[disabled],
        .woocommerce button.button,
        .woocommerce button.button:hover,
        .inner-suscribe input[type=submit]:hover,
        .woocommerce-page .woocommerce-message a.button,
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:hover:before,
        ul.product-item-meta li a.added_to_cart:hover,
        .btn-style1 a,
        .btn-style1 a:visited,
        .woocommerce .btn-style1 a.button,
        .btn-style1 a:focus,
        .inner-suscribe input[type=submit],
        .woocommerce .yith-woocompare-widget a.compare.button:hover,
        .yith-woocompare-widget a.compare.button:hover,
        .woocommerce .yith-woocompare-widget a.compare.button,
        .yith-woocompare-widget a.compare.button,
        body.woocommerce button.button.alt.disabled:hover,
        body.woocommerce button.button.alt.disabled,
        body.woocommerce #respond input#submit.alt:hover,
        body.woocommerce a.button.alt:hover,
        body.woocommerce button.button.alt:hover,
        body.woocommerce input.button.alt:hover,
        body.woocommerce #respond input#submit.alt,
        body.woocommerce a.button.alt,
        body.woocommerce button.button:hover,
        body.woocommerce button.button,
        body.woocommerce button.button.alt,
        body.woocommerce input.button.alt,
        body.woocommerce #respond input#submit,
        body.woocommerce button.button,
        body.woocommerce input.button,
        body.woocommerce .widget_shopping_cart_content a.button.wc-forward,
        body.woocommerce .widget_shopping_cart_content a.button.checkout,
        body .comment-form .submit,
        span.icon-box-circle,
        .header-style-3-1 .header-right-part, .header-style-3 .header-right-part,
        body input.search-submit
        {
        background: <?php echo $shopical_secondary_color; ?>;
        border-color: <?php echo $shopical_secondary_color; ?>;
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected], .select2-container--default .select2-results__option--highlighted[data-selected]{
            background: <?php echo $shopical_secondary_color; ?> !important;
        }


        body .product-wrapper ul.product-item-meta.verticle .yith-btn .yith-wcwl-wishlistexistsbrowse.show a:before{
        color: #fff;
        background: <?php echo $shopical_secondary_color; ?>;
        border-color: <?php echo $shopical_secondary_color; ?>;
        }

        
        #sidr .widget > ul > li a:hover, #secondary .widget > ul > li a:hover,
        p.woocommerce-store-notice.demo_store a.woocommerce-store-notice__dismiss-link,
        .woocommerce a.woocommerce-Button.button,
        .woocommerce a.woocommerce-button.button,
        a.sidr-class-sidr-button-close,
        a.shipping-calculator-button,
        body a:hover,
        body a:focus,
        span.read-more-faq a,
        #wp-calendar tbody td#today,
        body a:active
        {
        color: <?php echo $shopical_secondary_color; ?>;
        }


        body #loader:after {

        border-left-color: <?php echo $shopical_secondary_color; ?>;

        }

        span.aft-thumbnail-wrapper.data-bg.data-bg-hover.active{
        border: 2px solid <?php echo $shopical_secondary_color; ?>;
        }

        @media screen and (max-width: 991px){
            div[class*=header-style-] .header-right-part,
            .header-style-3-1.header-style-compress .header-right-part{
                background: <?php echo $shopical_secondary_color; ?>;
            }

        }

    <?php endif; ?>


        <?php if ($shopical_product_loop_color == 'custom-color') {
        $shopical_product_loop_color = shopical_get_option('aft_product_loop_custom_color');
    } elseif ($shopical_product_loop_color == 'primary-color') {
        $shopical_product_loop_color = $shopical_primary_color;
    } else {
        $shopical_product_loop_color = $shopical_secondary_color;

    }

        ?>
        <?php if (!empty($shopical_product_loop_color)): ?>

        body.single-product .yith-wcwl-wishlistexistsbrowse a:before,
        body.single-product .yith-wcwl-wishlistaddedbrowse a:before,    
        .content-caption .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li .yith-wcwl-wishlistexistsbrowse.show a,
        .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li .yith-wcwl-wishlistexistsbrowse.show a,
        .content-caption .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li .yith-wcwl-wishlistaddedbrowse.show a,
        .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li
        .yith-wcwl-wishlistaddedbrowse.show a,
        .content-caption .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li a,
        .woocommerce ul.products li.product .price del,
        .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li a,
        body footer.site-footer ul.product-item-meta-always-visible li a:visited,
        body footer.site-footer ul.product-item-meta-always-visible li a,
        body ul.product-item-meta-always-visible li a:visited,
        body ul.product-item-meta-always-visible li a,
        .woocommerce ul.products li.product ul.product-item-meta-always-visible li a.button,
        .woocommerce ul.product-item-meta-always-visible li a.button,    
        .product-wrapper .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse.show a,
        .product-wrapper .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse.show a,    
        .default-add-to-cart-button a,
        .add-to-cart-button a.added_to_cart:before,
        .woocommerce ul.products li.product .price,
        .woocommerce .default-add-to-cart-button a.button,
        .woocommerce div.product p.price, .woocommerce div.product span.price,
        span.price,.price del
        {
        color: <?php echo $shopical_product_loop_color; ?>;
        }
    <?php endif; ?>


        <?php if (!empty($tertiary_background_color)): ?>

        .tertiary-background-color,
        .right-list-section .tertiary-background-color,
        .aft-tertiary-background-color,
        p.demo_store,
        .woocommerce-store-notice,
        #add_payment_method #payment,
        .woocommerce-cart #payment,
        .woocommerce-checkout #payment,
        .shopical_video_slider_widget,
        .right-list-section .category-dropdown,
        .store-contact .contact-details-wrapper h5,
        .store-faq .contact-details-wrapper h5,
        .shopical_store_brands_widget,
        .product_store_faq_widget{

        background-color: <?php echo $tertiary_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($secondary_background_color)): ?>

        input[type="text"],
        input[type="email"],
        input[type="url"],
        input[type="password"],
        input[type="search"],
        input[type="number"],
        input[type="tel"],
        input[type="range"],
        input[type="date"],
        input[type="month"],
        input[type="week"],
        input[type="time"],
        input[type="datetime"],
        input[type="datetime-local"],
        input[type="color"],
        textarea,    
        .select2-container--default .select2-selection--multiple,
        .select2-container--default .select2-selection--single,
        .woocommerce table.shop_table, body.woocommerce-js form.woocommerce-checkout, body.woocommerce-js form.woocommerce-cart-form,
        .horizontal ul.product-item-meta li a,
        select option,
        .product_store_faq_widget .ui-accordion .ui-accordion-header,
        .product_store_faq_widget .ui-accordion .ui-accordion-content,
        .product_store_faq_widget form,
        .product_store_contact_widget form,
        .testimonial-single .testi-details,
        .insta-details,
        .latest-reviews-single,
        .shopical-product-summary-wrap,
        .categories-mega-list-wrapper,
        .category-dropdown.show-nested-subcategories li.aft-category-list > ul,
        .woocommerce nav.woocommerce-pagination ul li a, .woocommerce nav.woocommerce-pagination ul li span,
        .woocommerce nav.woocommerce-pagination ul li a:focus, .woocommerce nav.woocommerce-pagination ul li a:hover, .woocommerce nav.woocommerce-pagination ul li span.current,
        .woocommerce-MyAccount-content, nav.woocommerce-MyAccount-navigation,
        .main-navigation .menu ul ul, .main-navigation ul .sub-menu,
        .panel,
        .woocommerce-message, address,
        .woocommerce ul.woocommerce-error,
        .woocommerce-info,
        .top-cart-content.primary-bgcolor,
        .account-user .af-my-account-menu,
        .lang-curr .aft-language-currency-switcher,
        .entry-wrapper,
        .comments-area,
        .woocommerce-tabs.wc-tabs-wrapper,
        .posts_latest_widget .blog-details,
        .woocommerce ul.products li.product-category.product > a,
        .product-wrapper ul.product-item-meta.verticle .yith-btn a:before,
        .site-footer .owl-theme .owl-dots .owl-dot span,
        .site-footer .owl-theme .owl-dots .owl-dot:hover span,
        .site-footer .owl-theme .owl-dots .owl-dot.active span,
        .main-banner-slider.owl-theme .owl-dots .owl-dot span,
        .main-banner-slider.owl-theme .owl-dots .owl-dot:hover span,
        .main-banner-slider.owl-theme .owl-dots .owl-dot.active span,
        .left-grid-section.owl-theme .owl-dots .owl-dot span,
        .left-grid-section.owl-theme .owl-dots .owl-dot:hover span,
        .left-grid-section.owl-theme .owl-dots .owl-dot.active span,
        .content-caption .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li a:after,
        .product-item-meta.add-to-cart-button.extended-af ul.product-item-meta-always-visible li a:after,
        ul.product-item-meta li,
        #wp-calendar tbody td,
        #wp-calendar tbody td#today,
        .instagram .insta-feed-head a,
        ul.product-item-meta li a.added_to_cart,
        .woocommerce form.checkout_coupon,
        .woocommerce form.login,
        .woocommerce form.register,
        #sidr .aft-carousel .owl-nav button span, 
        #secondary .aft-carousel .owl-nav button span, 
        footer .aft-carousel .owl-nav button span,
        .aft-slider .owl-nav button span,
        #add_payment_method #payment div.payment_box,
        .woocommerce-cart #payment div.payment_box,
        .woocommerce-checkout #payment div.payment_box,
        #yith-quick-view-modal .yith-wcqv-main,
        #yith-wcwl-popup-message,
        body .product-wrapper
        {
        background-color: <?php echo $secondary_background_color; ?>;
        }

        #add_payment_method #payment div.payment_box::before,
        .woocommerce-cart #payment div.payment_box::before,
        .woocommerce-checkout #payment div.payment_box::before{
        border-bottom: 1em solid <?php echo $secondary_background_color; ?>;
        }

        @media screen and (max-width: 768px){
            .aft-carousel .owl-nav button span{
                background-color: <?php echo $secondary_background_color; ?>;
            }
        }

    <?php endif; ?>

        <?php if ($shopical_store_product_search_color == 'custom-color') {
        $search_background_color = shopical_get_option('store_product_search_custom_background_color');
        $search_text_color = shopical_get_option('store_product_search_custom_text_color');
        $search_border_color = shopical_get_option('store_product_search_custom_border_color');
    } elseif ($shopical_store_product_search_color == 'primary-background-color') {
        $search_background_color = $shopical_background_color;
        $search_text_color = $shopical_primary_color;
        $search_border_color = $shopical_secondary_border_color;
    } elseif ($shopical_store_product_search_color == 'tertiary-background-color') {
        $search_background_color = $tertiary_background_color;
        $search_text_color = $shopical_primary_color;
        $search_border_color = $shopical_secondary_border_color;
    } else {
        $search_background_color = $secondary_background_color;
        $search_text_color = $shopical_primary_color;
        $search_border_color = $shopical_secondary_border_color;


    }
        ?>

    <?php if (!empty($search_background_color)): ?>
        .style-3-search,
        .style-3-search .search-field,
        .style-3-search button {
        background-color: <?php echo $search_background_color; ?>;
        }
    <?php endif; ?>

    <?php if (!empty($search_text_color)): ?>
        body .style-3-search button[type="submit"],
        body .style-3-search .search-field,
        body .style-3-search input[type="search"],
        body .style-3-search input[type="search"]::placeholder,
        body .style-3-search .cate-dropdown {
        color: <?php echo $search_text_color; ?>;
        }
    <?php endif; ?>


        <?php if (!empty($search_border_color)): ?>
        .style-3-search .cate-dropdown, 
        .woocommerce .style-3-search button[type="submit"], 
        .style-3-search button, 
        .style-3-search{
        border-color: <?php echo $search_border_color; ?>;
        }
    <?php endif; ?>


        <?php if (!empty($shopical_primary_title_color)): ?>

        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6,
        body #primary .widget-title,
        body .section-title,
        body #sidr .widget-title,
        body #secondary .widget-title,
        body .page-title,
        body.blog h1.page-title,
        body.archive h1.page-title,
        body.woocommerce-js article .entry-title,
        body.blog article h2 a,
        body.archive article h2 a
        {
        color: <?php echo $shopical_primary_title_color; ?>;

        }
    <?php endif; ?>

        <?php if (!empty($shopical_secondary_title_color)): ?>

        .aft-notification-title,
        .right-list-section h4,
        .right-list-section .category-dropdown > ul > li > a,
        .right-list-section .category-dropdown > ul > li > a > h4,
        .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item a,
        .woocommerce .woocommerce-widget-layered-nav-list .woocommerce-widget-layered-nav-list__item span,
        body .product-title a,
        .woocommerce ul li .product-title a,
        .woocommerce ul.products li.product .woocommerce-loop-category__title,
        .woocommerce-page ul.products li.product .woocommerce-loop-category__title,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header[aria-expanded="true"],
        body .product_store_faq_widget .ui-accordion .ui-accordion-header[aria-expanded="true"]:before,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header.ui-accordion-header-active,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header:hover,
        body .support-content h5,
        body .blog-title h4 a,
        .insta-details,
        p.insta-desc,
        .woocommerce ul.product_list_widget li a,
        body.single-product .entry-summary .button.compare,
        body.single-product .entry-summary .yith-wcwl-add-to-wishlist a,
        body.single-product .entry-summary .yith-wcwl-wishlistexistsbrowse a:before, 
        body.single-product .entry-summary .yith-wcwl-wishlistaddedbrowse a:before,
        body h3.article-title.article-title-1 a:visited,
        body .trending-posts-carousel h3.article-title a:visited,
        body .exclusive-slides a:visited,
        #sidr .widget > ul > li a,
        #secondary .widget > ul > li a
        {
        color: <?php echo $shopical_secondary_title_color; ?>;
        opacity: 1;
        }
    <?php endif; ?>


        <?php if (!empty($shopical_tertiary_title_color)): ?>

        .woocommerce table.shop_table.cart.wishlist_table a.button,
        .woocommerce table.shop_table.cart.wishlist_table a.button:hover,
        ul.product-item-meta li a.added_to_cart:hover,
        .inner-suscribe input[type=submit]:hover,
        .woocommerce #respond input#submit,
        .woocommerce #respond input#submit:hover,
        .comment-form .submit, input.search-submit,
        .comment-form .submit:hover, input.search-submit:hover,
        .horizontal ul.product-item-meta li a:hover,
        .aft-notification-button a:hover,
        .aft-notification-button a,
        span.offer-time.btn-style1 a,
        body .sale-title,
        .main-banner-slider .content-caption .cat-links li a,
        .product-slider .content-caption,
        .product-slider .content-caption .cat-links a,
        .product-slider .content-caption .product-title a,
        .content-caption span.woocommerce-Price-amount.amount,
        .content-caption span.price del,
        .content-caption span.price ins,
        .caption-heading .cap-title a,
        .content-caption .content-desc,
        body .sale-info span.item-count,
        .whit-col span,
        body .shopical_social_mailchimp_widget h4.section-title,
        body #primary .call-to-action .widget-title.section-title,
        body .shopical_social_mailchimp_widget .section-subtitle,
        .mail-wrappper .section-subtitle,
        body .call-to-action,
        body .call-to-action .section-title,
        body .call-to-action .section-subtitle,
        body .sale-single-wrap
        {
        color: <?php echo $shopical_tertiary_title_color; ?> !important;
        }

        span.offer-time.btn-style1 a{
        border-color: <?php echo $shopical_tertiary_title_color; ?>;
        }

    <?php endif; ?>

    

    <?php if (!empty($shopical_font_weight)): ?>

        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6,
        #scroll-up i,
        .nav-tabs>li>a,
        .blog-title h4,
        div#respond h3#reply-title,
        .site-footer .widget-title,
        .site-footer .section-title,
        .caption-heading .cap-title,
        .widget-title, .section-title,
        span.item-metadata.posts-author a,
        .section-head span.aft-view-all a,
        body.archive .content-area .page-title,
        .woocommerce div.product .product_title,
        body header.entry-header h1.entry-title,
        .tabbed-container .tab-content .article-title-1 a,
        #secondary .widget ul.article-item li .article-title-1 a,
        .product_store_faq_widget .ui-accordion .ui-accordion-header,
        body.search-results .content-area .header-title-wrapper .page-title
        {
        font-weight: <?php echo $shopical_font_weight; ?>;
        }

    <?php endif; ?>

    <?php if (!empty($shopical_line_height)): ?>

        p,
        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6 ,
        .blog-title h4,
        body .title-role,
        div#respond h3#reply-title,
        .site-footer .widget-title,
        .site-footer .section-title,
        .caption-heading .cap-title,
        .widget-title, .section-title,
        .contact-details span,
        body .section-subtitle,
        body .woocommerce-info,
        body .woocommerce-error,
        body .woocommerce-message,
        .aft-schedule-note-section,
        .widget-title, .section-title,
        body .testi-details span.expert,
        .product_store_faq_widget .blog-details,
        body.woocommerce ul.products li.product .price del,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header
        {
        line-height: <?php echo $shopical_line_height; ?>;
        }

    <?php endif; ?>

    <?php if (!empty($shopical_letter_spacing)): ?>

        p,
        body h1,
        body h2,
        body h2 span,
        body h3,
        body h4,
        body h5,
        body h6 ,
        body .price del,
        body .title-role,
        .contact-details span,
        body .section-subtitle,
        body .woocommerce-info,
        body .woocommerce-error,
        body .woocommerce-message,
        aft-schedule-note-section,
        .widget-title, .section-title,
        body .testi-details span.expert,
        .product_store_faq_widget .blog-details,
        body.woocommerce ul.products li.product .price del,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header
        {
        letter-spacing: <?php echo $shopical_letter_spacing; ?>px;
        }

    <?php endif; ?>

        <?php if (!empty($main_navigation_background_color)): ?>

        .header-style-3-1 .navigation-section-wrapper,
        .header-style-3 .navigation-section-wrapper
        {
        background-color: <?php echo $main_navigation_background_color; ?>;
        }

        @media screen and (max-width: 992em){

            .main-navigation .menu .menu-mobile{
                background-color: <?php echo $main_navigation_background_color; ?>;
            }

        }

    <?php endif; ?>


        <?php if (!empty($main_navigation_link_color)): ?>

        #primary-menu  ul > li > a,
        .main-navigation li a:hover, 
        .main-navigation ul.menu > li > a,
        #primary-menu  ul > li > a:visited,
        .main-navigation ul.menu > li > a:visited,
        .main-navigation .menu.menu-mobile > li > a,
        .main-navigation .menu.menu-mobile > li > a:hover, 
        .header-style-3-1.header-style-compress .main-navigation .menu ul.menu-desktop > li > a
        {
        color: <?php echo $main_navigation_link_color; ?>;
        }

        .ham,.ham:before, .ham:after
        {
        background-color: <?php echo $main_navigation_link_color; ?>;
        }

        @media screen and (max-width: 992em){

            .main-navigation .menu .menu-mobile li a i:before, 
            .main-navigation .menu .menu-mobile li a i:after{
                background-color: <?php echo $main_navigation_link_color; ?>;
            }

        }

    <?php endif; ?>

        <?php if (!empty($menu_badge_background)): ?>

        .main-navigation .menu-desktop > li > a:before ,    
        .main-navigation .menu > li > a:before,
        .menu-description
        {
        background: <?php echo $menu_badge_background; ?>;
        }

        .menu-description:after
        {
        border-top: 5px solid <?php echo $menu_badge_background; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($menu_badge_color)): ?>

        .menu-description
        {
        color: <?php echo $menu_badge_color; ?>;
        }

    <?php endif; ?>


        <?php if (!empty($shopical_global_badge_background)): ?>

        .right-list-section .category-dropdown .product-loop-wrapper span.onsale,    
        body .express-off-canvas-panel a.offcanvas-nav i,
        .posts_latest_widget .posts-date,
        span.offer-date-counter > span,
        body span.title-note span,
        body .badge-wrapper span.onsale,
        body span.product-count span.item-texts,
        body .post-thumbnail-wrap .posts-date,
        body .posts_latest_widget .posts-date
        {
        background: <?php echo $shopical_global_badge_background; ?>;
        }
        body .gbl-bdge-bck-c{
        background: <?php echo $shopical_global_badge_background; ?> !important;
        }

        span.offer-date-counter > span{
        border-color: <?php echo $shopical_global_badge_background; ?>;
        }

        body span.title-note span:after
        {
        border-top: 5px solid <?php echo $shopical_global_badge_background; ?>;
        }

        body span.product-count span.item-texts:after{
        border-top: 10px solid <?php echo $shopical_global_badge_background; ?>;
        }

        body .gbl-bdge-bck-c:before
        {
        border-right: 7px solid <?php echo $shopical_global_badge_background; ?> !important;
        }
        body.rtl .gbl-bdge-bck-c:before
        {
        border-right: none !important;
        border-left: 7px solid <?php echo $shopical_global_badge_background; ?> !important;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_global_badge_color)): ?>

        .right-list-section .category-dropdown .product-loop-wrapper span.onsale,    
        body .badge-wrapper span.onsale,
        span.offer-date-counter > span .text,
        span.offer-date-counter > span .number,
        span.offer-date-counter > span,
        .badge-wrapper .onsale,
        .woocommerce span.onsale,
        span.product-count span.item-texts,
        span.title-note,
        body .post-thumbnail-wrap .posts-date,
        body .posts_latest_widget .posts-date
        {
        color: <?php echo $shopical_global_badge_color; ?> ;
        }
        body .gbl-bdge-bck-c{
        color: <?php echo $shopical_global_badge_color; ?> !important;
        }

    <?php endif; ?>


        <?php if (!empty($shopical_title_over_image_color)): ?>

        body .slider-figcaption-1 .slide-title a,
        body .categorized-story .title-heading .article-title-2 a,
        body .full-plus-list .spotlight-post:first-of-type figcaption h3 a{
        color: <?php echo $shopical_title_over_image_color; ?>;
        }

        body .slider-figcaption-1 .slide-title a:visited,
        body .categorized-story .title-heading .article-title-2 a:visited,
        body .full-plus-list .spotlight-post:first-of-type figcaption h3 a:visited{
        color: <?php echo $shopical_title_over_image_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_postformat_color)): ?>
        body .figure-categories-bg .em-post-format{
        background: <?php echo $shopical_postformat_color; ?>;
        }
        body .em-post-format{
        color: <?php echo $shopical_postformat_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_primary_font)): ?>

        body,
        body button,
        body input,
        body select,
        body optgroup,
        div.sharedaddy h3.sd-title,
        body textarea {
        font-family: <?php echo $shopical_primary_font; ?> !important;
        }

    <?php endif; ?>

        <?php if (($shopical_secondary_font)): ?>

        body h1,
        body h2,
        body h3,
        body h4,
        body h5,
        body h6,
        body .main-navigation a,
        .account-user .af-my-account-menu li a,
        body .font-family-1,
        body .site-description,
        body .trending-posts-line,
        body .exclusive-posts,
        body .widget-title,
        body .section-title,
        body .em-widget-subtitle,
        body .grid-item-metadata .item-metadata,
        body .af-navcontrols .slide-count,
        body .figure-categories .cat-links,
        body .nav-links a {
        font-family: <?php echo $shopical_secondary_font; ?>;
        }

    <?php endif; ?>

    


    <?php if (!empty($shopical_primary_footer_background_color)): ?>

        body footer.site-footer .primary-footer {
        background: <?php echo $shopical_primary_footer_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($shopical_primary_footer_texts_color)): ?>

        body footer.site-footer .primary-footer,
        body footer.site-footer ins,
        body footer.site-footer .primary-footer .widget-title span,
        body footer.site-footer .primary-footer .site-title a,
        body footer.site-footer .primary-footer .site-description,
        body footer.site-footer .primary-footer a {
        color: <?php echo $shopical_primary_footer_texts_color; ?>;

        }

        footer.site-footer .primary-footer .social-widget-menu ul li a,
        footer.site-footer .primary-footer .em-author-details ul li a,
        footer.site-footer .primary-footer .tagcloud a
        {
        border-color: <?php echo $shopical_primary_footer_texts_color; ?>;
        }

        footer.site-footer .primary-footer a:visited {
        color: <?php echo $shopical_primary_footer_texts_color; ?>;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_secondary_footer_background_color)): ?>

        body footer.site-footer .secondary-footer {
        background: <?php echo $shopical_secondary_footer_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($shopical_secondary_footer_texts_color)): ?>

        body footer.site-footer .secondary-footer .footer-navigation a{
        color: <?php echo $shopical_secondary_footer_texts_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_footer_credits_background_color)): ?>
        body footer.site-footer .site-info {
        background: <?php echo $shopical_footer_credits_background_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_footer_credits_texts_color)): ?>
        body footer.site-footer .site-info,
        footer.site-footer .site-info-wrap,
        body footer.site-footer .site-info a {
        color: <?php echo $shopical_footer_credits_texts_color; ?>;

        }

    <?php endif; ?>

        <?php if (!empty($shopical_mailchimp_background_color)): ?>
        body .social-mailchimp {
        background: <?php echo $shopical_mailchimp_background_color; ?>;

        }

    <?php endif; ?>


        <?php if (!empty($shopical_mailchimp_filed_border_color)): ?>

        body .mc4wp-form-fields input[type="text"], body .mc4wp-form-fields input[type="email"] {
        border-color: <?php echo $shopical_mailchimp_filed_border_color; ?>;

        }

    <?php endif; ?>

        @media only screen and (min-width: 1025px) and (max-width: 1599px) {

        <?php if (!empty($shopical_mainbanner_silder_caption_font_size)): ?>

        body .main-banner-slider .caption-heading .cap-title {
        font-size: <?php echo $shopical_mainbanner_silder_caption_font_size; ?>px;

        }
    <?php endif; ?>
        }


        <?php if (!empty($shopical_primary_title_font_size)): ?>

        body.woocommerce div.product .product_title,
        body span.header-after,
        body.archive .content-area .page-title,
        body.search-results .content-area .header-title-wrapper .page-title,
        body header.entry-header h1.entry-title,
        body .sale-info span.product-count,
        body .sale-title
        {
        font-size: <?php echo $shopical_primary_title_font_size; ?>px;
        }

    <?php endif; ?>


        <?php if (!empty($shopical_secondary_title_font_size)): ?>

        h2.entry-title,
        .cart_totals h2,
        h2.comments-title,
        .support-content h5,
        #sidr .widget-title,
        div#respond h3#reply-title,
        section.related.products h2,
        body #sidr span.header-after,
        body #secondary .widget-title span,
        body footer .widget-title .header-after
        {
        font-size: <?php echo $shopical_secondary_title_font_size; ?>px;
        }

    <?php endif; ?>

        <?php if (!empty($shopical_tertiary_title_font_size)): ?>

        .nav-tabs>li>a,
        body .product_store_faq_widget .ui-accordion .ui-accordion-header,
        {
        font-size: <?php echo $shopical_tertiary_title_font_size; ?>px;
        }

    <?php endif; ?>


        <?php
        return ob_get_clean();
    }
}


