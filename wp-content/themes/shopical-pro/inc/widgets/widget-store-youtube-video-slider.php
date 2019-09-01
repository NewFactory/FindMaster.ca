<?php

/**
 * Adds Shopical_Youtube_Video_Slider widget.
 */
class Shopical_Youtube_Video_Slider extends AFthemes_Widget_Base
{
    /**
     * Sets up a new widget instance.
     *
     * @since 1.0.0
     */
    function __construct()
    {
        $this->text_fields = array(
            'shopical-youtube-video-slider-title',
            'shopical-youtube-video-slider-title-note',
        );

        $this->url_fields = array(
            'shopical-youtube-video-url-1',
            'shopical-youtube-video-url-2',
            'shopical-youtube-video-url-3',
            'shopical-youtube-video-url-4',
            'shopical-youtube-video-url-5',
            'shopical-youtube-video-url-5',

        );

        $this->select_fields = array('shopical-slide-thumbs');

        $widget_ops = array(
            'classname' => 'shopical_video_slider_widget aft-tertiary-background-color',
            'description' => __('Displays youtube video slider.', 'shopical'),
            'customize_selective_refresh' => true,
        );

        parent::__construct('shopical_video_slider', __('AFTS YouTube Video Slider', 'shopical'), $widget_ops);
    }

    /**
     * Outputs the content for the current widget instance.
     *
     * @since 1.0.0
     *
     * @param array $args Display arguments.
     * @param array $instance Saved values from database.
     */
    public function widget($args, $instance)
    {
        $instance = parent::shopical_sanitize_data($instance, $instance);
        $title = apply_filters('widget_title', $instance['shopical-youtube-video-slider-title'], $instance, $this->id_base);
        $title_note = isset($instance['shopical-youtube-video-slider-title-note']) ? $instance['shopical-youtube-video-slider-title-note'] : '';
        $show_thumbs = isset($instance['shopical-slide-thumbs']) ? $instance['shopical-slide-thumbs'] : 'true';


        $yt_video_url = array();

        for ($i = 1; $i <= 5; $i++) {
            if (isset($instance['shopical-youtube-video-url-' . $i]) && !empty($instance['shopical-youtube-video-url-' . $i])) {
                $yt_video_url['video_url_' . $i . ''] = isset($instance['shopical-youtube-video-url-' . $i]) ? $instance['shopical-youtube-video-url-' . $i] : '';

            }
        }


        echo $args['before_widget'];

        ?>

        <?php //if (!empty($mp_video_url = $instance['shopical-youtube-video-url-1'])):
        ?>
        <section class="aft-youtube-video">
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
                <ul class="aft-youtube-video-slider aft-slider owl-carousel owl-theme"
                    data-slider-id="<?php echo esc_attr($this->id); ?>">


                    <?php

                    if (isset($yt_video_url) && !empty($yt_video_url)) {

                        foreach ($yt_video_url as $video_url) {

                            $hd_full_url = shopical_youtube_thumbnail_url($video_url, 'maxresdefault');

                            ?>

                            <li class="item-video data-bg data-bg-hover"
                                data-background="<?php echo esc_url($hd_full_url); ?>">
                                <a class="owl-video" href="<?php echo esc_url($video_url); ?>"></a>
                            </li>
                        <?php }
                    }
                    ?>

                </ul>
                <?php if ($show_thumbs == 'true'): ?>
                    <div class="owl-thumbs" data-slider-id="<?php echo esc_attr($this->id); ?>">
                        <?php

                        if (isset($yt_video_url) && !empty($yt_video_url)) {

                            foreach ($yt_video_url as $video_thumb_url) {

                                $mq_thumb_url = shopical_youtube_thumbnail_url($video_thumb_url, 'mqdefault');

                                ?>
                                <span class="aft-thumbnail-wrapper data-bg data-bg-hover"
                                      data-background="<?php echo esc_url($mq_thumb_url); ?>"></span>
                            <?php }
                        }
                        ?>
                    </div>
                <?php endif; ?>
            </div>
            </div>
        </section>

        <?php //endif;
        ?>
        <?php
        echo $args['after_widget'];
    }

    /**
     * Back-end widget form.
     *
     * @since 1.0.0
     *
     * @param array $instance Previously saved values from database.
     *
     *
     */
    public function form($instance)
    {
        $this->form_instance = $instance;
        $options = array(
            'true' => __('Yes', 'shopical'),
            'false' => __('No', 'shopical'),
        );
        // generate the text input for the title of the widget. Note that the first parameter matches text_fields array entry
        echo parent::shopical_generate_text_input('shopical-youtube-video-slider-title', 'Title', 'YouTube Video Slider Title');
        echo parent::shopical_generate_text_input('shopical-youtube-video-slider-title-note', 'Title Note', 'YouTube Video Slider Title');

        echo parent::shopical_generate_text_input('shopical-youtube-video-url-1', 'YouTube URL 1', '');
        echo parent::shopical_generate_text_input('shopical-youtube-video-url-2', 'YouTube URL 2', '');
        echo parent::shopical_generate_text_input('shopical-youtube-video-url-3', 'YouTube URL 3', '');
        echo parent::shopical_generate_text_input('shopical-youtube-video-url-4', 'YouTube URL 4', '');
        echo parent::shopical_generate_text_input('shopical-youtube-video-url-5', 'YouTube URL 5', '');
        echo parent::shopical_generate_select_options('shopical-slide-thumbs', __('Show Slide Thumbnails', 'shopical'), $options);


    }

}