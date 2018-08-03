var googleMapsAddress;

function prepare() {
    if(googleMapsAddresses.length) {
        jQuery.each(googleMapsAddresses, function(index, address) {
            // googleMapAddress = address;
            useAddress(index);
        });
    }
}

function useAddress(i) {
    var geocoder = new google.maps.Geocoder();
    var index = i;

    geocoder.geocode(
        { "address": googleMapsAddresses[index].address },
        function ( results, status ) {
            if ( status == google.maps.GeocoderStatus.OK ) {
                initialize(index, results[0].geometry.location);
            }
        }
    );
}

function initialize(index, position) {
    var googleMapAddress = googleMapsAddresses[index];
    var mapOptions = {
        zoom     : parseInt( googleMapAddress.zoom ),
        center   : position,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }

    googleMapAddress.map = new google.maps.Map( document.getElementById(googleMapAddress.container), mapOptions );

    var marker = {
        map     : googleMapAddress.map,
        title   : googleMapAddress.title,
        position: position
    };

    if ( 'undefined' !== googleMapAddress.pin_url && googleMapAddress.pin_url ) {
        marker.icon = googleMapAddress.pin_url;
    }
    new google.maps.Marker(marker);
}

jQuery(document).ready(function($) {
    jQuery(".navbar-burger").click(function() {
        jQuery(".navbar-burger").toggleClass("is-active");
        jQuery(".navbar-menu").toggleClass("is-active");

    });

    jQuery('body').on('click', '.ajax-call', function(e) {
        history.pushState(null, null, jQuery(this).attr('href'));
        jQuery('body .ajax-call').removeClass('is-active');
        jQuery(this).addClass('is-active');
        var offsetHeight = parseInt(jQuery('.is-fixed-top').height())+20;
        if(jQuery('#sticky-box-1') && jQuery('#sticky-box-1').attr('id')) {
            offsetHeight += jQuery(this).height();
            if(jQuery(window).width() <= 768) {
                offsetHeight += jQuery(this).siblings().length * jQuery(this).height();
            }
        } else {
            offsetHeight += jQuery(this).height();
        }
        if(jQuery('#post-'+jQuery(this).data('id')).length) {
            jQuery("body").addClass('scrolling');
            jQuery("html, body").animate( { scrollTop: jQuery('#post-'+jQuery(this).data('id')).offset().top-offsetHeight }, 1000, function() { jQuery("body").removeClass('scrolling') });
        }

        if(jQuery(this).find('h4').length)
            jQuery('.header-image h1').text(jQuery(this).find('h4').text());
        e.preventDefault();
        e.stopPropagation();
    });
    jQuery('.ajax-call').each(function(e) {
        var id = jQuery(this).data('id');
        jQuery.get(
            ajaxurl, {'action': 'get_content_of_specific_page', 'param': id},
            function(response){
                jQuery('#post-'+id).html(response);
            }
        );
    });

    jQuery(document).on("scroll", function() {
        if(jQuery('.is-sticky').length && !jQuery('body').hasClass('scrolling')) {
            var menu = jQuery('.is-sticky').first();
            var menuTop = menu.offset().top + menu.height() + parseInt(menu.css('margin-bottom'));

            jQuery(".is-sticky a").each(function() {
                if(jQuery(this).hasClass('ajax-call')) {
                    var item = jQuery('#post-'+jQuery(this).data("id"));
                    if(!item.data('start')) {
                        item.data('start', item.offset().top);
                        item.data('end', item.offset().top + item.height());
                    }
                    if(menuTop >= item.data('start') && menuTop <= item.data('end') && !jQuery(this).hasClass('is-active')) {
                        jQuery(".is-sticky a").removeClass('is-active');
                        jQuery(this).addClass('is-active');
                        history.pushState(null, null, jQuery(this).attr('href'));
                    }
                }
            });
        }
    });

    baguetteBox.run('.photos');

    jQuery("a[href*='#']:not([href='#'])").click(function() {
        if (
            location.hostname == this.hostname
            && this.pathname.replace(/^\//,"") == location.pathname.replace(/^\//,"")
        ) {
            var anchor = jQuery(this.hash);
            anchor = anchor.length ? anchor : jQuery("[name=" + this.hash.slice(1) +"]");
            if ( anchor.length ) {
                jQuery("html, body").animate( { scrollTop: anchor.offset().top }, 1500);
            }
        }
    });

    jQuery(window).scroll(function() {
        if (jQuery(this).scrollTop()) {
            jQuery('#toTop').fadeIn();
        } else {
            jQuery('#toTop').fadeOut();
        }
    });

    jQuery("#toTop").click(function(e) {
        jQuery("html, body").animate({scrollTop: 0}, 1000);
        e.preventDefault();
        e.stopPropagation();
        return false;
    });

    var galleryWidth;
    jQuery('.gallery').each(function() {
        var imgs = {}; var sizes = {};
        jQuery(this).find('a img').each(function() {
            if (typeof imgs[jQuery(this).offset().top] === "undefined")
                imgs[jQuery(this).offset().top] = [];
            imgs[jQuery(this).offset().top].push(jQuery(this));
            if (typeof sizes[jQuery(this).offset().top] === "undefined")
                sizes[jQuery(this).offset().top] = 0;
            sizes[jQuery(this).offset().top] += jQuery(this).width();
        });
        galleryWidth = jQuery(this).width();
        for(var index in imgs) {
            var nb = imgs[index].length;
            var newWidth = galleryWidth - 4*nb;
            var ratio = newWidth / sizes[index];
            for(var img in imgs[index]) {
                img = imgs[index][img];
                img.width(img.width()*ratio);
                img.parent().height('auto');
            }
        }
    });
    $('section.page-cards a div').on('mouseenter mouseleave', function(e) {
        $(this).parent().find('h4').trigger(e.type);
    })
    jQuery('')


    var openMoreDefaultHeight;
    jQuery('body').on('click', '.open-more a.button', function(){
        var s = jQuery(this).closest('.open-more');
        if(!s.hasClass('opened')){
            openMoreDefaultHeight = parseInt(s.css('height'));
            var h = s.find('.content').height();
            s.animate({'height':h + 100}, 1000).addClass('opened');
            s.find('a.button.more').hide();
            s.find('a.button.less').show();
        }else{
            var h = openMoreDefaultHeight;
            s.animate({'height':h}, 1000).removeClass('opened');
            s.find('a.button.less').hide();
            s.find('a.button.more').show();
            jQuery("html, body").animate( { scrollTop: jQuery(this).parent().parent().offset().top-parseInt(jQuery('.tosticky').height())-parseInt(jQuery('.is-fixed-top').height()) }, 1000);
        }
    });

    if(jQuery('#gmap-home').length) {
        jQuery('#gmap-home').on('mouseenter', function() {
            if(!jQuery('#gmap-home').data('isloaded')) {
                jQuery('#gmap-home').data('isloaded', true);
                var script = document.createElement('script');
                script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyClMBaqKEYIBPwZN2KipIRCIzNsTnl0pu0&callback=prepare';
                document.head.appendChild(script);
            }
        });
    } else {
        var script = document.createElement('script');
        script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyClMBaqKEYIBPwZN2KipIRCIzNsTnl0pu0&callback=prepare';
        document.head.appendChild(script);
    }

});
