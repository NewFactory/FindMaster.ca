<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package Shopical
 */

add_action('init', 'shopical_testimonial_init');
/**
 * Register a testimonial post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function shopical_testimonial_init()
{
    $labels = array(
        'name' => _x('Testimonials', 'post type general name', 'shopical'),
        'singular_name' => _x('Testimonial', 'post type singular name', 'shopical'),
        'menu_name' => _x('Testimonials', 'admin menu', 'shopical'),
        'name_admin_bar' => _x('Testimonial', 'add new on admin bar', 'shopical'),
        'add_new' => _x('Add New', 'testimonial', 'shopical'),
        'add_new_item' => __('Add New Testimonial', 'shopical'),
        'new_item' => __('New Testimonial', 'shopical'),
        'edit_item' => __('Edit Testimonial', 'shopical'),
        'view_item' => __('View Testimonial', 'shopical'),
        'all_items' => __('All Testimonials', 'shopical'),
        'search_items' => __('Search Testimonials', 'shopical'),
        'parent_item_colon' => __('Parent Testimonials:', 'shopical'),
        'not_found' => __('No testimonials found.', 'shopical'),
        'not_found_in_trash' => __('No testimonials found in Trash.', 'shopical')
    );

    $args = array(
        'labels' => $labels,
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        //'rewrite'            => array( 'slug' => 'testimonial' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-id-alt',
        'supports' => array('title', 'editor', 'thumbnail')
    );

    register_post_type('testimonial', $args);
}


add_action('add_meta_boxes', 'wpt_add_event_metaboxes');
/**
 * Adds a metabox to the right side of the screen under the â€œPublishâ€ box
 */
function wpt_add_event_metaboxes()
{
    add_meta_box(
        'wpt_events_location',
        'Personal Info',
        'wpt_events_location',
        'testimonial',
        'normal',
        'default'
    );
}

/**
 * Output the HTML for the metabox.
 */
function wpt_events_location()
{
    global $post;
    // Nonce field to validate form request came from current site
    wp_nonce_field(basename(__FILE__), 'testimonial_fields');
    // Get the location data if it's already been entered
    $testimonial_post = get_post_meta($post->ID, 'testimonial_post', true);
    $testimonial_website = get_post_meta($post->ID, 'testimonial_website', true);
    $testimonial_facebook = get_post_meta($post->ID, 'testimonial_facebook', true);
    $testimonial_twitter = get_post_meta($post->ID, 'testimonial_twitter', true);
    $testimonial_linkedin = get_post_meta($post->ID, 'testimonial_linkedin', true);


    // Output the field
    $output = '<label for="testimonial_post">' . esc_html__('Post/Designation', 'shopical') . '</label>';
    $output .= '<input type="text" name="testimonial_post" value="' . esc_textarea($testimonial_post) . '" class="widefat">';

    $output .= '<label for="testimonial_website">' . esc_html__('Website', 'shopical') . '</label>';
    $output .= '<input type="text" name="testimonial_website" value="' . esc_textarea($testimonial_website) . '" class="widefat">';

    $output .= '<label for="testimonial_facebook">' . esc_html__('Facebook', 'shopical') . '</label>';
    $output .= '<input type="text" name="testimonial_facebook" value="' . esc_textarea($testimonial_facebook) . '" class="widefat">';

    $output .= '<label for="testimonial_twitter">' . esc_html__('Twitter', 'shopical') . '</label>';
    $output .= '<input type="text" name="testimonial_twitter" value="' . esc_textarea($testimonial_twitter) . '" class="widefat">';

    $output .= '<label for="testimonial_linkedin">' . esc_html__('Linkedin', 'shopical') . '</label>';
    $output .= '<input type="text" name="testimonial_linkedin" value="' . esc_textarea($testimonial_linkedin) . '" class="widefat">';

    echo $output;
}

/**
 * Save the metabox data
 */
function wpt_save_events_meta($post_id, $post)
{
    // Return if the user doesn't have edit permissions.
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    // Verify this came from the our screen and with proper authorization,
    // because save_post can be triggered at other times.
    if (!isset($_POST['testimonial_fields']) || !wp_verify_nonce($_POST['testimonial_fields'], basename(__FILE__))) {
        return $post_id;
    }
    // Now that we're authenticated, time to save the data.
    // This sanitizes the data from the field and saves it into an array $events_meta.
    $testimonial_meta['testimonial_post'] = esc_textarea($_POST['testimonial_post']);
    $testimonial_meta['testimonial_website'] = esc_textarea($_POST['testimonial_website']);
    $testimonial_meta['testimonial_facebook'] = esc_textarea($_POST['testimonial_facebook']);
    $testimonial_meta['testimonial_twitter'] = esc_textarea($_POST['testimonial_twitter']);
    $testimonial_meta['testimonial_linkedin'] = esc_textarea($_POST['testimonial_linkedin']);

    // Cycle through the $events_meta array.
    // Note, in this example we just have one item, but this is helpful if you have multiple.
    foreach ($testimonial_meta as $key => $value) :
        // Don't store custom data twice
        if ('revision' === $post->post_type) {
            return;
        }
        if (get_post_meta($post_id, $key, false)) {
            // If the custom field already has a value, update it.
            update_post_meta($post_id, $key, $value);
        } else {
            // If the custom field doesn't have a value, add it.
            add_post_meta($post_id, $key, $value);
        }
        if (!$value) {
            // Delete the meta key if there's no value
            delete_post_meta($post_id, $key);
        }
    endforeach;
}

add_action('save_post', 'wpt_save_events_meta', 1, 2);


add_action('init', 'shopical_faq_init');
/**
 * Register a faq post type.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_post_type
 */
function shopical_faq_init()
{


    $labels = array(
        'name' => _x('FAQs', 'post type general name', 'shopical'),
        'singular_name' => _x('FAQ', 'post type singular name', 'shopical'),
        'menu_name' => _x('FAQs', 'admin menu', 'shopical'),
        'name_admin_bar' => _x('FAQ', 'add new on admin bar', 'shopical'),
        'add_new' => _x('Add New', 'faq', 'shopical'),
        'add_new_item' => __('Add New FAQ', 'shopical'),
        'new_item' => __('New FAQ', 'shopical'),
        'edit_item' => __('Edit FAQ', 'shopical'),
        'view_item' => __('View FAQ', 'shopical'),
        'all_items' => __('All FAQs', 'shopical'),
        'search_items' => __('Search FAQs', 'shopical'),
        'parent_item_colon' => __('Parent FAQs:', 'shopical'),
        'not_found' => __('No faqs found.', 'shopical'),
        'not_found_in_trash' => __('No faqs found in Trash.', 'shopical')
    );

    $args = array(
        'labels' => $labels,
        'description' => '',
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'query_var' => true,
        //'rewrite'            => array( 'slug' => 'faq' ),
        'capability_type' => 'post',
        'has_archive' => true,
        'hierarchical' => false,
        'menu_position' => null,
        'menu_icon' => 'dashicons-editor-ul',
        'supports' => array('title', 'editor', 'excerpt')
    );

    register_post_type('shopical_faq', $args);

    // Add new taxonomy, make it hierarchical (like categories)
    $labels = array(
        'name' => _x('Topics', 'taxonomy general name', 'shopical'),
        'singular_name' => _x('Topic', 'taxonomy singular name', 'shopical'),
        'search_items' => __('Search Topics', 'shopical'),
        'all_items' => __('All Topics', 'shopical'),
        'parent_item' => __('Parent Topic', 'shopical'),
        'parent_item_colon' => __('Parent Topic:', 'shopical'),
        'edit_item' => __('Edit Topic', 'shopical'),
        'update_item' => __('Update Topic', 'shopical'),
        'add_new_item' => __('Add New Topic', 'shopical'),
        'new_item_name' => __('New Topic Name', 'shopical'),
        'menu_name' => __('Topics', 'shopical'),
    );

    $args = array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        //'rewrite'           => array( 'slug' => 'topic' ),
    );


    register_taxonomy('shopical_topic', array('shopical_faq'), $args);
    register_taxonomy_for_object_type('shopical_topic', 'shopical_faq');


}

// Register Custom Taxonomy
function shopical_custom_taxonomy_brand()
{

    $labels = array(
        'name' => 'Brands',
        'singular_name' => 'Brand',
        'menu_name' => 'Brands',
        'all_items' => 'All Brands',
        'parent_item' => 'Parent Brand',
        'parent_item_colon' => 'Parent Brand:',
        'new_item_name' => 'New Brand Name',
        'add_new_item' => 'Add New Brand',
        'edit_item' => 'Edit Brand',
        'update_item' => 'Update Brand',
        'separate_items_with_commas' => 'Separate Brand with commas',
        'search_items' => 'Search Brands',
        'add_or_remove_items' => 'Add or remove Brands',
        'choose_from_most_used' => 'Choose from the most used Brands',
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
    );

    /**
     * Check if WooCommerce is active
     **/
    if (class_exists('WooCommerce')) {
        register_taxonomy('shopical_brand', 'product', $args);
        register_taxonomy_for_object_type('shopical_brand', 'product');
    }

}

add_action('init', 'shopical_custom_taxonomy_brand', 0);


if (class_exists('WooCommerce')) {
    /*Brand Taxonomy add form fields*/
    if (!function_exists('shopical_add_brand_fields')):
        function shopical_add_brand_fields()
        {
            ?>
            <div class="form-field term-thumbnail-wrap">
                <label><?php _e('Thumbnail', 'shopical'); ?></label>
                <div id="product_brand_thumbnail" style="float: left; margin-right: 10px;">
                    <img src="<?php echo esc_url(wc_placeholder_img_src()); ?>" width="60px" height="60px"/>
                </div>
                <div style="line-height: 60px;">
                    <input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id"/>
                    <button type="button"
                            class="upload_image_button button"><?php _e('Upload/Add image', 'shopical'); ?></button>
                    <button type="button"
                            class="remove_image_button button"><?php _e('Remove image', 'shopical'); ?></button>
                </div>
                <div class="clear"></div>
            </div>
            <?php
        }
    endif;
    add_action('shopical_brand_add_form_fields', 'shopical_add_brand_fields');

    /*Brand Taxonomy edit form fields*/
    if (!function_exists('shopical_edit_brand_fields')):
        function shopical_edit_brand_fields($term)
        {
            $thumbnail_id = absint(get_term_meta($term->term_id, 'thumbnail_id', true));
            if ($thumbnail_id) {
                $image = wp_get_attachment_thumb_url($thumbnail_id);
            } else {
                $image = wc_placeholder_img_src();
            }
            ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label><?php _e('Thumbnail', 'shopical'); ?></label></th>
                <td>
                    <div id="product_brand_thumbnail" style="float: left; margin-right: 10px;"><img
                                src="<?php echo esc_url($image); ?>" width="60px" height="60px"/></div>
                    <div style="line-height: 60px;">
                        <input type="hidden" id="product_brand_thumbnail_id" name="product_brand_thumbnail_id"
                               value="<?php echo $thumbnail_id; ?>"/>
                        <button type="button"
                                class="upload_image_button button"><?php _e('Upload/Add image', 'shopical'); ?></button>
                        <button type="button"
                                class="remove_image_button button"><?php _e('Remove image', 'shopical'); ?></button>
                    </div>
                    <div class="clear"></div>
                </td>
            </tr>
            <?php
        }
    endif;
    add_action('shopical_brand_edit_form_fields', 'shopical_edit_brand_fields', 10);

    /*Save Brand taxonomy fields*/
    if (!function_exists('shopical_save_brand_fields')):
        function shopical_save_brand_fields($term_id, $tt_id = '', $taxonomy = '')
        {
            if (isset($_POST['product_brand_thumbnail_id']) && 'shopical_brand' === $taxonomy) {
                update_term_meta($term_id, 'thumbnail_id', absint($_POST['product_brand_thumbnail_id']));
            }
        }
    endif;
    add_action('created_term', 'shopical_save_brand_fields', 10, 3);
    add_action('edit_term', 'shopical_save_brand_fields', 10, 3);

    /* Brand Image Js */
    if (!function_exists('shopical_admin_product_brand_js')):
        function shopical_admin_product_brand_js($hook)
        {
            if ($hook != 'edit-tags.php' && $hook != 'term.php') {
                return;
            }
            wp_enqueue_media();
            wp_enqueue_script('brand_tax_js', get_template_directory_uri() . '/assets/brands.js', '', '', true);
            wp_localize_script('brand_tax_js', 'seAdmin', array(
                'title' => __('Choose an image', 'shopical'),
                'btn_txt' => __('Use image', 'shopical'),
                'img' => esc_js(wc_placeholder_img_src()),
            ));
        }
    endif;
    add_action('admin_enqueue_scripts', 'shopical_admin_product_brand_js');

    /*Show brand image in admin column*/
    if (!function_exists('shopical_product_brand_column_head')):
        function shopical_product_brand_column_head($columns)
        {
            $new_columns = array();

            if (isset($columns['cb'])) {
                $new_columns['cb'] = $columns['cb'];
                unset($columns['cb']);
            }

            $new_columns['thumb'] = __('Image', 'shopical');

            return array_merge($new_columns, $columns);
        }
    endif;
    add_filter('manage_edit-shopical_brand_columns', 'shopical_product_brand_column_head');

    if (!function_exists('shopical_product_brand_column_body')):
        function shopical_product_brand_column_body($columns, $column, $id)
        {
            if ('thumb' == $column) {
                $thumbnail_id = get_term_meta($id, 'thumbnail_id', true);
                if ($thumbnail_id) {
                    $image = wp_get_attachment_thumb_url($thumbnail_id);
                } else {
                    $image = wc_placeholder_img_src();
                }
                $image = str_replace(' ', '%20', $image);
                $columns .= '<img src="' . esc_url($image) . '" alt="' . esc_attr__('Thumbnail', 'shopical') . '" class="wp-post-image" height="48" width="48" />';
            }
            return $columns;
        }
    endif;
    add_filter('manage_shopical_brand_custom_column', 'shopical_product_brand_column_body', 10, 3);

}