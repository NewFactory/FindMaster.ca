<?php
if (!class_exists('Shopical_Store_Brands')) :
    /**
     * Adds Shopical_Store_Brands widget.
     */
    class Shopical_Store_Brands extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array(
                'shopical-store-brands-title',
                'shopical-store-brands-title-note',
                'shopical-number-of-items'
            );

            $widget_ops = array(
                'classname' => 'shopical_store_brands_widget grid-layout',
                'description' => __('Displays store brands.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_store_brands', __('AFTS Store Brands', 'shopical'), $widget_ops);
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

            $title = apply_filters('widget_title', $instance['shopical-store-brands-title'], $instance, $this->id_base);
            $title = isset($title) ? $title : __('Store Brands', 'shopical');
            $title_note = isset($instance['shopical-store-brands-title-note']) ? $instance['shopical-store-brands-title-note'] : '';
            $number_of_items = isset($instance['shopical-number-of-items']) ? $instance['shopical-number-of-items'] : '5';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <section class="brands-slider">
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
                </div>
                <div class="container-wrapper-full">

                    <?php
                    $terms = get_terms(array(
                        'taxonomy' => 'shopical_brand',
                        'hide_empty' => false,
                        'number' => $number_of_items,
                    ));

                    ?>
                    <div class="section-body">
                    <div class="brand-carousel aft-carousel owl-carousel owl-theme">
                        <?php
                        if (isset($terms)) :
                            foreach ($terms as $term):

                                $term_name = $term->name;
                                $term_link = get_term_link($term);
                                $meta = get_term_meta($term->term_id);

                                if (isset($meta['thumbnail_id'])) {
                                    $thumb_id = $meta['thumbnail_id'][0];
                                    $thumb_url = wp_get_attachment_image_src($thumb_id, 'full');
                                    $url = $thumb_url[0];
                                } else {
                                    $url = '';
                                }

                                ?>
                                <div class="item">
                                    <a href="<?php echo esc_attr($term_link); ?>">
                                        <img src="<?php echo esc_attr($url); ?>"
                                             title="<?php echo esc_attr($term_name); ?>">
                                    </a>
                                </div>
                            <?php
                            endforeach;
                        endif;

                        ?>
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
            $categories = shopical_get_terms('shopical_brand');
            if (isset($categories) && !empty($categories)) {
                // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
                echo parent::shopical_generate_text_input('shopical-store-brands-title', 'Title', 'Store Brands');
                echo parent::shopical_generate_text_input('shopical-store-brands-title-note', 'Title Note', '');
                echo parent::shopical_generate_text_input('shopical-number-of-items', __('No. of Items', 'shopical'), '5', 'number');


            }
        }
    }
endif;