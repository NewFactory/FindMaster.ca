<?php
/**
 * Block Section Latest Product.
 *
 * @package Shopical
 */
?>

<?php

$title = shopical_get_option('onsale_product_section_title');
$title_note = shopical_get_option('onsale_product_section_title_note');
$category = shopical_get_option('onsale_product_categories');
$number = shopical_get_option('number_of_onsale_product');
$onsale_product = shopical_get_products($number, $category, 'onsale');


?>


<?php if (!empty($title)): ?>
    <div class="section-head">
        <?php if (!empty($title)): ?>
            <h4 class="section-title aft-center-align">
                <?php shopical_widget_title_section($title, $title_note); ?>
            </h4>
        <?php endif; ?>
        <?php if(!empty($category)): ?>
        <span class="aft-view-all">
                            <a href="<?php echo esc_url(get_term_link(absint($category))); ?>"><?php echo esc_html('View All', 'shopical'); ?></a>
                        </span>
        <?php endif; ?>

    </div>
<?php endif; ?>
<ul class="product-ul clearfix af-container-row">
    <?php
    if ($onsale_product->have_posts()) :
        while ($onsale_product->have_posts()): $onsale_product->the_post();

            ?>
            <li class="item col-3 float-l pad">
                <?php shopical_get_block('list', 'product-loop'); ?>
            </li>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</ul>