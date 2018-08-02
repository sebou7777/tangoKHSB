<?php get_header(); ?>

<?php $blocs = get_blocs_hauts(); ?>
<?php if(count($blocs)): ?>
<!--    <section class="page-cards page-cards-images columns --><?php //echo ((is_blocs_hauts_ajax()) ? 'tosticky' : '') ?><!--">-->
    <section class="page-cards page-cards-images columns tosticky">
    <?php foreach($blocs as $bloc): ?>
        <a href="/<?php echo $bloc['url'] ?>" data-id="<?php echo $bloc['id'] ?>" class="column one-card is-3-desktop is-4-tablet is-12-mobile <?php echo ((isset($bloc['is_selected'])) ? 'is-active is-the-page' : '') ?> <?php echo (($bloc['ajax']) ? 'ajax-call' : '') ?>">
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
        <section class="box container open-more" style="margin-top:30px;">
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
<?php endif; ?>

<?php if(is_front_page()): ?>
    <section class="">
        <div class="container">
            <div id="gmap-home" data-isloaded style="background-position: center;background-image:url(http://s331430828.onlinehome.fr/wp-content/uploads/2018/07/screenshot-s331430828.onlinehome.fr-2018-07-31-17-_f29867809674abbd77d5e8a710beb4d3.png)"></div>
        </div>
    </section>
    <script>
        googleMapsAddresses.push({"address":"35 rue Jussieu 75005 Paris", "title":"Ecole Victor", "zoom":"15", "pin_url":"", 'container':'gmap-home'});
    </script>
<?php endif; ?>

<section id="content" class="container <?php echo ((is_front_page()) ? 'is-home' : '') ?>">
<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
    <?php if(is_gallery()): ?>
        <?php get_template_part( 'gallery' ); ?>
    <?php elseif(is_contact()): ?>
        <?php get_template_part( 'contact' ); ?>
    <?php else: ?>
        <div id="post-<?php the_id() ?>" class="wp-content content">
            <?php echo get_the_content() ?>
        </div>
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