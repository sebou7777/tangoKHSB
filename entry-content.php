<section class="wp-content content list">
    <?php
    if(get_is_stage()) {
        get_template_part('entry', 'stage');
    } else {
        the_content();
    }
    ?>
</section>