<?php get_bloc_stage() ?>
<section class="entry-meta">
    <span class="entry-date">
        <?php if(!get_is_stage()): ?>
            <?php the_time(get_option('date_format')); ?>
        <?php endif; ?>
    </span>
</section>