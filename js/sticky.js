(function($){
    var stickyCount = 0; // Pour l'usage multiple du plugin
    $.fn.stickyZone = function(args) {
        return this.each(function() {
            stickyCount = stickyCount + 1; // Incrémentation pour l'usage multiple du plugin

            var options = $.extend({}, {
                stickyBlockClass : "sticky-box", // classe du bloc cible à rendre "sticky"
                stickyClass : "is-sticky", // classe qui active le mode "sticky" selon le niveau de scroll
                stickyEvents : "load scroll", // Ne doit pas être modifié en théorie !
                stickyTrigger : false, // False pour que l'effet Sticky se déclenche à l'offset Top, sinon valeur numérique
                stickyTopAuto : false, // Génère automatiquement la position top
                stickyLeftAuto : false, // Génère automatiquement la position left
                stickyMarginTopSelector : '.navbar', // Génère automatiquement la position left
                stickyPrevBlock : false, // Récupérer l'espace entre l'élément sticky et le précédent bloc sticky (si plusieurs)
                // stickyOthersOffsets: [{ // Distance supplémentaire ou en moins pour décaler le bloc sticky
                //  blockName: false, // Sélecteur du bloc à décaler
                //  blockOffset: -55, // "x" pixel à décaler vers le haut ou vers le bas (-x)
                //  }],
                stickyActiveCSS : {
                    "position":"fixed", // Position "fixed" pour le mode Sticky. Ne pas modifier !
                    "width":"100%", // Recommandé de fixer la largeur à 100% pour ne pas avoir de bug
                    "z-index":1, // Recommandé de fixer un fort z-index pour passer au-dessus des contenus
                    "top":0 // Optionnel : permet ici de coller le bloc Sticky en haut du viewport
                },
            }, args);

            if(options.stickyMarginTopSelector) {
                if($(window).width() <= 768) {
                    options.stickyMarginTop = $(options.stickyMarginTopSelector).height() - 0*parseInt($(this).css('margin-top')) + 0.75*parseInt($(this).find('a').first().css('padding-top'));
                    options.stickyActiveCSS.top = $(options.stickyMarginTopSelector).height() - parseInt($(this).css('margin-top')) + 0.75*parseInt($(this).find('a').first().css('padding-top'));
                } else {
                    var margin = parseInt($(this).css('margin-top')) + parseInt($(this).find('a').first().css('margin-top')) + parseInt($(this).css('margin-bottom'));
                    var padding = 0;parseInt($(this).find('a').first().css('padding-top'));
                    var diva = $(this).find('a div').first().height();

                    options.stickyMarginTop = $(options.stickyMarginTopSelector).height() - parseInt($(this).css('margin-top')) + 0.75*parseInt($(this).find('a').first().css('padding-top'));
                    options.stickyActiveCSS.top = $(options.stickyMarginTopSelector).height() - margin -diva - padding;
                    options.stickyMarginTop -= $(this).find('a div').first().height()+1;
                }
            }

            // Pour dissocier les sélecteurs (si multiple instance)
            var el = $(this);

            // On encadre le bloc ciblé par une DIV nécessaire pour faire l'effet sticky
            el.wrap('<div class="'+options.stickyBlockClass+' '+options.stickyBlockClass+'-'+stickyCount+'"></div>');
            var delta = 10; // pour corriger les 30 de margin-top juste dessous partout
            var newTempHeight = $('.'+options.stickyBlockClass+'-'+stickyCount).height() + parseInt($(this).first().css('margin-top')) - parseInt($(this).css('margin-bottom')) - delta;
            $('.'+options.stickyBlockClass+'-'+stickyCount).append('<div id="'+options.stickyBlockClass+'-'+stickyCount+'" style="height:'+newTempHeight+'px"></div>');

            // On prend les dimensions par défaut du bloc (hauteur dynamique)
            var heightSticky = Math.round(el.outerHeight());
            var offsetTopSticky = Math.round(el.offset().top);
            var offsetLeftSticky = Math.round(el.offset().left);

            // Récupération de la marge au-dessus si existante (pour éviter des décalages)
            var marginTopSticky = Math.round(el.css('margin-top').replace('px', ''));

            // Récupération des padding et margin du bloc qui suit le bloc sticky
            if(options.stickyPrevBlock === true && stickyCount > 1) {
                var prevBlockOffsetTop = $('.'+options.stickyBlockClass+'-'+(stickyCount-1)).offset().top;
                var prevBlockHeight = $('.'+options.stickyBlockClass+'-'+(stickyCount-1)).outerHeight();
                var spaceSticky = Math.round(offsetTopSticky - marginTopSticky - (prevBlockOffsetTop + prevBlockHeight));
            }

            // Récupération de la valeur du déclencheur (trigger) pour l'effet Sticky
            if(options.stickyTrigger != false && options.stickyTrigger != true) {
                var stickyEventTrigger = options.stickyTrigger;
            } else {
                var stickyEventTrigger = offsetTopSticky;
            }

            // Lance le sticky seulement si nécessaire (évite des scintillements quand la fenêtre est petite)
            if(Math.round($("body").outerHeight() - Math.round(el.outerHeight())) > ($(window).outerHeight() + Math.round(el.outerHeight()))) {
                // Ajoute le sticky selon les événements choisis (load scroll normalement)
                $(window).on(options.stickyEvents, function() {
                    // Récupération de la hauteur dynamiquement à chaque scroll (pour voir si elle change...)
                    if(heightSticky != Math.round(el.outerHeight())) {
                        var heightSticky = Math.round(el.outerHeight()); // Hauteur de l'entête
                    }

                    // Si on scroll au niveau du bloc sticky
                    if($(window).scrollTop() > stickyEventTrigger - options.stickyMarginTop) {
                        // Ajout de la classe d'activation du mode Sticky
                        el.addClass(options.stickyClass);
                        $('#'+options.stickyBlockClass+'-'+stickyCount).show();

                        // Application du style par défaut pour le bloc "sticky"
                        el.css(options.stickyActiveCSS);
                        el.width(el.parent().width() - parseInt(el.css('padding-left')) - parseInt(el.css('padding-right')));

                        // Récupération de la hauteur du bloc (utile si cette dernière change !)
                        el.outerHeight(heightSticky);

                        if(options.stickyPrevBlock === true && stickyCount > 1) {
                            var prevBlockHeight = Math.round($('.'+options.stickyBlockClass+'-'+(stickyCount-1)+" ."+options.stickyClass).outerHeight());
                            el.css({
                                "top": (prevBlockHeight + spaceSticky)+"px",
                                "margin-top":0
                            });
                        }

                    }
                    else // Si on est retourné au niveau le plus haut (donc plus de mode Sticky)
                    {
                        // Suppression de la class d'activation du mode Sticky
                        el.removeClass(options.stickyClass);
                        $('#'+options.stickyBlockClass+'-'+stickyCount).hide();

                        // Suppression du style spécifique actif pour le mode Sticky
                        el.removeAttr("style");

                        // Récupération de la hauteur initiale (par défaut) du bloc "sticky"
                        el.outerHeight(heightSticky);

                        // Supprime le style du bloc suivant (si l'option est active)
                        if(options.stickyNextBlock === true) {
                            el.next().removeAttr("style");
                        }
                    }

                    if(options.stickyTopAuto === true) {
                        el.css({
                            "top":offsetTopSticky,
                            "margin-top":0
                        });
                    }
                    if(options.stickyLeftAuto === true) {
                        // Mise à jour de la position gauche de l'élément
                        el.css({
                            "left":offsetLeftSticky,
                            "margin-left":0
                        });
                    }
                });
            }
        });
    };
    $('.tosticky').stickyZone();
})(jQuery);