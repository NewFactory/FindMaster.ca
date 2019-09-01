<?php
/**
 * Block Section Latest Product.
 *
 * @package Shopical
 */
?>

<?php
$title = shopical_get_option('featured_product_section_title');
$title_note = shopical_get_option('featured_product_section_title_note');
$category = shopical_get_option('featured_product_categories');
$number = shopical_get_option('number_of_featured_product');
$featured_product = shopical_get_products($number, $category, 'featured');
?>

<?php if (!empty($title)): ?>
    <div class="section-head">
        <?php if (!empty($title)): ?>
            <h4 class="section-title">
                <?php shopical_widget_title_section($title, $title_note); ?>
            </h4>
        <?php endif; ?>

    </div>
<?php endif; ?>
<?php
$carousel_class = 'aft-carousel';
if(empty($title)){
    $carousel_class = 'aft-slider';

}
?>
<ul class="product-ul product-carousel owl-carousel owl-theme <?php echo esc_attr($carousel_class); ?>">
    <?php
    if ($featured_product->have_posts()) :
        while ($featured_product->have_posts()): $featured_product->the_post();

            ?>
            <li class="item">
                <?php shopical_get_block('default', 'product-loop'); ?>
            </li>
        <?php endwhile; ?>
    <?php endif; ?>
    <?php wp_reset_postdata(); ?>
</ul>