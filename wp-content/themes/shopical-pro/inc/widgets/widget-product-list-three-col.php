<?php
if (!class_exists('Shopical_Product_List_Three_Col')) :
    /**
     * Adds Shopical_Product_List_Three_Col widget.
     */
    class Shopical_Product_List_Three_Col extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array(
                'shopical-product-category-title-1',
                'shopical-product-category-title-2',
                'shopical-product-category-title-3',
                'shopical-product-category-title-note-1',
                'shopical-product-category-title-note-2',
                'shopical-product-category-title-note-3',
                'shopical-number-of-items-1',
                'shopical-number-of-items-2',
                'shopical-number-of-items-3',
            );
            $this->select_fields = array(

                'shopical-select-category-1',
                'shopical-select-category-2',
                'shopical-select-category-3',
                'shopical-show-category-thumb-1',
                'shopical-show-category-thumb-2',
                'shopical-show-category-thumb-3',
                'shopical-product-count-1',
                'shopical-product-count-2',
                'shopical-product-count-3',
                'shopical-product-onsale-count-1',
                'shopical-product-onsale-count-2',
                'shopical-product-onsale-count-3',
            );

            $widget_ops = array(
                'classname' => 'shopical_product_list_three_col_widget',
                'description' => __('Displays grid from selected categories.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_product_list_three_col', __('AFTS Product List Three Col', 'shopical'), $widget_ops);
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

            $title_1 = apply_filters('widget_title', $instance['shopical-product-category-title-1'], $instance, $this->id_base);
            $title_2 = apply_filters('widget_title', $instance['shopical-product-category-title-2'], $instance, $this->id_base);
            $title_3 = apply_filters('widget_title', $instance['shopical-product-category-title-3'], $instance, $this->id_base);

            $title_note_1 = isset($instance['shopical-product-category-title-note-1']) ? $instance['shopical-product-category-title-note-1'] : '';
            $title_note_2 = isset($instance['shopical-product-category-title-note-2']) ? $instance['shopical-product-category-title-note-2'] : '';
            $title_note_3 = isset($instance['shopical-product-category-title-note-3']) ? $instance['shopical-product-category-title-note-3'] : '';

            $category_1 = isset($instance['shopical-select-category-1']) ? $instance['shopical-select-category-1'] : '0';
            $category_2 = isset($instance['shopical-select-category-2']) ? $instance['shopical-select-category-2'] : '0';
            $category_3 = isset($instance['shopical-select-category-3']) ? $instance['shopical-select-category-3'] : '0';

            $number_of_items_1 = isset($instance['shopical-number-of-items-1']) ? $instance['shopical-number-of-items-1'] : '5';
            $number_of_items_2 = isset($instance['shopical-number-of-items-2']) ? $instance['shopical-number-of-items-2'] : '5';
            $number_of_items_3 = isset($instance['shopical-number-of-items-3']) ? $instance['shopical-number-of-items-3'] : '5';

            $category_thumb_1 = isset($instance['shopical-show-category-thumb-1']) ? $instance['shopical-show-category-thumb-1'] : 'true';
            $category_thumb_2 = isset($instance['shopical-show-category-thumb-2']) ? $instance['shopical-show-category-thumb-2'] : 'true';
            $category_thumb_3 = isset($instance['shopical-show-category-thumb-3']) ? $instance['shopical-show-category-thumb-3'] : 'true';

            $product_count_1 = isset($instance['shopical-product-count-1']) ? $instance['shopical-product-count-1'] : 'true';
            $product_count_2 = isset($instance['shopical-product-count-2']) ? $instance['shopical-product-count-2'] : 'true';
            $product_count_3 = isset($instance['shopical-product-count-3']) ? $instance['shopical-product-count-3'] : 'true';

            $onsale_product_count_1 = isset($instance['shopical-product-onsale-count-1']) ? $instance['shopical-product-onsale-count-1'] : 'true';
            $onsale_product_count_2 = isset($instance['shopical-product-onsale-count-2']) ? $instance['shopical-product-onsale-count-2'] : 'true';
            $onsale_product_count_3 = isset($instance['shopical-product-onsale-count-3']) ? $instance['shopical-product-onsale-count-3'] : 'true';




            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="categories">
                <div class="container-wrapper">
                        <div class="af-container-row clearfix">
                            <div class="col-3 float-l pad product-ful-wid">
                                <?php if (!empty($title_1)): ?>
                                    <div class="section-head">
                                        <?php if (!empty($title_1)): ?>
                                            <h4 class="widget-title section-title">
                                                <?php shopical_widget_title_section($title_1, $title_note_1); ?>
                                            </h4>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="sale-single-wrap section-body">
                                    <?php if ((absint($category_1) > 0) && ($category_thumb_1 == 'true')):

                                        ?>
                                    <div class="product-section-wrapper aft-product-list-mode aft-like-express">
                                        <div class="btm-margi product-ful-wid">
                                            <div class="sale-single-wrap af-slide--wrap">
                                                <?php shopical_product_category_loop($category_1, $product_count_1, $onsale_product_count_1); ?>
                                            </div>
                                        </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php shopical_get_product_list($number_of_items_1, $category_1); ?>
                                </div>
                            </div>
                            <div class="col-3 float-l pad product-ful-wid">
                                <?php if (!empty($title_2)): ?>
                                    <div class="section-head">
                                        <?php if (!empty($title_2)): ?>
                                            <h4 class="widget-title section-title">
                                                <?php shopical_widget_title_section($title_2, $title_note_2); ?>
                                            </h4>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="sale-single-wrap section-body">
                                    <?php if ((absint($category_2) > 0) && ($category_thumb_2 == 'true')): ?>
                                        <div class="product-section-wrapper aft-product-list-mode aft-like-express">
                                            <div class="btm-margi product-ful-wid">
                                                <div class="sale-single-wrap af-slide--wrap">
                                                    <?php shopical_product_category_loop($category_2, $product_count_2, $onsale_product_count_2); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                    <?php shopical_get_product_list($number_of_items_2, $category_2); ?>
                                </div>
                            </div>
                            <div class="col-3 float-l pad product-ful-wid">
                                <?php if (!empty($title_3)): ?>
                                    <div class="section-head">
                                        <?php if (!empty($title_3)): ?>
                                            <h4 class="widget-title section-title">
                                                <?php shopical_widget_title_section($title_3, $title_note_3); ?>
                                            </h4>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                                <div class="sale-single-wrap  section-body">
                                    <?php if ((absint($category_3) > 0) && ($category_thumb_3 == 'true')): ?>
                                        <div class="product-section-wrapper aft-product-list-mode aft-like-express">
                                            <div class="col-1 float-l btm-margi product-ful-wid">
                                                <div class="sale-single-wrap af-slide--wrap">
                                                    <?php shopical_product_category_loop($category_3, $product_count_3, $onsale_product_count_3); ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>

                                    <?php shopical_get_product_list($number_of_items_3, $category_3); ?>
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


            //print_pre($terms);
            $categories = shopical_get_terms('product_cat');
            $options = array(
                'true' => __('Yes', 'shopical'),
                'false' => __('No', 'shopical'),
            );


            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_section_title('shopical-product-category-section-1', 'Product List Section 1');
                echo parent::shopical_generate_text_input('shopical-product-category-title-1', __('Title', 'shopical'), 'Product List 1');
                echo parent::shopical_generate_text_input('shopical-product-category-title-note-1', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category-1', __('Select Category', 'shopical'), $categories);
                echo parent::shopical_generate_text_input('shopical-number-of-items-1', __('No. of Items', 'shopical'), '5', 'number');
                echo parent::shopical_generate_select_options('shopical-show-category-thumb-1', __('Show Category Thumb', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-count-1', __('Show Product Count', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-onsale-count-1', __('Show On Sale Product Count', 'shopical'), $options);

                echo parent::shopical_generate_section_title('shopical-product-category-section-2', 'Product List Section 2');
                echo parent::shopical_generate_text_input('shopical-product-category-title-2', __('Title', 'shopical'), 'Product List 2');
                echo parent::shopical_generate_text_input('shopical-product-category-title-note-2', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category-2', __('Select Category', 'shopical'), $categories);
                echo parent::shopical_generate_text_input('shopical-number-of-items-2', __('No. of Items', 'shopical'), '5', 'number');
                echo parent::shopical_generate_select_options('shopical-show-category-thumb-2', __('Show Category Thumb', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-count-2', __('Show Product Count', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-onsale-count-2', __('Show On Sale Product Count', 'shopical'), $options);

                echo parent::shopical_generate_section_title('shopical-product-category-section-3', 'Product List Section 3');
                echo parent::shopical_generate_text_input('shopical-product-category-title-3', __('Title', 'shopical'), 'Product List 3');
                echo parent::shopical_generate_text_input('shopical-product-category-title-note-3', __('Title Note', 'shopical'), '');
                echo parent::shopical_generate_select_options('shopical-select-category-3', __('Select Category', 'shopical'), $categories);
                echo parent::shopical_generate_text_input('shopical-number-of-items-3', __('No. of Items', 'shopical'), '5', 'number');
                echo parent::shopical_generate_select_options('shopical-show-category-thumb-3', __('Show Category Thumb', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-count-3', __('Show Product Count', 'shopical'), $options);
                echo parent::shopical_generate_select_options('shopical-product-onsale-count-3', __('Show On Sale Product Count', 'shopical'), $options);


            }

            //print_pre($terms);


        }

    }
endif;