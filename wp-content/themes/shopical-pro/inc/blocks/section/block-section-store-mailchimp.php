<?php
/**
 * Block Contact.
 *
 * @package Shopical
 */

$title = shopical_get_option('footer_mailchimp_title');
$subtitle = shopical_get_option('footer_mailchimp_subtitle');
$form_shortcode = shopical_get_option('footer_mailchimp_shortcode');


?>
<section class="social-mailchimp">
    <div class="container-wrapper">
        <div class="inner-call-to-action">
            <div class="mail-wrappper">
                <?php if (!empty($title)): ?>
                    <div class="section-head">
                        <?php if (!empty($title)): ?>
                            <h4 class="widget-title section-title whit-col">
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
                <div class="suscribe">
                    <div class="inner-suscribe">
                        <span class="desc"><p><?php echo do_shortcode($form_shortcode); ?></p></span>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

