<?php
/**
 * Block Section Main Banner.
 *
 * @package Shopical
 */
?>


<div class="section-body banner-slider-4 clearfix af-container-row">


    <?php
    $show_main_banner_section = shopical_get_option('show_main_banner_section');
    if ($show_main_banner_section):
        ?>
        <div class="banner-slider banner-slider-section col-1 float-l pad">
            <?php
            $slider_mode = shopical_get_option('select_main_slider_section_mode');
            if ($slider_mode == 'product-slider'):
                ?>
                <?php shopical_get_block('slider-product'); ?>
            <?php else: ?>
                <?php shopical_get_block('slider-page'); ?>
            <?php endif; ?>
        </div>
    <?php endif; ?>
    <div class="right-list-section col-1 float-l pad">
        <?php shopical_get_block('horizontal',  'category-list'); ?>
    </div>

    <div class="left-grid-section-wrapper clearfix">
        <?php shopical_get_block('horizontal', 'page-thumb-slider'); ?>
    </div>



</div>



