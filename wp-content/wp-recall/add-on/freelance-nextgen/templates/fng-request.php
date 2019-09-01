<div class="request-author">
    <div class="request-price"><?php echo $fng_request->request_price; ?> <?php echo rcl_get_primary_currency( 1 ); ?></div>
    <div class="avatar-box">
        <a href="<?php echo get_author_posts_url( $fng_request->author_id ); ?>">
			<?php echo get_avatar( $fng_request->author_id, 50 ); ?>
        </a>
    </div>
    <div class="author-meta">
        <span class="author-name">
            <a href="<?php echo get_author_posts_url( $fng_request->author_id ); ?>">
				<?php echo get_the_author_meta( 'display_name', $fng_request->author_id ); ?>
            </a>
        </span>
        <span class="request-time">[<?php echo mysql2date( 'd.m.Y H:i', $fng_request->request_date ) ?>]</span>
		<?php if ( $spec = get_user_meta( $fng_request->author_id, 'fng-specialization', 1 ) ): ?>
			<div class="author-type">Specialization: <?php echo get_term_field( 'name', $spec, 'task-subject' ); ?></div>
		<?php endif; ?>
    </div>
</div>
<div class="request-content">

	<?php do_action( 'fng_before_request_content', $fng_request ); ?>

	<?php echo wpautop( $fng_request->request_content ); ?>

	<?php do_action( 'fng_after_request_content', $fng_request ); ?>

	<?php echo fng_get_request_manager( $fng_request->request_id ); ?>
</div>
