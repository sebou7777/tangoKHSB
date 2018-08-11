<?php if(!is_front_page()): ?>
    <section>
        <div>
            <div id="gmap"></div>
        </div>
    </section>
<?php endif; ?>
<footer class="footer">
    <div class="container">
        <div class="columns">
            <div class="column is-12 is-12-tablet is-12-mobile footer-brand">
                <h4 class="bd-footer-title">
                    <a href="/" title="TANGO ARGENTIN à Paris - Leah et Jean-Philippe">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></a>
                </h4>
            </div>
        </div>

        <div class="bd-footer-links">
            <div class="columns">
            <?php $i = 0; ?>
            <?php foreach(tango_menu_footer() as $item): ?>
                <?php if(count($item->submenu)): ?>
                    <?php $i = 0; ?>
                    <div class="column is-3 is-3-tablet is-6-mobile">
                        <p class="bd-footer-link-title">
                            <a href="<?php echo $item->url ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a>
                        </p>
                        <?php foreach($item->submenu as $ssitem): ?>
                            <p class="bd-footer-link">
                                <a href="<?php echo $ssitem->url ?>" title="<?php echo $ssitem->title ?>"><?php echo $ssitem->title ?></a>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <?php if(!($i % 4)): ?><div class="column is-3 is-3-tablet is-6-mobile"><?php endif; ?>
                    <p class="bd-footer-link">
                        <a href="<?php echo $item->url ?>" title="<?php echo $item->title ?>"><?php echo $item->title ?></a>
                    </p>
                    <?php if(!(++$i % 4)): ?></div><?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
                <p class="bd-footer-link">
                    <a href="https://www.facebook.com/groups/487246421379169/" target="_blank" title="Facebook de la Practica Victor">
                        Facebook <i class="fab fa-facebook"></i>
                    </a>
                </p>
            </div></div>
        </div>
        <p class="copyright">Copyright © 2018, Tango Argentin à Paris. Tout droit réservé.</p>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>