<?php
/**
 * Block Product Carousel support.
 *
 * @package Shopical
 */


/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_product_mega_menu')):
    function shopical_product_mega_menu($cat_id)
    {
        $cat_product = shopical_get_products(5, $cat_id);
        $output = '';
        if ($cat_product->have_posts()) :
            $output .= '<ul class="product-ul">';
            while ($cat_product->have_posts()):
                $cat_product->the_post();

                $output .= '<li class="item col-1 float-l pad list-group-product-loop">';
                $product_lists = '';
                ob_start(); ?>

                <div class="product-loop-wrapper">
                    <?php
                    global $post;
                    $url = shopical_get_featured_image($post->ID, 'thumbnail');
                    ?>
                    <div class="product-wrapper">
                        <div class="product-image-wrapper">
                            <?php
                            if ($url): ?>
                                <a href="<?php the_permalink(); ?>">
                                    <img src="<?php echo esc_attr($url); ?>">
                                </a>
                            <?php endif; ?>
                            <div class="badge-wrapper">
                                <?php do_action('shopical_woocommerce_show_product_loop_sale_flash'); ?>
                            </div>
                        </div>
                        <div class="product-description">
                            <div class="product-title-wrapper">
                                <h4 class="product-title">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_title(); ?>
                                    </a>
                                </h4>
                            </div>
                            <span class="price">
                            <?php do_action('shopical_woocommerce_after_shop_loop_item_title'); ?>
                        </span>

                            <div class="product-item-meta add-to-cart-button">
                                <div class="default-add-to-cart-button">
                                    <?php do_action('shopical_woocommerce_template_loop_add_to_cart'); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <?php

                $product_lists = ob_get_contents();
                ob_end_clean();
                $output .= $product_lists;
                $output .= '</li>';

            endwhile;

            $output .= '</ul>';

        endif;
        wp_reset_postdata();
        return $output;
    }
endif;


/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_product_menu_list')):
    function shopical_product_menu_list($cat_id)
    {
        $cat_product = shopical_get_products(5, $cat_id);

        $output = '';

        if ($cat_product->have_posts()) :

            $output .= '<ul class="product-ul">';

            while ($cat_product->have_posts()):

                $cat_product->the_post();

                $output .= '<li class="item col-1 float-l pad list-group-product-loop">';
                $product_lists = '';
                ob_start(); ?>
                <h4 class="product-title">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_title(); ?>
                    </a>
                </h4>
                <?php

                $product_lists = ob_get_contents();
                ob_end_clean();
                $output .= $product_lists;
                $output .= '</li>';

            endwhile;

            $output .= '</ul>';


        endif;
        wp_reset_postdata();
        return $output;
    }
endif;


if (!function_exists('shopical_product_category_loop')):
    function shopical_product_category_loop($category, $product_count = 'true', $onsale_product_count = 'true', $thumbnails = 'shopical-medium-center')
    {
        if (0 != absint($category)):
            $term = get_term_by('id', $category, 'product_cat');
            if ($term):
                $term_name = $term->name;
                $term_link = get_term_link($term);
                $products_count = shopical_product_count($term->term_id);
                $products_count = ($product_count == 'true') ? $products_count : 0;
                $product_onsale = shopical_onsale_product_count($term->term_id);
                $product_onsale = ($onsale_product_count == 'true') ? $product_onsale : 0;
                $meta = get_term_meta($category);

                if (isset($meta['thumbnail_id'])) {
                    $thumb_id = $meta['thumbnail_id'][0];
                    $thumb_url = wp_get_attachment_image_src($thumb_id, $thumbnails);
                    $url = $thumb_url[0];
                } else {
                    $url = '';
                }
                ?>
                <div class="data-bg data-bg-hover sale-background af-slide-hover"
                     data-background="<?php echo esc_url($url); ?>">
                    <a href="<?php echo esc_url($term_link); ?>"></a>
                </div>
                <div class="sale-info">
            <span class="off-tb">
                <span class="off-tc">
                    <a href="<?php echo esc_url($term_link); ?>"></a>
                    <h4 class="sale-title"><?php echo esc_html($term_name); ?></h4>
                    <?php if (absint($products_count) > 0): ?>
                        <span class="product-count">
                            <?php printf(_n('<span class="item-count">%s</span>
<span class="item-texts">item</span>', '<span class="item-count">%s</span><span class="item-texts">items</span>', $products_count, 'shopical'), number_format_i18n($products_count)); ?></span>
                    <?php endif; ?>
                    <?php if (absint($product_onsale) > 0): ?>
                        <span class="product-count onsale-product-count">
                        <?php
                        $sale_flash_text = shopical_get_option('store_single_sale_text');
                        ?>
                            <span class="item-count">
                                <?php echo $product_onsale; ?>
                            </span>
                            <span class="item-texts item-texts-onsale">
                                <?php echo $sale_flash_text; ?>
                            </span>
                    </span>
                    <?php endif; ?>
                </span>
            </span>

                </div>


            <?php
            endif;
        endif;
    }

endif;


/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_list_categories')):
    function shopical_list_categories($taxonomy_id = 0, $product_count = 'true', $onsale_product_count = 'true')
    {
        $categories_section_mode = shopical_get_option('select_top_categories_section_mode');
        $categories_hover_mode = shopical_get_option('select_top_categories_on_hover');
        $orderby = shopical_get_option('select_top_categories_orderby');
        $order = shopical_get_option('select_top_categories_order');
        $output = '';
        $show_product_class = '';

        $show_product = true;
        if ($categories_hover_mode == 'top-5-products') {
            $show_product_class = 'aft-mega-menu-list';
        }

        $section_class = 'aft-category-list-set';

        if ($categories_section_mode == 'selected-categories') {
            $selected_categories = shopical_get_product_categories_selected();
            if (isset($selected_categories)) {
                $product_categories = $selected_categories;
            } else {
                $product_categories = shopical_get_product_categories($taxonomy_id, $orderby, $order, 10, true, true);
            }
        } else {
            $product_categories = shopical_get_product_categories($taxonomy_id, $orderby, $order, 10, true, true);
        }


        if ($product_categories) {
            $output .= '<ul class="' . $section_class . '">';
            foreach ($product_categories as $cat) {

                $product_count_no = 0;
                if ($product_count == 'true') {
                    $product_count_no = shopical_product_count($cat->term_id);
                }

                $product_onsale_no = 0;
                if ($onsale_product_count == 'true') {
                    $product_onsale_no = shopical_onsale_product_count($cat->term_id);
                }

                $has_child = shopical_has_term_have_children($cat->term_id, 'product_cat');
                $has_child = ($has_child) ? 'has-child-categories aft-category-list' : 'aft-category-list';
                $output .= '<li class="' . $has_child . ' ' . $show_product_class . '">';
                $output .= '<a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s", 'shopical'), $cat->name) . '" ' . '>';
                $output .= '<h4>' . $cat->name . ' </h4>';
                $output .= '<span class="category-badge-wrapper">';

                if (absint($product_count_no) > 0) {
                    $output .= '<span class="onsale">' . $product_count_no . ' items</span>';
                }
                if (absint($product_onsale_no) > 0) {

                    $sale_flash_text = shopical_get_option('store_single_sale_text');
                    $output .= '<span class="onsale">';
                    $output .= $product_onsale_no;
                    $output .= ' ';
                    $output .= $sale_flash_text;
                    $output .= '</span>';

                }
                $output .= '</span>';

                $output .= '</a>';


                if ($categories_hover_mode == 'top-5-products') {
                    $mega_menu = shopical_product_mega_menu($cat->term_id);
                    $output .= $mega_menu;
                }


                $output .= '</li>';

            }


            $output .= '</ul>';
        }

        return $output;
    }
endif;

/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_list_categories_dropdown')):
    function shopical_list_categories_dropdown($taxonomy_id = 0, $product_count = 'true', $onsale_product_count = 'true', $mega_menu = false, $menu_level = 0)
    {
        $output = '';
        $section_class = 'aft-category-list-set';

        $args = array(
            'parent' => $taxonomy_id,
            'number' => 10,
        );

        $next = get_terms('product_cat', $args);

        if ($next) {


            $output .= '<ul class="' . $section_class . '">';

            foreach ($next as $cat) {

                $product_count_no = 0;
                if ($product_count == 'true') {
                    $product_count_no = shopical_product_count($cat->term_id);
                }

                $product_onsale_no = 0;
                if ($onsale_product_count == 'true') {
                    $product_onsale_no = shopical_onsale_product_count($cat->term_id);
                }


                $has_child = shopical_has_term_have_children($cat->term_id, 'product_cat');
                $has_child_class = ($has_child) ? 'has-child-categories aft-category-list' : 'aft-category-list';
                $output .= '<li class="' . $has_child_class . '">';


                $output .= '<a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s", 'shopical'), $cat->name) . '" ' . '>';
                $output .= '<h4>' . $cat->name . ' </h4>';
                $output .= '<span class="category-badge-wrapper">';

                if (absint($product_count_no) > 0) {
                    $output .= '<span class="onsale">' . $product_count_no . ' items</span>';
                }
                if (absint($product_onsale_no) > 0) {

                    $sale_flash_text = shopical_get_option('store_single_sale_text');
                    $output .= '<span class="onsale">';
                    $output .= $product_onsale_no;
                    $output .= ' ';
                    $output .= $sale_flash_text;
                    $output .= '</span>';

                }
                $output .= '</span>';
                $output .= '</a>';

                $output .= $cat->term_id !== 0 ? shopical_list_categories_dropdown($cat->term_id, $product_count, $onsale_product_count) : null;
            }
            $output .= '</li>';

            $output .= '</ul>';
        }

        return $output;
    }
endif;

/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_list_categories_mega_list')):
    function shopical_list_categories_mega_list($taxonomy_id = 0, $product_count = 'true', $onsale_product_count = 'true', $parent = 0, $menu_level = 0)
    {

        $output = '';
        $section_class = 'aft-category-list-set';
        $count = 0;

        $args = array(
            'parent' => $taxonomy_id,
        );

        //$next = get_terms('product_cat', $args);
        $next = shopical_get_product_categories($taxonomy_id);

        if ($next) {

            $output .= '<ul class="' . $section_class . '">';

            foreach ($next as $cat) {
                $product_count_no = 0;
                if ($product_count == 'true') {
                    $product_count_no = shopical_product_count($cat->term_id);
                }

                $product_onsale_no = 0;
                if ($onsale_product_count == 'true') {
                    $product_onsale_no = shopical_onsale_product_count($cat->term_id);
                }

                $has_child = shopical_has_term_have_children($cat->term_id, 'product_cat');
                $has_child_class = ($has_child) ? 'has-child-categories aft-category-list' : 'aft-category-list';

                $output .= '<li class="' . $has_child_class . '">';
                $output .= '<a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s", 'shopical'), $cat->name) . '" ' . '>';
                $output .= '<h4>' . $cat->name . '</h4>';
                $output .= '<span class="category-badge-wrapper">';

                if (absint($product_count_no) > 0) {
                    $output .= '<span class="onsale">' . $product_count_no . ' items</span>';
                }
                if (absint($product_onsale_no) > 0) {

                    $sale_flash_text = shopical_get_option('store_single_sale_text');
                    $output .= '<span class="onsale">';
                    $output .= $product_onsale_no;
                    $output .= ' ';
                    $output .= $sale_flash_text;
                    $output .= '</span>';

                }
                $output .= '</span>';
                $output .= '</a>';

                $output .= '<span class="categories-mega-list-wrapper">';
                $output .= $cat->term_id !== 0 ? shopical_list_subcategories($cat->term_id, $product_count, $onsale_product_count) : null;
                $output .= "</span>";


                $count++;
            }
            $output .= '</li>';

            $output .= '</ul>';
        }

        return $output;
    }
endif;

/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_list_subcategories')):
    function shopical_list_subcategories($taxonomy_id = 0, $product_count = 'true', $onsale_product_count = 'true')
    {
        $output = '';


        $show_product_class = 'aft-mega-menu-list';
        $section_class = 'aft-category-list-set';

        $product_categories = shopical_get_product_categories($taxonomy_id, 'name');

        if ($product_categories) {
            //$output .= '<ul class="' . $section_class . '">';
            foreach ($product_categories as $cat) {
                $product_count_no = 0;
                if ($product_count == 'true') {
                    $product_count_no = shopical_product_count($cat->term_id);
                }

                $product_onsale_no = 0;
                if ($onsale_product_count == 'true') {
                    $product_onsale_no = shopical_onsale_product_count($cat->term_id);
                }


                $has_child = shopical_has_term_have_children($cat->term_id, 'product_cat');
                $has_child = ($has_child) ? 'has-child-categories aft-category-list' : 'aft-category-list';
                $output .= '<span class="' . $has_child . ' ' . $show_product_class . '">';

                $output .= '<div class="sub-cat-section-wrap">';
                $output .= '<a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s", 'shopical'), $cat->name) . '" ' . '>';
                $output .= '<h4>' . $cat->name . ' </h4>';


                $output .= '<span class="category-badge-wrapper">';

                if (absint($product_count_no) > 0) {
                    $output .= '<span class="onsale">' . $product_count_no . ' items</span>';
                }
                if (absint($product_onsale_no) > 0) {

                    $sale_flash_text = shopical_get_option('store_single_sale_text');
                    $output .= '<span class="onsale">';
                    $output .= $product_onsale_no;
                    $output .= ' ';
                    $output .= $sale_flash_text;
                    $output .= '</span>';

                }
                $output .= '</span>';


                $output .= '</a>';

                if (absint($product_count_no) > 4) {
                    $output .= '<div class="aft-view-all">';
                    $output .= '<a href="<?php echo esc_url(get_term_link($cat->term_id)); ?>"><?php _e("View All", "shopical"); ?></a>';
                    $output .= '</div>';
                }
                $output .= '</div>';


                $mega_menu = shopical_product_menu_list($cat->term_id);
                $output .= $mega_menu;

                $output .= '</span>';
                $output .= $cat->term_id !== 0 ? shopical_list_subcategories($cat->term_id, $product_count, $onsale_product_count) : null;

            }


            //$output .= '</ul>';
        }

        return $output;
    }
endif;

/**
 * Display or retrieve the HTML list of product categories.
 *
 * @since 2.1.0
 * @since 4.4.0 Introduced the `hide_title_if_empty` and `separator` arguments. The `current_category` argument was modified to
 *              optionally accept an array of values.
 * */
if (!function_exists('shopical_list_categories_extended')):
    function shopical_list_categories_extended($taxonomy_id = 0, $product_count = 'true', $onsale_product_count = 'true')
    {
        $output = '';

        $orderby = 'name';
        $order = 'asc';
        $hide_empty = true;
        $cat_args = array(
            'orderby' => $orderby,
            'order' => $order,
            'hide_empty' => $hide_empty,
        );

        $product_categories = get_terms('product_cat', $cat_args);

        if ($product_categories) {

            foreach ($product_categories as $cat) {
                $product_count_no = 0;
                if ($product_count == 'true') {
                    $product_count_no = shopical_product_count($cat->term_id);
                }

                $product_onsale_no = 0;
                if ($onsale_product_count == 'true') {
                    $product_onsale_no = shopical_onsale_product_count($cat->term_id);
                }

                $meta = get_term_meta($cat->term_id);

                if (isset($meta['thumbnail_id'])) {
                    $thumb_id = $meta['thumbnail_id'][0];
                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'shopical-medium-slider');
                    $url = $thumb_url[0];
                    $url = esc_url($url);
                } else {
                    $url = '';
                }

                $has_child = shopical_has_term_have_children($cat->term_id, 'product_cat');
                $has_child = ($has_child) ? 'has-child-categories' : '';

                $output .= '<div class="item margi-btm-10 pad">';

                $output .= '<figure class="' . $has_child . ' data-bg data-bg-hover"
                     data-background="' . $url . '">';

                $output .= '<a href="' . get_term_link($cat->slug, $cat->taxonomy) . '" title="' . sprintf(__("View all products in %s", 'shopical'), $cat->name) . '" ' . '>';
                $output .= '</a>';

                $output .= '<div class="sale-info">';
                $output .= '<span class="off-tb">';
                $output .= '<span class="off-tc">';
                $output .= '<h4>' . $cat->name . ' </h4>';

                if (absint($product_count_no) > 0) {

                    $output .= '<span class="product-count">';
                    $output .= sprintf(_n('<span class="item-count">%s</span>
<span class="item-texts">item</span>', '<span class="item-count">%s</span><span class="item-texts">items</span>', $product_count_no, 'shopical'), number_format_i18n($product_count_no));
                    $output .= '</span>';
                }

                if (absint($product_onsale_no) > 0) {
                    $output .= '<span class="product-count onsale-product-count">';
                    $sale_flash_text = shopical_get_option('store_single_sale_text');
                    $output .= '<span class="item-count">';
                    $output .= $product_onsale_no;
                    $output .= '</span>';
                    $output .= '<span class="item-texts item-texts-onsale">';
                    $output .= $sale_flash_text;
                    $output .= '</span>';
                    $output .= '</span>';
                }
                $output .= '</span>';
                $output .= '</span>';
                $output .= '</div>';

                $output .= '</figure>';

                $output .= '</div>';

            }

        }
        return $output;
    }
endif;

if (!function_exists('shopical_get_page_loop')):
    function shopical_get_page_loop($show_title = 'true', $button_text = '', $button_link = '#')
    {
        $url = shopical_get_featured_image(get_the_ID(), 'shopical-thumbnail');
        ?>

        <div class="item grid-item-single" >
            <div class="item-grid-item-single-wrap">
            <div class="data-bg data-bg-hover data-bg-slide "
                 data-background="<?php echo esc_url($url); ?>">
            </div>
                <?php if ($button_link): ?>
                        <a href="<?php echo esc_url($button_link); ?>"></a>
                <?php endif; ?>

            <div class="pos-rel">
                <?php if ($show_title == 'true'): ?>
                    <div class="content-caption-overlay-shine"><span></span></div>
                    <div class="content-caption-overlay"></div>
                <?php endif; ?>

                <div class="content-caption on-left">

                    <?php if ($show_title == 'true'): ?>
                        <div class="caption-heading">
                            <h5 class="cap-title">
                                <a href="<?php echo esc_url($button_link); ?>">
                                    <?php echo get_the_title(get_the_ID()); ?></a>
                            </h5>
                        </div>
                    <?php endif; ?>
                    <?php if ($button_link && $button_text): ?>
                        <div class="aft-btn-warpper btn-style1 btn-style2">
                            <a href="<?php echo esc_url($button_link); ?>"><?php echo esc_html($button_text); ?></a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        </div>

        <?php
    }
endif;


/**
 * Front page section additions.
 */



if ( ! function_exists( 'shopical_full_width_upper_footer_section' ) ) :
    /**
     *
     * @since Magazine 7 1.0.0
     *
     * @param null
     * @return null
     *
     */
    function shopical_full_width_upper_footer_section() {

        $instagram_scope = shopical_get_option('footer_instagram_post_carousel_scopes');
        if ($instagram_scope == 'front-page') {
            if (is_front_page() || is_home()) {
                if ( 1 == shopical_get_option('footer_show_instagram_post_carousel') ) {
                    shopical_get_block('store-instagram', 'section');
                }
            }
        } else {
            if ( 1 == shopical_get_option('footer_show_instagram_post_carousel') ) {
                shopical_get_block('store-instagram', 'section');
            }
        }

        $mailchimp_scope = shopical_get_option('footer_mailchimp_subscriptions_scopes');
        if ($mailchimp_scope == 'front-page') {
            if (is_front_page() || is_home()) {
                if ( 1 == shopical_get_option('footer_show_mailchimp_subscriptions') ) {
                    shopical_get_block('store-mailchimp', 'section');
                }
            }
        } else {
            if ( 1 == shopical_get_option('footer_show_mailchimp_subscriptions') ) {
                shopical_get_block('store-mailchimp', 'section');
            }
        }


    }
endif;
add_action('shopical_action_full_width_upper_footer_section', 'shopical_full_width_upper_footer_section');