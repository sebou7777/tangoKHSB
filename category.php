<?php get_header(); ?>
<section id="content" class="content container">
    <div class="columns">
        <div class="column is-9">
            <?php query_posts('cat='.get_category(get_query_var('cat'))->cat_ID.'&showposts=100'); ?>
            <div class="columns is-multiline">
                <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
                    <div class="column is-half"><?php get_template_part( 'entry' ); ?></div>
                <?php endwhile; endif; ?>
            </div>
        </div>
        <div class="border-center left-34"></div>
        <div class="column is-3 sidebar">
            <?php get_sidebar(); ?>
        </div>
    </div>
</section>

<?php get_footer(); ?>