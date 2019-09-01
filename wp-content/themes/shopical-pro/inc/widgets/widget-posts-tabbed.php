<?php
if (!class_exists('Shopical_Tabbed_Posts')) :
    /**
     * Adds Shopical_Tabbed_Posts widget.
     */
    class Shopical_Tabbed_Posts extends AFthemes_Widget_Base
    {
        /**
         * Sets up a new widget instance.
         *
         * @since 1.0.0
         */
        function __construct()
        {
            $this->text_fields = array('shopical-tabbed-popular-posts-title', 'shopical-tabbed-latest-posts-title', 'shopical-tabbed-categorised-posts-title');

            $this->select_fields = array('shopical-show-excerpt', 'shopical-enable-categorised-tab', 'shopical-select-category');

            $widget_ops = array(
                'classname' => 'shopical_tabbed_posts_widget',
                'description' => __('Displays tabbed posts lists from selected settings.', 'shopical'),
                'customize_selective_refresh' => true,
            );

            parent::__construct('shopical_tabbed_posts', __('AFTS Tabbed Posts', 'shopical'), $widget_ops);
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
            $tab_id = 'tabbed-' . $this->number;


            /** This filter is documented in wp-includes/default-widgets.php */

            $show_excerpt = isset($instance['shopical-show-excerpt']) ? $instance['shopical-show-excerpt'] : 'false';
            $excerpt_length = '25';
            $number_of_posts = '5';

            $popular_title = isset($instance['shopical-tabbed-popular-posts-title']) ? $instance['shopical-tabbed-popular-posts-title'] : __('Shopical Popular', 'shopical');
            $latest_title = isset($instance['shopical-tabbed-latest-posts-title']) ? $instance['shopical-tabbed-latest-posts-title'] : __('Shopical Latest', 'shopical');

            $enable_categorised_tab = isset($instance['shopical-enable-categorised-tab']) ? $instance['shopical-enable-categorised-tab'] : 'true';
            $categorised_title = isset($instance['shopical-tabbed-categorised-posts-title']) ? $instance['shopical-tabbed-categorised-posts-title'] : __('Trending', 'shopical');
            $category = isset($instance['shopical-select-category']) ? $instance['shopical-select-category'] : '0';


            // open the widget container
            echo $args['before_widget'];
            ?>
            <div class="container-wrapper">
            <div class="tabbed-container">
                <div class="tabbed-head">
                    <ul class="nav nav-tabs af-tabs tab-warpper" role="tablist">
                        <li class="tab tab-recent active">
                            <a href="#<?php echo esc_attr($tab_id); ?>-recent"
                               aria-controls="<?php esc_attr_e('Recent', 'shopical'); ?>" role="tab"
                               data-toggle="tab" class="font-family-1">
                                <?php echo esc_html($latest_title); ?>
                            </a>
                        </li>
                        <li role="presentation" class="tab tab-popular">
                            <a href="#<?php echo esc_attr($tab_id); ?>-popular"
                               aria-controls="<?php esc_attr_e('Popular', 'shopical'); ?>" role="tab"
                               data-toggle="tab" class="font-family-1">
                                <?php echo esc_html($popular_title); ?>
                            </a>
                        </li>

                        <?php if ($enable_categorised_tab == 'true'): ?>
                            <li class="tab tab-categorised">
                                <a href="#<?php echo esc_attr($tab_id); ?>-categorised"
                                   aria-controls="<?php esc_attr_e('Categorised', 'shopical'); ?>" role="tab"
                                   data-toggle="tab" class="font-family-1">
                                    <?php echo esc_html($categorised_title); ?>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <div class="tab-content">
                    <div id="<?php echo esc_attr($tab_id); ?>-recent" role="tabpanel" class="tab-pane active">
                        <?php
                        shopical_render_posts('recent', $show_excerpt, $excerpt_length, $number_of_posts);
                        ?>
                    </div>
                    <div id="<?php echo esc_attr($tab_id); ?>-popular" role="tabpanel" class="tab-pane">
                        <?php
                        shopical_render_posts('popular', $show_excerpt, $excerpt_length, $number_of_posts);
                        ?>
                    </div>
                    <?php if ($enable_categorised_tab == 'true'): ?>
                        <div id="<?php echo esc_attr($tab_id); ?>-categorised" role="tabpanel" class="tab-pane">
                            <?php
                            shopical_render_posts('categorised', $show_excerpt, $excerpt_length, $number_of_posts, $category);
                            ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            </div>
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

            $enable_categorised_tab = array(
                'true' => __('Yes', 'shopical'),
                'false' => __('No', 'shopical')

            );

            $options = array(
                'false' => __('No', 'shopical'),
                'true' => __('Yes', 'shopical')

            );


            // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry

            ?><h4><?php _e('Latest Posts', 'shopical'); ?></h4><?php
            echo parent::shopical_generate_text_input('shopical-tabbed-latest-posts-title', __('Title', 'shopical'), __('Latest', 'shopical')); ?>

            <h4><?php _e('Popular Posts', 'shopical'); ?></h4><?php
            echo parent::shopical_generate_text_input('shopical-tabbed-popular-posts-title', __('Title', 'shopical'), __('Popular', 'shopical'));



            $categories = shopical_get_terms();
            if (isset($categories) && !empty($categories)) {
                ?><h4><?php _e('Categorised Posts', 'shopical'); ?></h4>
                <?php
                echo parent::shopical_generate_select_options('shopical-enable-categorised-tab', __('Enable Categorised Tab', 'shopical'), $enable_categorised_tab);
                echo parent::shopical_generate_text_input('shopical-tabbed-categorised-posts-title', __('Title', 'shopical'), __('Trending', 'shopical'));
                echo parent::shopical_generate_select_options('shopical-select-category', __('Select category', 'shopical'), $categories);

            }
            ?><h4><?php _e('Settings for all tabs', 'shopical'); ?></h4><?php
            echo parent::shopical_generate_select_options('shopical-show-excerpt', __('Show excerpt', 'shopical'), $options);


        }
    }
endif;