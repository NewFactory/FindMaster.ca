<?php
if (!class_exists('Shopical_Product_Grid')) :
    /**
     * Adds Shopical_Product_Grid widget.
     */
    class Shopical_Product_Grid extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-categorised-product-title', 'shopical-categorised-product-subtitle', 'shopical-categorised-product-title-note', 'shopical-number-of-items');
            $this->select_fields = array('shopical-select-category');

            $widget_ops = array(
                'classname' => 'shopical_categorised_product_widget grid-layout',
                'description' => __('Displays products from selected category in a grid.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_categorised_product', __('AFTS Product Grid', 'shopical'), $widget_ops);
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
            $title = apply_filters('widget_title', $instance['shopical-categorised-product-title'], $instance, $this->id_base);

            //$subtitle = isset($instance['shopical-categorised-product-subtitle']) ? $instance['shopical-categorised-product-subtitle'] : '';
            $title_note = isset($instance['shopical-categorised-product-title-note']) ? $instance['shopical-categorised-product-title-note'] : '';
            $category = isset($instance['shopical-select-category']) ? $instance['shopical-select-category'] : '0';
            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '10';

            // open the widget container
            echo $args['before_widget'];

            ?>

            <section class="products">
                <div class="container-wrapper">
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
                    <?php
                    $all_posts = shopical_get_products($number_of_items, $category);
                    ?>
                    <div class="product-section-wrapper section-body">
                        <div class="af-container-row">
                            <ul class="product-ul">
                                <?php
                                if ($all_posts->have_posts()) :
                                    while ($all_posts->have_posts()): $all_posts->the_post();

                                        ?>
                                        <li class="col-20 float-l pad btm-margi product-ful-wid"
                                            data-mh="grid-product-loop">
                                            <?php shopical_get_block('default', 'product-loop'); ?>
                                        </li>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                                <?php wp_reset_postdata(); ?>
                            </ul>
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

            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_text_input('shopical-categorised-product-title', __('Title', 'shopical'), __('Product Grid', 'shopical'));
                //echo parent::shopical_generate_text_input('shopical-categorised-product-subtitle', __('Subtitle', 'shopical'), __('Product Grid Subtitle', 'shopical'));
                echo parent::shopical_generate_text_input('shopical-categorised-product-title-note', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category', __('Select category', 'shopical'), $categories);
                echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '10', 'number');
            }


        }

    }
endif;