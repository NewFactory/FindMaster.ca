<?php
if (!class_exists('Shopical_Social_MailChimp')) :
    /**
     * Adds Shopical_Social_MailChimp widget.
     */
    class Shopical_Social_MailChimp extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-social-mailchimp', 'shopical-social-mailchimp-subtitle', 'shopical-social-mailchimp-shortcode');
            $widget_ops = array(
                'classname' => 'shopical_social_mailchimp_widget grid-layout',
                'description' => __('Displays newsletter subscriptions from MailChimp Shortcode.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_social_mailchimp', __('AFTS MailChimp Subscriptions', 'shopical'), $widget_ops);
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
            /** This filter is documented in wp-includes/default-widgets.php */

            $title = apply_filters('widget_title', $instance['shopical-social-mailchimp'], $instance, $this->id_base);
            $subtitle = isset($instance['shopical-social-mailchimp-subtitle']) ? $instance['shopical-social-mailchimp-subtitle'] : '';
            $form_shortcode = isset($instance['shopical-social-mailchimp-shortcode']) ? $instance['shopical-social-mailchimp-shortcode'] : '';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="social-mailchimp">
                <div class="container-wrapper">
                    <div class="inner-call-to-action">
                        <div class="mail-wrappper">
                            <?php if (!empty($title)): ?>
                                <div class="section-head">
                                    <?php if (!empty($title)): ?>
                                        <h4 class="widget-title section-title whit-col">
                                <span class="header-after">
                                    <?php echo esc_html($title); ?>
                                </span>
                                        </h4>
                                    <?php endif; ?>

                                    <?php if (!empty($subtitle)): ?>
                                        <span class="section-subtitle">
                                <?php echo esc_html($subtitle); ?>
                            </span>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                            <div class="suscribe">
                                <div class="inner-suscribe">
                                    <span class="desc"><p><?php echo do_shortcode($form_shortcode); ?></p></span>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <?php
            //print_pre($all_posts);

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


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
            echo parent::shopical_generate_text_input('shopical-social-mailchimp', 'Title', 'MailChimp Subscription');
            echo parent::shopical_generate_text_input('shopical-social-mailchimp-subtitle', 'Subtitle', 'Magna aspernatur eget potenti molestias beatae!');
            echo parent::shopical_generate_text_input('shopical-social-mailchimp-shortcode', 'Shortcode', '');


        }
    }
endif;