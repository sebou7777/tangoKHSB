(function() {
    tinymce.PluginManager.add( 'columns1', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('columns1', {
            title: 'Ajout 1 colonne',
            cmd: 'columns1',
            icon: 'table'
        });

        editor.addCommand('columns1', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if (selected_text.length) {
                alert( 'On insère le tableau SANS texte' );
                return;
            }
            return_text = '<div class="columns 1-column"><div class="column"><p></p></div></div>';
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
    });
})();