<?php
if (!class_exists('Shopical_Social_Instagram')) :
    /**
     * Adds Shopical_Social_Instagram widget.
     */
    class Shopical_Social_Instagram extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-instagram-background-image', 'shopical-instagram-access-token', 'shopical-instagram-username', 'shopical-number-of-items');


            $widget_ops = array(
                'classname' => 'shopical_social_instagram_widget grid-layout',
                'description' => __('Displays latest posts from instagram.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_social_instagram', __('AFTS Instagram', 'shopical'), $widget_ops);
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


            $access_token = isset($instance['shopical-instagram-access-token']) ? $instance['shopical-instagram-access-token'] : '7510889272.577c420.c6d613a1e7d24499ae6432d8e2e6fe9f';
            $username = isset($instance['shopical-instagram-username']) ? $instance['shopical-instagram-username'] : '';
            $profile_link = "https://instagram.com/".trim($username);
            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '10';

            // open the widget container
            echo $args['before_widget'];


            if (!empty($username) && !empty($number_of_items)) {
                $media_array = shopical_scrape_instagram($username, $access_token, $number_of_items);

                if (is_wp_error($media_array)) {
                    echo wp_kses_post($media_array->get_error_message());
                } else {
                    ?>
                    <section class="instagram">

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
                            <div class="insta-feed-head">
                                <a href="<?php echo esc_url($profile_link); ?>" rel="me"
                                   class="secondary-font" target="_blank">
                                    <p class="instagram-username"><?php echo '/' . $username; ?></p>
                                </a>
                            </div>
                            <div class="insta-carousel aft-slider owl-carousel owl-theme">
                                <?php
                                foreach ($media_array as $item) { ?>

                                    <div class="item zoom-gallery">
                                        <a href="<?php echo esc_url($profile_link); ?>"
                                           title="<?php if (isset($item['description']['text']) && !empty($item['description']['text'])) {
                                               echo esc_html($item['description']['text']);
                                           } ?>" target="_blank"
                                           class="insta-hover">
                                            <figure>
                                                <img src="<?php echo esc_url($item['small']) ?>"/>
                                            </figure>
                                            <div class="insta-details">
                                                <div class="insta-icons">
                                                    <div class="insta-icons-comts-liks">
                                                        <p class="insta-likes"><i
                                                                    class="fa fa-heart"></i><?php echo esc_html($item['likes']); ?>
                                                        </p>
                                                        <p class="insta-comments"><i
                                                                    class="fa fa-comment"></i><?php echo esc_html($item['comments']); ?>
                                                        </p>
                                                    </div>

                                                </div>
                                                <?php if (isset($item['description']['text']) && !empty($item['description']['text'])): ?>
                                                    <p class="insta-desc"><?php echo esc_html(wp_trim_words($item['description']['text'], 3, '...')); ?></p>
                                                <?php endif; ?>
                                            </div>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                                    </div>

                    </section>
                    <?php
                }
            }
            ?>

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
            echo parent::shopical_generate_text_input('shopical-instagram-access-token', 'Access Token', '7510889272.577c420.c6d613a1e7d24499ae6432d8e2e6fe9f');
            echo parent::shopical_generate_text_input('shopical-instagram-username', 'username', 'wpafthemes');
            echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '10', 'number');


        }
    }
endif;