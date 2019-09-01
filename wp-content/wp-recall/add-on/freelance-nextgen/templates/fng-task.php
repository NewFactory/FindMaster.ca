<div class="fng-task">
    <div class="task-title task-meta">
        <i class="rcli fa-folder-open" aria-hidden="true"></i> <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
    </div>
    <div class="task-date task-meta"><?php echo get_the_date(); ?></div>
    <div class="task-status task-meta"><?php echo fng_get_status_name(get_post_meta($post->ID, 'fng-status', 1)); ?></div>
</div>