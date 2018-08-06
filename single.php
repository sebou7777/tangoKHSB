<?php get_header(); ?>
<section id="content" class="content container">
    <div class="columns">
        <div class="column is-9">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'entry' ); ?>
            <?php endwhile; endif; ?>
<!--            <div class="written_date">Rédigé le --><?php //the_time(get_option('date_format')); ?><!--</div>-->
            <div class="level">
                <?php list($prev, $next) = get_pagination(); ?>
                <div class="level-left">
                    <?php if($prev): ?>
                        <a href="<?php echo $prev->post_url ?>" title="<?php echo $prev->post_title ?>"><?php echo $prev->post_title ?><span class="icon">
                            <i class="fas fa-arrow-circle-left"></i>
                        </span></a>
                    <?php endif; ?>
                </div>
                <div class="level-right">
                    <?php if($next): ?>
                        <a href="<?php echo $next->post_url ?>" title="<?php echo $next->post_title ?>"><?php echo $next->post_title ?><span class="icon">
                            <i class="fas fa-arrow-circle-right"></i>
                        </span></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="column is-3 sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
