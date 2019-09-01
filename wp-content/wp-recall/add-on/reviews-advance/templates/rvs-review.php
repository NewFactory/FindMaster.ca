<div class="review-avatar">
    <a href="<?php echo get_author_posts_url($review->user_id); ?>">
        <?php echo get_avatar($review->user_id, 115); ?>
    </a>
</div>
<div class="review-content">
    <div class="review-date">
        <?php echo mysql2date('d.m.Y H:i', $review->review_date); ?>
    </div>
    <div class="review-name">
        <a href="<?php echo get_author_posts_url($review->user_id); ?>">
            <?php echo get_the_author_meta('display_name', $review->user_id); ?>
        </a>
    </div>
    <div class="review-content">
        <?php echo wpautop($review->review_content); ?>
    </div>
    <div class="review-rating">
        <?php echo $rating_box; ?>
    </div>
</div>
<div class="clear"></div>