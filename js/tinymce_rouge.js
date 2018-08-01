(function() {
    tinymce.PluginManager.add( 'rouge', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('rouge', {
            text: ' ',
            classes:'rouge',
            title: 'Texte en rouge',
            cmd: 'rouge',
            icon: false
        });

        editor.addCommand('rouge', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if (selected_text.length === 0) {
                alert( 'Sélectionnez le texte avant' );
                return;
            }
            return_text = '<span style="color:#FF590D">'+selected_text+"</span>";
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
    });
})();