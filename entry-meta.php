<section class="entry-meta">
    <?php get_bloc_stage() ?>
<span class="entry-date">
    <?php
        if(get_is_stage()) {
            $infos = get_bloc_stage();
//            echo $infos['datetime_format'];
        } else {
            the_time( get_option( 'date_format' ) );
        }
    ?>
</span>
</section>