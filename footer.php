<footer class="footer">
    <div class="container">
        <div class="columns">
            <div class="column is-12 is-12-tablet is-12-mobile footer-brand">
                <h4 class="bd-footer-title">
                    <a href="/">TANGO ARGENTIN à Paris <br> <span>Leah et Jean-Philippe</span></a>
                </h4>
            </div>
        </div>

        <div class="bd-footer-links">
            <div class="columns">
            <?php $i = 0; ?>
            <?php foreach(tango_menu_footer() as $item): ?>
                <?php if(count($item->submenu)): ?>
                    <?php $i = 0; ?>
                    <div class="column is-3 is-3-tablet is-5-mobile">
                        <p class="bd-footer-link-title">
                            <a href="<?php echo $item->url ?>"><?php echo $item->title ?></a>
                        </p>
                        <?php foreach($item->submenu as $ssitem): ?>
                            <p class="bd-footer-link">
                                <a href="<?php echo $ssitem->url ?>"><?php echo $ssitem->title ?></a>
                            </p>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <?php if(!($i % 4)): ?><div class="column is-3 is-3-tablet is-5-mobile"><?php endif; ?>
                    <p class="bd-footer-link">
                        <a href="<?php echo $item->url ?>"><?php echo $item->title ?></a>
                    </p>
                    <?php if(!(++$i % 4)): ?></div><?php endif; ?>
                <?php endif; ?>
            <?php endforeach; ?>
                <p class="bd-footer-link">
                    <a href="https://www.facebook.com/groups/487246421379169/" target="_blank">
                        Facebook <i class="fab fa-facebook"></i>
                    </a>
                </p>
            </div>

<!--                <div class="column is-3 is-3-tablet is-5-mobile">-->
<!---->
<!--                    <p class="bd-footer-link-title">-->
<!--                        <a href="">Professeurs</a>-->
<!--                    </p>-->
<!---->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="/">-->
<!--                            Biographie-->
<!--                        </a>-->
<!--                    </p>-->
<!---->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="/">-->
<!--                            Notre pédagogie-->
<!--                        </a>-->
<!--                    </p>-->
<!---->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="/">-->
<!--                            Livre d'or-->
<!--                        </a>-->
<!--                    </p>-->
<!---->
<!--                </div>-->
<!---->
<!--                <div class="column is-3 is-3-tablet is-5-mobile">-->
<!--                    <p class="bd-footer-link-title">-->
<!--                        <a href="">Cours</a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Cours-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Horaires/Tarifs-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Débutants-->
<!--                        </a>-->
<!--                    </p>-->
<!--                </div>-->
<!---->
<!--                <div class="column is-3 is-3-tablet is-5-mobile">-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Le Tango-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Nos références-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Archives ???-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Pratica Victor ?-->
<!--                        </a>-->
<!--                    </p>-->
<!--                </div>-->
<!---->
<!--                <div class="column is-3 is-3-tablet is-5-mobile">-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Contact-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Photos-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="">-->
<!--                            Stage ?-->
<!--                        </a>-->
<!--                    </p>-->
<!--                    <p class="bd-footer-link">-->
<!--                        <a href="https://www.facebook.com/groups/487246421379169/" target="_blank">-->
<!--                            Facebook <i class="fab fa-facebook"></i>-->
<!--                        </a>-->
<!--                    </p>-->
<!--                </div>-->

            </div>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>