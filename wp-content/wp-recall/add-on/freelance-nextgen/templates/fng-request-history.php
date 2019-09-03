<div class="fng-task">
    <div class="task-title task-meta">
        <i class="rcli fa-folder-open" aria-hidden="true"></i> <?php _e('The task:'); ?> <a href="<?php echo get_the_permalink($fng_request->task_id); ?>"><?php echo get_the_title($fng_request->task_id); ?></a>
    </div>
    <div class="task-status task-meta"><?php _e('Status:'); ?> <?php echo fng_get_status_name(get_post_meta($fng_request->task_id, 'fng-status', 1)); ?></div>
</div>
<div class="request-content">
    [<?php echo mysql2date('d.m.Y H:i', $fng_request->request_date) ?>] <?php echo wpautop($fng_request->request_content); ?>
    <?php echo fng_get_request_manager($fng_request->request_id); ?>
</div>
