<!DOCTYPE html>
<html <?php language_attributes(); ?> class="tango has-navbar-fixed-top">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri().'/css/style.css'; ?>" />
    <script>var googleMapsAddresses = new Array();</script>
</head>
<body>
    <a href="javascript:void(0);" id="toTop" title="Scroll to Top" style="display: none;">Top<span></span></a>
    <nav class="navbar is-fixed-top" role="navigation" aria-label="dropdown navigation">

        <div class="navbar-brand">
            <a class="navbar-item" href="/">
            <?php if(is_front_page()): ?>
                <h1 class="title-brand">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></h1>
            <?php else: ?>
                <p class="title-brand">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></p>
            <?php endif; ?>
            </a>
            <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>

        <div class="navbar-menu tango-menu" id="navMenu">
            <div class="navbar-end">
                <?php foreach(tango_menu() as $item): ?>
                    <?php if(count($item->submenu)): ?>
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link <?php echo (($item->is_selected) ? 'is-active' : '') ?>" href="<?php echo $item->url ?>"><?php echo $item->title ?></a>
                            <div class="navbar-dropdown is-boxed">
                                <?php foreach($item->submenu as $ssitem): ?>
                                    <a class="navbar-item <?php echo (($ssitem->is_selected) ? 'is-active' : '') ?>" href="<?php echo $ssitem->url ?>"><?php echo $ssitem->title ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="navbar-item <?php echo (($item->is_selected) ? 'is-active' : '') ?>" href="<?php echo $item->url ?>"><?php echo $item->title ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>

    <?php $image = tango_get_top_image(); ?>
    <?php if($image && count($image)): ?>
    <section class="header-image" style="<?php if(!is_front_page()): ?>height:50vh;<?php endif; ?>background-image: url('<?php echo $image[0]; ?>');">
        <?php if(!is_front_page()): ?><h1 class="title"><?php echo tango_get_top_title() ?></h1><?php endif; ?>

        <?php if($stage = next_stage()): ?>
            <div class="info-wrapper has-text-centered">
                <h3>PROCHAIN STAGE</h3>
                <p><?php echo $stage['date_format'] ?><br/><?php echo $stage['time_format'] ?></p>
                <p><?php echo nl2br($stage['description']) ?></p>
                <a class="button" href="<?php echo $stage['post_url'] ?>">En savoir plus</a>
            </div>
        <?php endif; ?>

        <?php if($alerte = next_alerte()): ?>
            <div class="info-wrapper has-text-centered alerte">
                <h3><?php echo apply_filters( 'the_title', $alerte['post_title']) ?></h3>
                <p><?php echo $stage['date_format'] ?><br/><?php echo $alerte['time_format'] ?></p>
                <p><?php echo nl2br($alerte['description']) ?></p>
            </div>
        <?php endif; ?>
    </section>
    <?php endif; ?>
