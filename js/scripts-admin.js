jQuery(document).ready(function($) {
    $('.hasdatepicker').datepicker({dateFormat : 'dd/mm/yy'});
    $(".hasdatepicker").each(function() {
        $(this).datepicker('setDate', $(this).val());
    });
    $('head').append('<style>.mce-toolbar .mce-btn-group .mce-btn.mce-rouge { margin-top:6px; } .mce-btn.mce-rouge button { background-color:#FF590D;height:15px;width:16px; }</style>');

    // document.write('<style>.mce-btn.mce-rouge button { color:#FF590D; }</style>');

    // on initialise une variable qui nous permettra de détecter le champ à remplir
    var formfield = null;
    // on détecte un clic sur le bouton
    $('.bloc_haut_image_upload').click(function() {
        $('html').addClass('pdf');
        // on cible notre champ
        formfield = $(this).data('input');
        // on charge la fenêtre
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        // on empêche toute action supplémentaire
        return false;
    });

    $('.bloc_accueil_image_upload').click(function() {
        $('html').addClass('pdf');
        // on cible notre champ
        formfield = $(this).data('input');
        // on charge la fenêtre
        tb_show('', 'media-upload.php?type=image&TB_iframe=true');
        // on empêche toute action supplémentaire
        return false;
    });
  
    // on duplique la function send_to_editor
    window.original_send_to_editor = window.send_to_editor;
    // notre fonction
    window.send_to_editor = function(html) {
        // la varible qui contient notre url DE FICHIER
        var fileurl;
        // si la fenetre est bien chargé à partir du bouton
        if (formfield != null) {
            // on récupère l'url (si besoin, pour comprendre, vous pouvez faire un console.log de html)
            fileurl = $(html).filter('img').attr('src');
            fileurl = fileurl.replace(/^(.*)\/wp-content\/(.*)$/, "/wp-content/$2");
            // on écrit l'URL dans notre champ texte
            $('#'+formfield).val(fileurl);
            // on shoot la boite
            tb_remove();
            // on vire la classe pdf
            $('html').removeClass('pdf');
            // on vide la variable formfield
            formfield = null;
        } else {
            // si la fenêtre n'est pas chargée à partir du bouton, alors comportement normal
            window.original_send_to_editor(html);
        }
    };
});
