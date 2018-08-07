<?php if(!is_singular()): ?>
    <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <?php //get_template_part( 'entry', 'meta' ); ?>
<?php endif; ?>

<?php get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
