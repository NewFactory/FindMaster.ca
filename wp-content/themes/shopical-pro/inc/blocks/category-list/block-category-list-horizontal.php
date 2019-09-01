<?php
/**
 * Block Categories Carousel Vertical.
 *
 * @package Shopical
 */
?>
<div class="category-list-horizontal">
    <div class="af-container-row">
    	<div class="category-list-horizontal-flex category-list-horizontal-carousel aft-slider product-carousel owl-carousel owl-theme">
        	<?php

            $product_count = shopical_get_option('show_top_categories_product_count');
            $onsale_product_count = shopical_get_option('show_top_categories_product_onsale_count');
            echo shopical_list_categories_extended(0, $product_count, $onsale_product_count);

            ?>
    	</div>
    </div>
</div>