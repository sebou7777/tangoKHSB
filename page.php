<?php get_header(); ?>

<?php $blocs = get_blocs_hauts(); ?>
<?php if(count($blocs)): ?>
<!--    <section class="page-cards page-cards-images columns --><?php //echo ((is_blocs_hauts_ajax()) ? 'tosticky' : '') ?><!--">-->
    <section class="page-cards page-cards-images columns tosticky">
    <?php foreach($blocs as $bloc): ?>
        <a href="/<?php echo $bloc['url'] ?>" data-id="<?php echo $bloc['id'] ?>" class="column one-card is-3-desktop is-4-tablet is-12-mobile <?php echo ((isset($bloc['is_selected'])) ? 'is-active is-the-page' : '') ?> <?php echo (($bloc['ajax']) ? 'ajax-call' : '') ?>" title="<?php echo $bloc['titre'] ?>">
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
        <section class="box container open-more fondu" style="margin-top:30px;" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <h2 class="has-text-centered"><?php echo $edito->post_title ?></h2>
                <?php echo apply_filters('the_content', $edito->post_content) ?>
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
    <div class="columns two-columns">
        <div class="column is-half open-more even-desktop" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <img class="alignleft size-medium wp-image-1135" src="http://s331430828.onlinehome.fr/wp-content/uploads/2018/07/DSC_3123-300x165.jpg" alt="" />
                <h2>Cours Tango Paris</h2>
                <p>Vous trouverez ici une présentation de nos activités autour du <a title="Tango Argentin à Paris" href="http://s331430828.onlinehome.fr/tango-argentin"><span style="color: #ff590d;"><span class="il">tango</span> argentin à Paris</span></a>. Nos différents <span style="color: #ff590d;"><a title="Cours débutants" href="http://s331430828.onlinehome.fr/cours-tango-debutant-paris"><span style="color: #ff590d;">cours</span></a></span>, notre approche spécifique pour le débutant, nos <span style="color: #ff590d;">stages</span> et notre Pratique, <a title="La Practica Victor" href="http://s331430828.onlinehome.fr/practica-victor"><span style="color: #ff590d;">la Practica Victor</span></a>. Tous ces aspects sont développés à partir d’une conception du <span class="il">tango</span> argentin et de son enseignement qui s’appuie sur une expérience de plus de vingt ans.</p>
            </div>
        </div>
        <div class="column is-half open-more even-desktop" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <img class=" wp-image-571 alignright" src="http://s331430828.onlinehome.fr/wp-content/uploads/2017/11/FlyerStagesNB.jpg" alt="" width="277" height="405" />
                <h2 lang="fr-FR" align="JUSTIFY">Les stages de tango, valse et milonga</h2>
                <p lang="fr-FR" align="JUSTIFY">Nous dansons pour éprouver ce plaisir unique de se sentir en union avec un/une partenaire à travers la musique. Nous vous proposerons dans  nos stages comme nous le faisons dans les cours d'explorer tout ce qui nous permet de mieux nous approprier ce qui fait cette saveur particulière du tango argentin. Comment se met en place un dialogue constant entre les deux partenaires, en construisant musicalement à deux chaque pas, chaque déplacement, chaque pivot, chaque arrêt.</p>
                <p lang="fr-FR" align="JUSTIFY">Dans les ateliers tango et vals, comme dans les ateliers milonga, nous pourrons voir comment ce dialogue maintenu dans l'abrazo permet de créer des figures découlant des différents rythmes et toujours conçues comme des explorations des espaces disponibles dans le bal.</p>
            </div>
        </div>
    </div>
    <div class="columns two-columns">
        <div class="column is-half open-more fondu even-desktop" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <h2 align="JUSTIFY">Qu'est-ce qu'on fait dans les cours ? On ouvre des portes.</h2>
                <img class="alignleft size-medium wp-image-536" src="http://s331430828.onlinehome.fr/wp-content/uploads/2015/07/vlcsnap-2017-07-28-19h53m41s200epCep-300x300.png" alt="" />
                <p lang="fr-FR" align="JUSTIFY">Nous amenons les élèves devant des portes. C'est à eux qu'il appartient de les ouvrir. Ils doivent éprouver cette satisfaction de s'ouvrir une porte, là où peut-être on ne voyait pas comment avancer.</p>
                <p>Certains ouvrent la porte dès qu'ils la voient. Pour d'autres, on doit leur mettre la main sur la poignée, voire accompagner le geste de tourner la poignée, de pousser la porte. Quoi qu'il en soit, on ne peut passer la porte à leur place. Certains pensent que leur porte est munie d'un verrou. A nous de les convaincre qu'il n'en n'est rien.</p>
                <p>D'une manière générale, les élèves vont avoir affaire à plusieurs portes, et à chaque fois les circonstances peuvent être différentes. Une porte peut être évidente à ouvrir, une autre non. Il arrive aussi qu'une porte soit si évidente à ouvrir qu'on ne la repère même pas. C'est souvent le cas de bons danseurs, et cela explique pourquoi un bon danseur n'est pas forcément un bon professeur.</p>
                <p style="text-align: right;" lang="fr-FR" align="JUSTIFY"><a class="button" title="Tout sur nos cours" href="http://s331430828.onlinehome.fr/cours-tango-paris">En savoir plus sur nos cours</a></p>
            </div>
        </div>
        <div class="column is-half open-more even-desktop" data-open="Lire la suite" data-close="Fermer">
            <div class="content">
                <img class="alignright size-medium wp-image-532" src="http://s331430828.onlinehome.fr/wp-content/uploads/2015/07/vlcsnap-2017-07-10-13h27m34s99epCA-175x300.png" alt="" />
                <h2 align="JUSTIFY">La Practica Victor</h2>
                <p>La Practica Victor est une pratique de tango argentin qui se déroule chaque mercredi soir à Paris dans les mêmes locaux que les cours, depuis huit ans. A l’origine destinée surtout à nos élèves, elle s’est très vite ouverte à tous les danseurs désireux de trouver un lieu particulièrement convivial pour mettre en pratique les enseignements reçus dans différents cours et se familiariser avec l’univers du bal.</p>
                <p>La Practica Victor est une Pratique assistée, c’est-à-dire que les professeurs ne la dirigent pas mais sont disponibles pour répondre aux éventuelles questions : point technique, rappel de cours, vie du bal etc.</p>
                <p style="text-align: right;" lang="fr-FR" align="JUSTIFY"><a class="button" title="La practica Victor" href="http://s331430828.onlinehome.fr/practica-victor">En savoir plus</a></p>
            </div>
        </div>
    </div>
</section>

<?php get_footer(); ?>