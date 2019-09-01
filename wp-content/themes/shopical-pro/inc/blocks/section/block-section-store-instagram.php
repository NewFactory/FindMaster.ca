<?php
$enable_instagram = shopical_get_option('footer_show_instagram_post_carousel');
if ($enable_instagram) {
    $username = esc_attr(shopical_get_option('instagram_username'));
    $profile_link = "https://instagram.com/".trim($username);
    $number = absint(shopical_get_option('number_of_instagram_posts'));
    $access_token = esc_attr(shopical_get_option('instagram_access_token'));

    if (!empty($username) && !empty($number)) {
        $media_array = shopical_scrape_instagram($username, $access_token, $number);

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
                        <?php if (!empty($subtitle)): ?>
                            <span class="section-subtitle">
                                    <?php echo esc_html($subtitle); ?>
                                </span>
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
}
