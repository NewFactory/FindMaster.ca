<?php
if (!class_exists('Shopical_Product_List_Express')) :
    /**
     * Adds Shopical_Product_List_Express widget.
     */
    class Shopical_Product_List_Express extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-product-express-category-title', 'shopical-product-express-category-subtitle', 'shopical-product-express-category-title-note', 'shopical-number-of-items');
            $this->select_fields = array('shopical-select-category', 'shopical-product-onsale-count', 'shopical-product-count');

            $widget_ops = array(
                'classname' => 'shopical_product_list_express_widget',
                'description' => __('Displays category details along with product from selected categories.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_product_list_express', __('AFTS Product List Express', 'shopical'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['shopical-product-express-category-title'], $instance, $this->id_base);
            //$subtitle = isset($instance['shopical-product-express-category-subtitle']) ? $instance['shopical-product-express-category-subtitle'] : '';
            $title_note = isset($instance['shopical-product-express-category-title-note']) ? $instance['shopical-product-express-category-title-note'] : '';
            $category = isset($instance['shopical-select-category']) ? $instance['shopical-select-category'] : '0';
            $product_count = isset($instance['shopical-product-count']) ? $instance['shopical-product-count'] : 'true';
            $onsale_product_count = isset($instance['shopical-product-onsale-count']) ? $instance['shopical-product-onsale-count'] : 'true';
            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '4';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="categories aft-product-list-mode">
                <div class="container-wrapper clearfix">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <?php shopical_widget_title_section($title, $title_note); ?>
                                </h4>
                            <?php endif; ?>

                            <?php if (absint($category) > 0):
                                $cat_link = get_term_link(absint($category));
                                ?>
                                <span class="aft-view-all">
                                 <a href="<?php echo esc_url($cat_link); ?>">
                                    <?php echo esc_html('View All', 'shopical'); ?>
                                 </a>
                                </span>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="section-body clearfix">
                    <div class="af-container-row clearfix">
                        <?php if (absint($category) > 0): ?>
                            <div class="col-3 float-l pad btm-margi product-ful-wid">
                                <div class="sale-single-wrap af-slide--wrap">
                                    <?php shopical_product_category_loop($category, $product_count, $onsale_product_count); ?>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php $all_posts = shopical_get_products($number_of_items, $category); ?>
                        <div class="product-section-wrapper">
                            <!-- <div class="row"> -->
                            <ul class="product-ul">
                                <?php
                                if ($all_posts->have_posts()) :
                                    while ($all_posts->have_posts()): $all_posts->the_post();

                                        ?>
                                        <li class="col-3 float-l pad" data-mh="express-product-loop">
                                            <?php shopical_get_block('list', 'product-loop'); ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
                            <!-- </div> -->
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

            $categories = shopical_get_terms('product_cat');
            $options = array(
                'true' => __('Yes', 'shopical'),
                'false' => __('No', 'shopical'),
            );

            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_text_input('shopical-product-express-category-title', __('Title', 'shopical'), 'Product Express Category');
                //echo parent::shopical_generate_text_input('shopical-product-express-category-subtitle', __('Subtitle', 'shopical'), 'Product Express Category Subtitle');
                echo parent::shopical_generate_text_input('shopical-product-express-category-title-note', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category', __('Select category', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-product-count', __('Show Product Count', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-onsale-count', __('Show On Sale Product Count', 'shopical'), $options);
                echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '4', 'number');


            }

            //print_pre($terms);


        }

    }
endif;