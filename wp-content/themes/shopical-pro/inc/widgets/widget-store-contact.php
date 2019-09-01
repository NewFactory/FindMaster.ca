<?php
if (!class_exists('Shopical_Store_Contact')) :
    /**
     * Adds Shopical_Store_Contact widget.
     */
    class Shopical_Store_Contact extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-store-contact-title', 'shopical-store-contact-background-image', 'shopical-contact-form-title');

            $this->select_fields = array('shopical-social-contacts-menu');

            $widget_ops = array(
                'classname' => 'product_store_contact_widget',
                'description' => __('Displays shop contact details.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('product_store_contact', __('AFTS Store Contact', 'shopical'), $widget_ops);
        }

        /**
         * Front-end display of widget.
         *
         * @see WP_Widget::widget()
         *
         * @param array $args Widget arguments.
         * @param array $instance Saved values from database.
         */

        public function widget($args, $instance)
        {
            $instance = parent::shopical_sanitize_data($instance, $instance);
            $title = apply_filters('widget_title', $instance['shopical-store-contact-title'], $instance, $this->id_base);

            $show_social_menu = isset($instance['shopical-social-contacts-menu']) ? $instance['shopical-social-contacts-menu'] : 'true';
            $contact_form_title = isset($instance['shopical-contact-form-title']) ? $instance['shopical-contact-form-title'] : '';
            $background_image = isset($instance['shopical-store-contact-background-image']) ? $instance['shopical-store-contact-background-image'] : '';

            if ($background_image) {
                $image_attributes = wp_get_attachment_image_src($background_image, 'full');
                $image_src = $image_attributes[0];
                $image_class = 'data-bg data-bg-hover';

            } else {
                $image_src = '';
                $image_class = 'no-bg';
            }


            /**
             * Block Contact.
             *
             * @package Shopical
             */

            $store_contact_name = shopical_get_option('store_contact_name');
            $store_contact_address = shopical_get_option('store_contact_address');
            $store_contact_phone = shopical_get_option('store_contact_phone');
            $store_contact_email = shopical_get_option('store_contact_email');
            $store_contact_hours = shopical_get_option('store_contact_hours');
            $store_contact_website = shopical_get_option('store_contact_website');
            $store_contact_other_informations = shopical_get_option('store_contact_other_informations');
            $store_contact_map = shopical_get_option('store_contact_map');
            $store_contact_form_shortcode = shopical_get_option('store_contact_form');


            $col_class = 'col-1';
            if (!empty($contact_form)) {
                $col_class = 'col-60';
            }

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="store-contact <?php echo esc_attr($image_class); ?>"
                     data-background="<?php echo esc_url($image_src); ?>">
                <div class="container-wrapper side-bar-container">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <span class="header-after">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                </h4>


                            <?php endif; ?>


                        </div>
                    <?php endif; ?>
                    <div class="section-body">


                        <section class="contact-details-wrapper">
                            <div class="af-container-row-15 af-flex-sec clearfix">

                                <div class="contact-form col-40 float-l pad-15">
                                    <?php if (!empty($store_contact_form_shortcode)): ?>
                                        <h5><?php echo esc_html($contact_form_title); ?></h5>
                                        <span>
                                            <?php echo do_shortcode($store_contact_form_shortcode); ?>
                                        </span>
                                    <?php endif; ?>
                                </div>
                                <?php
                                $field_title_class = 'aft-show-field-icon';
                                if (empty($store_contact_map)) {
                                    $field_title_class = 'aft-show-field-title';
                                }

                                ?>
                                <div class="contact-details col-60 float-l pad-15">

                                    <?php if (!empty($store_contact_map)): ?>
                                        <?php echo do_shortcode($store_contact_map); ?>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_name)): ?>
                                        <h3>
                                            <?php echo esc_html($store_contact_name); ?>
                                        </h3>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_address)): ?>
                                        <span class="<?php echo esc_attr($field_title_class); ?>">
                                            <h4><?php _e('Address', 'shopical'); ?></h4>
                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <?php echo esc_html($store_contact_address); ?>
                                </span>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_phone)): ?>
                                        <span class="<?php echo esc_attr($field_title_class); ?>">
                                            <h4><?php _e('Phone', 'shopical'); ?></h4>
                                    <i class="fa fa-phone-square" aria-hidden="true"></i>
                                    <a href="#"><?php echo esc_html($store_contact_phone); ?></a>
                                </span>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_email)): ?>
                                        <span class="<?php echo esc_attr($field_title_class); ?>">
                                            <h4><?php _e('Email', 'shopical'); ?></h4>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <a href="#"><?php echo esc_html($store_contact_email); ?></a>
                                </span>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_hours)): ?>
                                        <span class="<?php echo esc_attr($field_title_class); ?>">
                                            <h4><?php _e('Opening Hours', 'shopical'); ?></h4>
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <?php echo esc_html($store_contact_hours); ?>
                                </span>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_website)): ?>
                                        <span class="<?php echo esc_attr($field_title_class); ?>">
                                            <h4><?php _e('Website', 'shopical'); ?></h4>
                                    <i class="fa fa-globe" aria-hidden="true"></i>
                                    <a href="<?php echo esc_url($store_contact_website); ?>"><?php echo esc_html($store_contact_website); ?></a>
                                </span>
                                    <?php endif; ?>

                                    <?php if (!empty($store_contact_other_informations)): ?>
                                        <span>
                                    <?php echo $store_contact_other_informations; ?>
                                </span>
                                    <?php endif; ?>

                                    <?php

                                    if ($show_social_menu == 'true'): ?>
                                        <span>
                                            <h4><?php _e('Find Us', 'shopical'); ?></h4>
                                            <?php
                                            wp_nav_menu(array(
                                                'theme_location' => 'aft-social-nav',
                                                'link_before' => '<span class="screen-reader-text">',
                                                'link_after' => '</span>',
                                                'menu_id' => 'social-menu',
                                                'container' => 'div',
                                                'container_class' => 'social-navigation'
                                            ));
                                            ?>
                                </span>
                                    <?php endif; ?>

                                </div>

                            </div>
                        </section>


                    </div>
                </div>
            </section>
            <?php
            // close the widget container
            echo $args['after_widget'];
        }

        /**
         * Back-end widget form.
         *
         * @see WP_Widget::form()
         *
         * @param array $instance Previously saved values from database.
         */
        public function form($instance)
        {
            $this->form_instance = $instance;

            $options = array(
                'true' => __('Yes', 'shopical'),
                'false' => __('No', 'shopical'),

            );
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry

            $categories = shopical_get_terms('shopical_topic');
            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::shopical_generate_section_note('shopical-store-contact-section-note', __('Contact information will be auto-fetched from Customize->Theme Options->Contact Options', 'shopical'));
            echo parent::shopical_generate_text_input('shopical-store-contact-title', __('Title', 'shopical'), __('Contact Us', 'shopical'));
            echo parent::shopical_generate_image_upload('shopical-store-contact-background-image', __('Background Image', 'shopical'), __('Background Image', 'shopical'));
            echo parent::shopical_generate_text_input('shopical-contact-form-title', __("Contact Form Title", 'shopical'), "How can we help?");
            echo parent::shopical_generate_select_options('shopical-social-contacts-menu', __('Show Social Contact Menu', 'shopical'), $options);


        }
    }
endif;