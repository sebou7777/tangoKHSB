<!DOCTYPE html>
<html <?php language_attributes(); ?> class="tango has-navbar-fixed-top">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width" />
    <?php wp_head(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri().'/css/style.css'; ?>" />
    <script>var googleMapsAddresses = new Array();</script>
    <script>var locationIQAddresses = new Array();</script>
</head>
<body>
    <a href="javascript:void(0);" id="toTop" title="Haut de page" style="display: none;">Top<span></span></a>
    <nav class="navbar is-fixed-top" aria-label="dropdown navigation">

        <div class="navbar-brand">
            <a class="navbar-item" href="/" title="TANGO ARGENTIN à Paris - Leah et Jean-Philippe">
            <?php if(is_front_page()): ?>
                <h1 class="title-brand">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></h1>
            <?php else: ?>
                <p class="title-brand">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></p>
            <?php endif; ?>
            </a>
            <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false" title="TANGO ARGENTIN à Paris - Menu Mobile">
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
                            <a class="navbar-link <?php echo (($item->is_selected) ? 'is-active' : '') ?>" href="<?php echo $item->url ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a>
                            <div class="navbar-dropdown is-boxed">
                                <?php foreach($item->submenu as $ssitem): ?>
                                    <a class="navbar-item <?php echo (($ssitem->is_selected) ? 'is-active' : '') ?>" href="<?php echo $ssitem->url ?>" title="<?php echo $ssitem->title ?>"><?php echo $ssitem->title ?></a>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <a class="navbar-item <?php echo (($item->is_selected) ? 'is-active' : '') ?>" href="<?php echo $item->url ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </nav>

    <?php list($image, $hasSpecificImage) = tango_get_top_image(); ?>
    <?php if($image && count($image)): ?>
    <section class="header-image desaturte <?php if(is_front_page()): ?>is-home<?php endif; ?> <?php if($hasSpecificImage): ?>has-specific-image<?php endif; ?>" style="background-image: url('<?php echo $image[0]; ?>');">
        <?php if(!is_front_page()): ?>
            <h1 class="title"><?php echo tango_get_top_title() ?></h1>
        <?php else: ?>
            <?php $alerte = next_alerte(); $nbAlert = 0; ?>
            <?php if($stage = next_stage()): ?>
                <div class="info-wrapper has-text-centered">
                    <h3>PROCHAIN STAGE</h3>
                    <p><?php echo $stage['date_format'] ?><br/><?php echo $stage['time_format'] ?></p>
                    <p><?php echo nl2br($stage['description']) ?></p>
                    <a class="button" href="<?php echo $stage['post_url'] ?>" title="<?php echo apply_filters( 'the_title', $stage['post_title']) ?>">En savoir plus</a>
                </div>
            <?php elseif(isset($alerte[$nbAlert])): ?>
                <div class="info-wrapper has-text-centered">
                    <h3><?php echo apply_filters( 'the_title', $alerte[$nbAlert]['post_title']) ?></h3>
                    <?php if($alerte[$nbAlert]['print_date'] != 2): ?>
                        <p><?php echo $alerte[$nbAlert]['date_format'] ?><br/><?php echo $alerte[$nbAlert]['time_format'] ?></p>
                    <?php endif; ?>
                    <p><?php echo nl2br($alerte[$nbAlert]['description']) ?></p>
                    <a class="button" href="<?php echo $alerte[$nbAlert]['post_url'] ?>" title="<?php echo apply_filters( 'the_title', $alerte[$nbAlert]['post_title']) ?>">En savoir plus</a>
                </div>
                <?php $nbAlert++ ?>
            <?php endif; ?>

            <?php if(isset($alerte[$nbAlert])): ?>
                <div class="info-wrapper has-text-centered alerte">
                    <h3><?php echo apply_filters( 'the_title', $alerte[$nbAlert]['post_title']) ?></h3>
                    <?php if($alerte[$nbAlert]['print_date'] != 2): ?>
                        <p><?php echo $alerte[$nbAlert]['date_format'] ?><br/><?php echo $alerte[$nbAlert]['time_format'] ?></p>
                    <?php endif; ?>
                    <p><?php echo nl2br($alerte[$nbAlert]['description']) ?></p>
                    <a class="button" href="<?php echo $alerte[$nbAlert]['post_url'] ?>" title="<?php echo apply_filters( 'the_title', $alerte[$nbAlert]['post_title']) ?>">En savoir plus</a>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>
    <?php endif; ?>
