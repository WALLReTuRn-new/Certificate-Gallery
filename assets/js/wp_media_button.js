$ = jQuery;
jQuery(function($) {
    var mimetype;
    $(document).ready(function(){
        $('#insert-gallery-media').click(open_media_window);
        if (getUrlParameter('page') === "convert_pdf"){
            mimetype = "'application/pdf'";
        }else{
            $.ajax({
                url: '\/wp-admin\/admin-ajax.php',
                type: 'post',
                data: {
                    action: 'get_type_gallery',
                    id: getUrlParameter('id_gallery')
                },
                dataType: 'json',
                success: function (response) {
                    mimetype = response;
                    if(mimetype === "'image'"){
                        $('#insert-gallery-media').html("Add Image FILE");
                    }else{
                        $('#insert-gallery-media').html("Add PDF File");
                    }
                }
            });
        }


    });
    $('#TypeGallerySelect').on('change',function(){
        $.ajax({
            url: '\/wp-admin\/admin-ajax.php',
            type: 'post',
            data: {
                action: 'update_type_gallery',
                id: getUrlParameter('id_gallery'),
                type_values: this.value
            },
            dataType: 'json',
            success: function (response) {
                if(response === 'true'){
                    location.reload();
                }
            }
        });
       // location.reload();
    })
    function open_media_window() {
        if (this.window === undefined) {
            this.window = wp.media({
                title: 'Add Files',
                //library: {type: 'application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.ms-word.document.macroEnabled.12,application/vnd.ms-word.template.macroEnabled.12,application/vnd.oasis.opendocument.text,application/vnd.apple.pages,application/pdf,application/vnd.ms-xpsdocument,application/oxps,application/rtf,application/wordperfect,application/octet-stream'},
                library: {type:mimetype},
                multiple: false,
                button: {text: 'Add to Gallery'}
            });
            var self = this;
            this.window.on('select', function() {
                var gettextarea = $("#ShortcodeInGallery");
                var CurrentValue = gettextarea.val();
                var inserstring;
                var first = self.window.state().get('selection').first().toJSON();

                //var inserstring = wp.media.editor.insert('[download id="' + first.id + '"]');
                if(!gettextarea.val()){
                    inserstring = '[download id="' + first.id + '"]';
                }else{
                   inserstring = ',[file id=' + first.id + ']';
                }
                if (getUrlParameter('page') === "certificates_gallery" && getUrlParameter('action') === "edit") {
                    var newValue = CurrentValue + inserstring;
                    gettextarea.val(newValue);
                }
                if (getUrlParameter('page') === "convert_pdf"){

                    $.ajax({
                        url: '\/wp-admin\/admin-ajax.php',
                        type: 'post',
                        data: {
                            action: 'convert_pdf_from_media',
                            id_of_file: first.id,
                            imgBase64:  __CANVAS.toDataURL()
                        },
                        dataType: 'json',
                        success: function (response) {
                            var urlfromoutsideurl = first.url;

                            //$("#file-to-upload").val(urlfromoutsideurl);
                            $("#file-to-upload").attr('value',urlfromoutsideurl);
                            //$("#file-to-upload").trigger('click');

                            fetch(urlfromoutsideurl)
                                .then(res => res.blob()) // Gets the response and returns it as a blob
                                .then(blob => {
                                    // Here's where you get access to the blob
                                    // And you can use it for whatever you want
                                    // Like calling ref().put(blob)
                                    // Here, I use it to make an image appear on the page
                                    let objectURL = URL.createObjectURL(blob);
                                    //let myImage = new Image();
                                    //myImage.src = objectURL;
                                    //document.getElementById('myImg').appendChild(myImage)
                                    $("#geturltomediaupload").text(urlfromoutsideurl);
                                    $("#idfrommedia").text(first.id);
                                    showPDF(objectURL);
                                });

                        }
                    });
                }

            });
        }
        this.window.open();
        return false;
    }

    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = window.location.search.substring(1),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
            }
        }
        return false;
    };
});