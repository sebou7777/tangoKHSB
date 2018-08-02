<?php get_header(); ?>
<section id="content" class="content container">
    <div class="columns">
        <div class="column is-9">
            <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                <?php get_template_part( 'entry' ); ?>
            <?php endwhile; endif; ?>
            <div class="level">
                <?php list($prev, $next) = get_pagination(); ?>
                <div class="level-left">
                    <?php if($prev): ?>
                        <a class="button" href="<?php echo $prev->post_url ?>"><?php echo $prev->post_title ?></a>
                    <?php endif; ?>
                </div>
                <div class="level-right">
                    <?php if($next): ?>
                        <a class="button" href="<?php echo $next->post_url ?>"><?php echo $next->post_title ?></a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="border-center left-34"></div>
        <div class="column is-3 sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>
<?php get_footer(); ?>
