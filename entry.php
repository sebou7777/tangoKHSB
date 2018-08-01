
<!--<article id="post---><?php //the_ID(); ?><!--" class="content">-->
<!--<header>-->
    <?php if(is_singular()): ?>
<!--        <span class="cat-links">--><?php //the_category( ', ' ) ?><!--</span>-->
<!--        <h1 class="has-text-centered">--><?php //the_title(); ?><!--</h1>-->
    <?php else: ?>
        <h2><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>" rel="bookmark"><?php the_title(); ?></a></h2>
    <?php endif; ?>

<?php if ( !is_search() ) get_template_part( 'entry', 'meta' ); ?>
<!--</header>-->
<?php get_template_part( 'entry', ( is_archive() || is_search() ? 'summary' : 'content' ) ); ?>
<!--</article>-->
