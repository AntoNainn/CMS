(function () {
    tinymce.PluginManager.add('googlemaps', function (editor, url) {
        editor.addButton('googlemaps', {
            text: 'Google Maps',
            icon: false,
            onclick: function () {
                editor.windowManager.open({
                    title: 'Insérer une carte Google Maps',
                    body: [
                        {
                            type: 'textbox',
                            name: 'iframe',
                            label: 'URL de l\'iframe Google Maps',
                            value: ''
                        },
                        {
                            type: 'textbox',
                            name: 'width',
                            label: 'Largeur (ex: 600px ou 100%)',
                            value: '100%'
                        },
                        {
                            type: 'textbox',
                            name: 'height',
                            label: 'Hauteur (ex: 400px)',
                            value: '450px'
                        }
                    ],
                    onsubmit: function (e) {
                        var iframeUrl = e.data.iframe;
                        var width = e.data.width || '100%';
                        var height = e.data.height || '450px';

                        var iframeCode = '<iframe width="' + width + '" height="' + height + '" src="' + iframeUrl + '" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';

                        editor.insertContent(iframeCode);
                    }
                });
            }
        });
    });
})();