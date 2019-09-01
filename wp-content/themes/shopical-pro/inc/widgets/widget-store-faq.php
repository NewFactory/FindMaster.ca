<?php
if (!class_exists('Shopical_Store_Faq')) :
    /**
     * Adds Shopical_Store_Faq widget.
     */
    class Shopical_Store_Faq extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-store-faq-title', 'shopical-store-faq-subtitle', 'shopical-number-of-items', 'shopical-contact-form-shortcode', 'shopical-contact-form-title');
            $this->select_fields = array('shopical-show-all-link', 'shopical-select-category');

            $widget_ops = array(
                'classname' => 'product_store_faq_widget',
                'description' => __('Displays frequently asked question lists from selected category.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('product_store_faq', __('AFTS Store FAQ', 'shopical'), $widget_ops);
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
            $title = apply_filters('widget_title', $instance['shopical-store-faq-title'], $instance, $this->id_base);
            //$subtitle = isset($instance['shopical-store-faq-subtitle']) ? $instance['shopical-store-faq-subtitle'] : '';
            $category = isset($instance['shopical-select-category']) ? $instance['shopical-select-category'] : '0';
            $view_all_link = isset($instance['shopical-show-all-link']) ? $instance['shopical-show-all-link'] : 'true';
            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '6';
            $contact_form_title = isset($instance['shopical-contact-form-title']) ? $instance['shopical-contact-form-title'] : '';
            $contact_form = isset($instance['shopical-contact-form-shortcode']) ? $instance['shopical-contact-form-shortcode'] : '';

            $col_class = 'col-1';
            // if(!empty($contact_form)){
            //     $col_class = 'col-60';
            // }

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="store-faq">
                <div class="container-wrapper side-bar-container">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <span class="header-after">
                                        <?php echo esc_html($title); ?>
                                    </span>
                                </h4>

                                <?php if ($view_all_link == 'true'): ?>
                                    <span class="aft-view-all">
                                        <a href="<?php echo get_post_type_archive_link('shopical_faq'); ?>"><?php echo _e('View All', 'shopical'); ?></a>
                                    </span>
                                <?php endif; ?>
                            <?php endif; ?>


                        </div>
                    <?php endif; ?>
                    <div class="section-body">
                        <div class="accordion-wrapper">

                            <div id="accordion-section" class="aft-accordion-section blog-wrapper ">

                                <?php
                                $all_posts = shopical_get_posts($number_of_items, $category, 'shopical_faq', 'shopical_topic');

                                if ($all_posts->have_posts()) :
                                    while ($all_posts->have_posts()) : $all_posts->the_post();

                                        global $post;

                                        ?>

                                        <h4><?php the_title(); ?></h4>
                                        <div class="">
                                                <div class="blog-details">
                                                    <div class="blog-categories">
                                                        <?php shopical_post_categories('&nbsp', 'shopical_topic'); ?>
                                                    </div>
                                                    <div class="blog-content">
                                                        <div>
                                                            <?php echo get_the_excerpt(); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>

                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </div>
                        </div>
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
            echo parent::shopical_generate_text_input('shopical-store-faq-title', __('Title', 'shopical'), __('Frequently Asked Questions', 'shopical'));
            if (isset($categories) && !empty($categories)) {
                echo parent::shopical_generate_select_options('shopical-select-category', __('Select category', 'shopical'), $categories);
            }
            echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '5', 'number');
            echo parent::shopical_generate_select_options('shopical-show-all-link', __('Show "View All" link', 'shopical'), $options);

            echo parent::shopical_generate_text_input('shopical-contact-form-title', __("Contact Form Title", 'shopical'), "Haven't found? Ask a new question!");
            //echo parent::shopical_generate_text_input('shopical-contact-form-shortcode', __('Contact Form Shortcode', 'shopical'), '');


        }
    }
endif;