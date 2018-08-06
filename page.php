<?php get_header(); ?>

<?php $blocs = get_blocs_hauts(); ?>
<?php if(count($blocs)): ?>
    <?php $class = ((count($blocs) == 5) ? 'is-2-desktop' : 'is-3-desktop') ?>
    <section class="page-cards page-cards-images columns tosticky">
    <?php foreach($blocs as $bloc): ?>
        <a href="/<?php echo $bloc['url'] ?>" data-id="<?php echo $bloc['id'] ?>" class="column one-card <?php echo $class ?> is-4-tablet is-12-mobile <?php echo ((isset($bloc['is_selected'])) ? 'is-active is-the-page' : '') ?> <?php echo (($bloc['ajax']) ? 'ajax-call' : '') ?>" title="<?php echo $bloc['titre'] ?>">
            <?php if($bloc['image']): ?>
            <div <?php echo (($bloc['image']) ? 'style="background-image: url('.$bloc['image'].');"' : '') ?> class="card-text">
                <p><?php echo nl2br($bloc['texte']) ?></p>
            </div>
            <?php endif; ?>
            <h4><?php echo $bloc['titre'] ?></h4>
        </a>
    <?php endforeach; ?>
    </section>
    <?php if(is_front_page()): ?>
        <?php $edito = last_edito(); ?>
        <section class="box container open-more" style="margin-top:30px;" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <h2 class="has-text-centered"><?php echo $edito->post_title ?></h2>
                <?php echo apply_filters('the_content', $edito->post_content) ?>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>

<?php if(is_front_page()): ?>
    <section>
        <div>
            <div id='gmap-home'></div>
        </div>
    </section>
    <script>
        locationIQAddresses.push({"address":"35 rue Jussieu 75005 Paris", "title":"Ecole Victor", "zoom":"15", "pin_url":"", 'container':'gmap-home'});
    </script>
<?php endif; ?>

<section id="content" class="container <?php echo ((is_front_page()) ? 'is-home' : '') ?>">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php if(is_gallery()): ?>
        <?php get_template_part( 'gallery' ); ?>
    <?php elseif(is_contact()): ?>
        <?php get_template_part( 'contact' ); ?>
    <?php else: ?>
        <?php if(is_front_page()): ?>
            <?php echo get_the_content() ?>
            <?php foreach(tango_get_blocs_bas() as $bloc): ?>
                <div class="columns 1-column">
                    <div class="column open-more" data-open="Lire la suite" data-close="Fermer">
                        <div class="content">
                            <h2><?php echo $bloc['titre'] ?></h2>
                            <?php if($bloc['image']): ?><img class="alignleft" src="<?php echo $bloc['image'] ?>" title="<?php echo $bloc['titre'] ?>" /><?php endif; ?>
                            <p><?php echo $bloc['description'] ?></p>
                            <p class="has-text-right-desktop has-text-centered-mobile"><a class="button" title="<?php echo $bloc['titre'] ?>" href="<?php echo $bloc['url'] ?>">En savoir plus</a></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div id="post-<?php the_id() ?>" class="wp-content content">
                <?php echo get_the_content() ?>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <?php if(count($blocs) && is_blocs_hauts_ajax()): ?>
        <?php foreach($blocs as $bloc): ?>
            <?php if($bloc['ajax'] && $bloc['id'] != get_the_id()): ?>
                <div id="post-<?php echo $bloc['id'] ?>" class="wp-content content"></div>
            <?php endif; ?>
        <?php endforeach; ?>
    <?php endif; ?>
<?php endwhile; endif; ?>
</section>

<?php get_footer(); ?>