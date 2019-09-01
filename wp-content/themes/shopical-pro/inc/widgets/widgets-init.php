<?php

// Load widget base.
require_once get_template_directory() . '/inc/widgets/widgets-base.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-register-sidebars.php';

/* Theme Widget sidebars. */
require get_template_directory() . '/inc/widgets/widgets-common-functions.php';

/* Theme Widgets*/
/**
 * Load WooCommerce compatibility file.
 */
if ( class_exists( 'WooCommerce' ) ) {
    require get_template_directory() . '/inc/widgets/widget-product-list.php';
    require get_template_directory() . '/inc/widgets/widget-product-list-three-col.php';
    require get_template_directory() . '/inc/widgets/widget-product-list-express.php';
    require get_template_directory() . '/inc/widgets/widget-product-grid.php';
    require get_template_directory() . '/inc/widgets/widget-product-carousel.php';
    require get_template_directory() . '/inc/widgets/widget-product-slider.php';
    require get_template_directory() . '/inc/widgets/widget-product-tabbed.php';
    require get_template_directory() . '/inc/widgets/widget-product-category-grid.php';
    require get_template_directory() . '/inc/widgets/widget-product-latest-reviews.php';
}


require get_template_directory() . '/inc/widgets/widget-posts-latest.php';
require get_template_directory() . '/inc/widgets/widget-posts-tabbed.php';
require get_template_directory() . '/inc/widgets/widget-store-author-info.php';
require get_template_directory() . '/inc/widgets/widget-store-call-to-action.php';
require get_template_directory() . '/inc/widgets/widget-store-features.php';
require get_template_directory() . '/inc/widgets/widget-store-offers.php';
require get_template_directory() . '/inc/widgets/widget-store-testimonial.php';
require get_template_directory() . '/inc/widgets/widget-store-brands.php';
require get_template_directory() . '/inc/widgets/widget-social-contacts.php';
require get_template_directory() . '/inc/widgets/widget-social-mailchimp.php';
require get_template_directory() . '/inc/widgets/widget-social-instagram.php';
require get_template_directory() . '/inc/widgets/widget-store-youtube-video-slider.php';
require get_template_directory() . '/inc/widgets/widget-store-faq.php';
require get_template_directory() . '/inc/widgets/widget-store-contact.php';



/* Register site widgets */
if ( ! function_exists( 'shopical_widgets' ) ) :
    /**
     * Load widgets.
     *
     * @since 1.0.0
     */
    function shopical_widgets() {

        /**
         * Load WooCommerce compatibility file.
         */
        if ( class_exists( 'WooCommerce' ) ) {
            register_widget( 'Shopical_Product_List' );
            register_widget( 'Shopical_Product_List_Three_Col' );
            register_widget( 'Shopical_Product_List_Express' );
            register_widget( 'Shopical_Product_Grid' );
            register_widget( 'Shopical_Product_Carousel' );
            register_widget( 'Shopical_Product_Slider' );
            register_widget( 'Shopical_Products_Tabbed' );
            register_widget( 'Shopical_Product_Category_Grid' );
            register_widget( 'Shopical_Product_Latest_Reviews' );
        }


        register_widget( 'Shopical_Posts_Latest' );
        register_widget( 'Shopical_Tabbed_Posts' );
        register_widget( 'Shopical_Store_Author_Info' );
        register_widget( 'Shopical_Store_Call_to_Action' );
        register_widget( 'Shopical_Store_Features' );
        register_widget( 'Shopical_Store_Offers' );
        register_widget( 'Shopical_Store_Testimonial' );
        register_widget( 'Shopical_Store_Brands' );
        register_widget( 'Shopical_Social_Contacts' );
        register_widget( 'Shopical_Social_MailChimp' );
        register_widget( 'Shopical_Social_Instagram' );
        register_widget( 'Shopical_Youtube_Video_Slider' );
        register_widget( 'Shopical_Store_Faq' );
        register_widget( 'Shopical_Store_Contact' );

    }
endif;
add_action( 'widgets_init', 'shopical_widgets' );
