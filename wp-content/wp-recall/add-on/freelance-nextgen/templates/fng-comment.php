<div class="request-comment">
    <div class="comment-meta">
        <span class="author-name">
            <a href="<?php echo get_author_posts_url($fng_comment->author_id); ?>">
                <?php echo get_the_author_meta('display_name', $fng_comment->author_id); ?>
            </a>
        </span>
        <span class="comment-time">[<?php echo mysql2date('d.m.Y H:i', $fng_comment->comment_date) ?>]</span>
    </div>
    <div class="comment-content"><?php echo wpautop($fng_comment->comment_content); ?></div>
</div>
