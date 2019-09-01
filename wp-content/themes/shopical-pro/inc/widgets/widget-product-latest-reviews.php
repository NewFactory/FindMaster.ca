<?php
if (!class_exists('Shopical_Product_Latest_Reviews')) :
    /**
     * Adds Shopical_Product_Latest_Reviews widget.
     */
    class Shopical_Product_Latest_Reviews extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array(
                'shopical-store-latest-reviews-title',
                'shopical-store-latest-reviews-title-note',
                'shopical-number-of-items'
            );

            $widget_ops = array(
                'classname' => 'shopical_product_latest_reviews_widget grid-layout',
                'description' => __('Displays store testimonial.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_product_latest_reviews', __('AFTS Product Latest Reviews', 'shopical'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['shopical-store-latest-reviews-title'], $instance, $this->id_base);
            $title_note = isset($instance['shopical-store-latest-reviews-title-note']) ? $instance['shopical-store-latest-reviews-title-note'] : '';

            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '5';


            global $comments, $comment;
            $comments = get_comments(
                array(
                    'number' => $number_of_items,
                    'status' => 'approve',
                    'post_status' => 'publish',
                    'post_type' => 'product',
                    'parent' => 0,
                )
            ); // WPCS: override ok.

            // open the widget container
            echo $args['before_widget'];
            if ($comments) :
                ?>
                <section class="product-latest-review">
                    <div class="container-wrapper">

                        <?php if (!empty($title)): ?>
                            <div class="section-head">
                                <?php if (!empty($title)): ?>
                                    <h4 class="widget-title section-title aft-center-align">
                                        <?php shopical_widget_title_section($title, $title_note); ?>
                                    </h4>
                                <?php endif; ?>


                            </div>
                        <?php endif; ?>

                        <div class="section-body">
                            <div class="latest-reviews-slider aft-slider owl-carousel owl-theme">
                                <?php
                                foreach ((array)$comments as $comment) :
                                    $product = wc_get_product($comment->comment_post_ID)
                                    ?>
                                    <div class="item">
                                        <div class="latest-reviews-single">

                                            <div class="aft-product-section aft-img-title-rev clearfix">

                                                <div class="product-image col-40 float-l pad">
                                                    <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                                        <?php echo $product->get_image(); ?>
                                                    </a>
                                                </div>

                                                <div class="product-title-wrapper col-60 float-l pad">


                                                    <h4 class="product-title">
                                                        <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                                            <?php echo $product->get_name(); ?>
                                                        </a>
                                                    </h4>
                                                    <?php //var_dump($product);
                                                    ?>
                                                    <span class="aft-view-product">
                                                        <a href="<?php echo esc_url($product->get_permalink()); ?>">
                                                            <?php _e('View Product', 'shopical'); ?>
                                                        </a>
                                                    </span>
                                                </div>


                                            </div>

                                            <div class="review-content col-1 pad">

                                                <?php
                                                echo wp_kses_post(wpautop($comment->comment_content));
                                                ?>
                                            </div>


                                            <div class="aft-product-section pad">
                                                <div class="reviewer pad clearfix">
                                                    <?php

                                                    $avatar_url = get_avatar_url($comment->comment_author_email);
                                                    if ($avatar_url):
                                                        ?>
                                                        <div class="reviewer-img data-bg data-bg-hover col-40 float-l pad"
                                                             data-background="<?php echo esc_url($avatar_url); ?>"></div>
                                                    <?php endif; ?>
                                                    <div class="reviewer-aft col-60 float-l pad">
                                                        <div class="rating">
                                                            <a href="<?php echo esc_url(get_comment_link($comment->comment_ID)); ?>">
                                                                <?php echo wc_get_rating_html(intval(get_comment_meta($comment->comment_ID, 'rating', true))); ?>
                                                            </a>
                                                        </div>
                                                        <h4>
                                                            <?php echo get_comment_author($comment->comment_ID); ?>
                                                        </h4>
                                                        <span class="comment-date">
                                                            <?php echo esc_html(get_comment_date(get_option('date_format'), $comment->comment_ID)); ?>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php
                                endforeach;
                                ?>
                            </div>
                        </div>


                    </div>
                </section>

            <?php
                //print_pre($all_posts);
            endif;

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
            $categories = shopical_get_terms();
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_text_input('shopical-store-latest-reviews-title', 'Title', 'Product Latest Reviews');
                echo parent::shopical_generate_text_input('shopical-store-latest-reviews-title-note', __('Title Note', 'shopical'), '');

                echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '5', 'number');


            }
        }
    }
endif;