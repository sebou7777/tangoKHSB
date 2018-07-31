<?php get_header(); ?>

<?php $blocs = get_blocs_hauts(); ?>
<?php if(count($blocs)): ?>
    <section class="page-cards page-cards-images columns tosticky">
    <?php foreach($blocs as $bloc): ?>
        <a href="/<?php echo $bloc['url'] ?>" data-id="<?php echo $bloc['id'] ?>" class="column is-3-desktop is-4-tablet is-12-mobile <?php echo ((isset($bloc['is_selected'])) ? 'is-active' : '') ?> <?php echo (($bloc['ajax']) ? 'ajax-call' : '') ?>">
            <div <?php echo (($bloc['image']) ? 'style="background-image: url('.$bloc['image'].');"' : '') ?>>
                <p><?php echo nl2br($bloc['texte']) ?></p>
            </div>
            <h4><?php echo $bloc['titre'] ?></h4>
        </a>
    <?php endforeach; ?>
    </section>
    <?php if(is_front_page()): ?>
        <?php $edito = last_edito(); ?>
        <section class="box container open-more">
            <div class="content">
                <h2 class="has-text-centered"><?php echo $edito->post_title ?></h2>
                <?php echo apply_filters('the_content', $edito->post_content) ?>
            </div>
            <div class="action desktop-hidden">
                <a class="button more">ouvrir</a>
                <a class="button less">fermer</a>
            </div>
        </section>
    <?php endif; ?>
    <section>

    </section>
<?php endif; ?>

<section id="content" class="container">

    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
        <?php if(is_gallery()): ?>
            <?php get_template_part( 'gallery' ); ?>
        <?php elseif(is_contact()): ?>
            <?php get_template_part( 'contact' ); ?>
        <?php else: ?>
        <article id="post-<?php the_id() ?>" <?php post_class(); ?>>
            <section class="content">
                <?php the_content(); ?>

            </section>
        </article>
        <?php endif; ?>

        <?php if(count($blocs) && is_blocs_hauts_ajax()): ?>
            <?php foreach($blocs as $bloc): ?>
                <?php if($bloc['ajax'] && $bloc['id'] != get_the_id()): ?>
                    <article id="post-<?php echo $bloc['id'] ?>" <?php post_class(); ?>>
                        <section class="content">
                        </section>
                    </article>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php endwhile; endif; ?>
</section>

<?php if(is_front_page()): ?>
    <section class="section">
        <div class="container">
            <div id="gmap-home"></div>
        </div>
    </section>
    <script>
        googleMapsAddresses.push({"address":"35 rue Jussieu 75005 Paris", "title":"Ecole Victor", "zoom":"15", "pin_url":"", 'container':'gmap-home'});
    </script>
<?php endif; ?>

<?php get_footer(); ?>