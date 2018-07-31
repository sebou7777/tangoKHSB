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
            offsetHeight += jQuery(this).find('h4').first().height();
            if(jQuery(window).width() <= 768) {
                console.log(jQuery(this).siblings().length);
                offsetHeight += jQuery(this).siblings().length * jQuery(this).height();
            }else {

            }

        } else {
            offsetHeight += jQuery(this).height();
        }
        jQuery("html, body").animate( { scrollTop: jQuery('#post-'+jQuery(this).data('id')+' .content').offset().top-offsetHeight }, 1000);
        e.preventDefault();
        e.stopPropagation();
    });
    jQuery('.ajax-call').each(function(e) {
        var id = jQuery(this).data('id');
        jQuery.get(
            ajaxurl, {'action': 'get_content_of_specific_page', 'param': id},
            function(response){
                jQuery('#post-'+id+' .content').html(response);
                // jQuery("html, body").animate( { scrollTop: jQuery('#post-'+jQuery('#article_is_default').val()+' .content').offset().top }, 1000);
            }
        );
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
});
