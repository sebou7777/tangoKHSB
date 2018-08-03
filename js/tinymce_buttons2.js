(function() {
    tinymce.PluginManager.add( 'columns2', function( editor, url ) {
        // Add Button to Visual Editor Toolbar
        editor.addButton('columns2', {
            title: 'Ajout 2 colonnes',
            cmd: 'columns2',
            icon: 'table'
        });

        editor.addCommand('columns2', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if (selected_text.length) {
                alert( 'On insère le tableau SANS texte' );
                return;
            }
            return_text = '<div class="columns two-columns"><div class="column is-half"><p></p></div><div class="column is-half"><p></p></div></div>';
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
    });
})();