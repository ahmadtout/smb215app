CKEDITOR.plugins.add( 'mycode', {
    icons: 'mycode',
    init: function( editor ) {
        editor.addCommand( 'mycode', new CKEDITOR.dialogCommand( 'mycodeDialog' ) );
        editor.ui.addButton( 'Mycode', {
            label: 'Insert MyCode',
            command: 'mycode',
            toolbar: 'insert'
        });

        CKEDITOR.dialog.add( 'mycodeDialog', this.path + 'dialogs/mycode.js' );
    }
});