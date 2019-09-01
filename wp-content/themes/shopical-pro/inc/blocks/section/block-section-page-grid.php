<?php
/**
 * Block Section Latest Product.
 *
 * @package Shopical
 */
?>


<?php

$title = shopical_get_option('show_offer_pages_section_title');
$title_note = shopical_get_option('show_offer_pages_section_note');

$page_ids = array();
$show_title = array();
$button_text = array();
$button_link = array();
for ($i = 0; $i <= 3; $i++) {
    $slider_page = shopical_get_option('offer_page_' . $i);
    if (!empty($slider_page)) {
        $page_ids[] = $slider_page;
        $show_title[] = shopical_get_option('show_offer_pages_page_title_' . $i);
        $button_text[] = shopical_get_option('offer_pages_button_texts_' . $i);
        $button_link[] = shopical_get_option('offer_pages_link_' . $i);
    }
}
if ($page_ids):
    $all_posts = shopical_get_pages($page_ids);

    ?>
    <?php if ($all_posts->have_posts()): ?>
    <?php if (!empty($title)): ?>
        <div class="section-head">
            <?php if (!empty($title)): ?>
                <h4 class="section-title aft-center-align">
                    <?php shopical_widget_title_section($title, $title_note); ?>
                </h4>
            <?php endif; ?>

        </div>
    <?php endif; ?>
    <div class="bottom-grid-section clearfix af-container-row">
        <?php
        $count = 0;
        while ($all_posts->have_posts()): $all_posts->the_post(); ?>

            <div class="pad col-3 float-l">
            <div class="item-grid-item-single-wrap">
            <?php shopical_get_page_loop($show_title[$count], $button_text[$count], $button_link[$count]); ?>
            </div>
            </div>
        <?php
            $count++;
        endwhile;
        ?>
    </div>

<?php endif; ?>
    <?php wp_reset_postdata();
endif;
