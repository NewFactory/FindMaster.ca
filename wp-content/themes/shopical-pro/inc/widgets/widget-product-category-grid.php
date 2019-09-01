<?php
if (!class_exists('Shopical_Product_Category_Grid')) :
    /**
     * Adds Shopical_Product_Category_Grid widget.
     */
    class Shopical_Product_Category_Grid extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-product-category-title', 'shopical-product-category-subtitle', 'shopical-product-category-title-note');
            $this->select_fields = array(

                'shopical-select-category-1',
                'shopical-select-category-2',
                'shopical-select-category-3',
                'shopical-select-category-4',
                'shopical-select-category-5',
                'shopical-select-category-6',
                'shopical-product-onsale-count',
                'shopical-product-count'
            );

            $widget_ops = array(
                'classname' => 'shopical_product_category_grid_widget',
                'description' => __('Displays grid from selected categories.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_product_category_grid', __('AFTS Product Category Grid', 'shopical'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['shopical-product-category-title'], $instance, $this->id_base);
            $title_note = isset($instance['shopical-product-category-title-note']) ? $instance['shopical-product-category-title-note'] : '';
            $product_count = isset($instance['shopical-product-count']) ? $instance['shopical-product-count'] : 'true';
            $onsale_product_count = isset($instance['shopical-product-onsale-count']) ? $instance['shopical-product-onsale-count'] : 'true';

            $categories = array();
            for ($i = 1; $i <= 6; $i++) {
                if (isset($instance['shopical-select-category-' . $i]) && !empty($instance['shopical-select-category-' . $i])) {
                    $categories[] = isset($instance['shopical-select-category-' . $i]) ? $instance['shopical-select-category-' . $i] : '';
                }

            }

            $category_section_class = '';
            $number_of_grid = '0';
            if (isset($categories)) {
                $number_of_grid = count($categories);
                $category_section_class = 'aft-grid-group-' . $number_of_grid;
            }

            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="categories <?php echo esc_attr($category_section_class); ?>">
                <div class="container-wrapper">
                    <?php if (!empty($title)): ?>
                        <div class="section-head">
                            <?php if (!empty($title)): ?>
                                <h4 class="widget-title section-title">
                                    <?php shopical_widget_title_section($title, $title_note); ?>
                                </h4>
                            <?php endif; ?>


                        </div>
                    <?php endif; ?>
                    <div class="section-body clearfix">
                        <div class="af-container-row shopical_category_grid_wrap">

                            <?php if (isset($categories)):

                                $count = 1;

                                foreach ($categories as $category):

                                    $thumbnail = 'shopical-medium-center';
//                                if($number_of_grid == 5 && $count == 1){
//                                    $thumbnail = 'shopical-slider-full';
//                                }

                                    if (($number_of_grid == 4 && $count == 2) || $number_of_grid == 2 || $number_of_grid == 1) {
                                        $thumbnail = 'shopical-medium-slider';
                                    }

                                    ?>
                                    <div class="col-3 float-l pad btm-margi product-ful-wid">
                                        <div class="sale-single-wrap af-slide--wrap">
                                            <?php shopical_product_category_loop($category, $product_count, $onsale_product_count, $thumbnail); ?>
                                        </div>
                                    </div>
                                    <?php
                                    $count++;
                                endforeach;
                            endif; ?>
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


            //print_pre($terms);
            $categories = shopical_get_terms('product_cat');
            $options = array(
                'true' => __('Yes', 'shopical'),
                'false' => __('No', 'shopical'),
            );

            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_text_input('shopical-product-category-title', __('Title', 'shopical'), 'Product Categories Grid');
                // echo parent::shopical_generate_text_input('shopical-product-category-subtitle', __('Subtitle', 'shopical'), 'Product Categories Grid Subtitle');
                echo parent::shopical_generate_text_input('shopical-product-category-title-note', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category-1', __('Select category 1', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-select-category-2', __('Select category 2', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-select-category-3', __('Select category 3', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-select-category-4', __('Select category 4', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-select-category-5', __('Select category 5', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-select-category-6', __('Select category 6', 'shopical'), $categories);
                echo parent::shopical_generate_select_options('shopical-product-count', __('Show Product Count', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-onsale-count', __('Show On Sale Product Count', 'shopical'), $options);

            }

            //print_pre($terms);


        }

    }
endif;