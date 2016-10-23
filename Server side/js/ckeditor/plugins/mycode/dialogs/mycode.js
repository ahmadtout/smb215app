CKEDITOR.dialog.add('mycodeDialog', function (editor) {
    return {
        title: 'Abbreviation Properties',
        minWidth: 400,
        minHeight: 200,
        contents: [
            {
                id: 'tab-pres',
                label: 'ixpers',
                elements: [
                    {
                        type: 'button',
                        id: 'ixPERS',
                        label: 'GetCode',
                        onClick: function ()
                        {
                            var table = this.id;
                            $.ajax({
                                type: "POST",
                                url: _TOOLS_DIR_ + "ixEmails/ajax.php",
                                data: {
                                    p: "ckeditor",
                                    MsgType: "getColumns",
                                    TABLE_NAME: table
                                },
                                beforeSend: function () {
                                },
                                dataType: "html",
                                success: function (data) {
                                   var x = CKEDITOR.dialog.getCurrent().getContentElement();
                                   alert(x);
                                },
                            });

                        }
                    },
                ]
            },
            {
                id: 'tab-adv',
                label: 'Advanced Settings',
                elements: [
                    {
                        type: 'text',
                        id: 'id',
                        label: 'Id'
                    }
                ]
            }
        ],
        onOk: function () {
            var dialog = this;

            var abbr = editor.document.createElement('mycode');
            abbr.setAttribute('title', dialog.getValueOf('tab-basic', 'title'));
            abbr.setText(dialog.getValueOf('tab-basic', 'mycode'));

            var id = dialog.getValueOf('tab-adv', 'id');
            if (id)
                abbr.setAttribute('id', id);

            editor.insertElement(abbr);
        }
    };
});