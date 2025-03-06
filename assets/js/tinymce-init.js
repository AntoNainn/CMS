document.addEventListener("DOMContentLoaded", function () {
    tinymce.init({
        selector: 'textarea',
        plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount code googlemaps',
        toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat | googlemaps',
    });
});

tinymce.PluginManager.add('googlemaps', function (editor, url) {
    console.log("Plugin Google Maps chargé");

    editor.ui.registry.addButton('googlemaps', {
        text: 'Google Maps',
        icon: '',  // Icône vide pour tester sans icône
        onAction: function () {
            editor.windowManager.open({
                title: 'Insérer une carte Google Maps',
                body: {
                    type: 'panel',
                    items: [
                        {
                            type: 'input',  // Valide dans TinyMCE 6.x
                            name: 'iframe',
                            label: 'URL de l\'iframe Google Maps'
                        },
                        {
                            type: 'input',
                            name: 'width',
                            label: 'Largeur (ex: 600px ou 100%)',
                            initialValue: '100%'
                        },
                        {
                            type: 'input',
                            name: 'height',
                            label: 'Hauteur (ex: 400px)',
                            initialValue: '450px'
                        }
                    ]
                },
                buttons: [
                    {
                        type: 'submit',
                        text: 'Insérer'
                    },
                    {
                        type: 'cancel',
                        text: 'Annuler'
                    }
                ],
                onsubmit: function (e) {
                    var iframeUrl = e.data.iframe;
                    var width = e.data.width || '100%';
                    var height = e.data.height || '450px';
                
                    // Notez que nous n'incluons pas d'attribut sandbox ici
                    var iframeCode = '<iframe width="' + width + '" height="' + height + '" src="' + iframeUrl + 
                                     '" style="border:0;" allowfullscreen loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>';
                
                    editor.insertContent(iframeCode);
                }
            });
        }
    });
});



