(function() {
    tinymce.PluginManager.add( 'columns3', function( editor, url ) {
        editor.addButton('columns3', {
            title: 'Ajout 3 colonnes',
            cmd: 'columns3',
            icon: 'table'
        });

        editor.addCommand('columns3', function() {
            var selected_text = editor.selection.getContent({
                'format': 'html'
            });
            if (selected_text.length) {
                alert( 'On insère le tableau SANS texte' );
                return;
            }
            return_text = '<div class="columns three-columns"><div class="column is-4"><p></p></div><div class="column is-4"><p></p></div><div class="column is-4"><p></p></div></div>';
            editor.execCommand('mceReplaceContent', false, return_text);
            return;
        });
    });
})();