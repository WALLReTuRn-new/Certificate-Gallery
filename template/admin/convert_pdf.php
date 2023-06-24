<?php
//require_once( Classes_DIR_PATH.'/Pdf.php');

//$pdfPath = Pdfs_Dir_Path . '/CERTIFIKAT_LG_2022.pdf';
//$imagePath = Images_Dir_Path . '/convertedpdf.jpg';


//$pdf = new Spatie\PdfToImage\Pdf($pdfPath);
//$pdf->saveImage($imagePath);
//$imagick = new Imagick();

// Reads image from PDF
//$imagick->readImage($pdfPath);
// Writes an image or image sequence Example- converted-0.jpg, converted-1.jpg
//$imagick->writeImages($imagePath, false);
global $wpdb;
$sql = "SELECT * FROM `{$wpdb->prefix}certificate_gallery_assets`";

$GetAllConvertPdfs = $wpdb->get_results($sql);
//print_r($GetAllConvertPdfs);


?>
<style type="text/css">

    #geturltomediaupload,#idfrommedia{
        display: none;
    }
    #upload-button {
        width: 150px;
        display: block;
        margin: 20px auto;
    }

    #file-to-upload {
        display: none;
    }

    #pdf-main-container {
        width: 400px;
        margin: 20px auto;
    }

    #pdf-loader {
        display: none;
        text-align: center;
        color: #999999;
        font-size: 13px;
        line-height: 100px;
        height: 100px;
    }

    #pdf-contents {
        display: none;
    }

    #pdf-meta {
        overflow: hidden;
        margin: 0 0 20px 0;
    }

    #pdf-buttons {
        float: left;
    }

    #page-count-container {
        float: right;
    }

    #pdf-current-page {
        display: inline;
    }

    #pdf-total-pages {
        display: inline;
    }

    #pdf-canvas {
        border: 1px solid rgba(0,0,0,0.2);
        box-sizing: border-box;
    }

    #page-loader {
        height: 100px;
        line-height: 100px;
        text-align: center;
        display: none;
        color: #999999;
        font-size: 13px;
    }

    #download-image {
        width: 150px;
        display: block;
        margin: 20px auto 0 auto;
        font-size: 13px;
        text-align: center;
    }

</style>
<div class="container-fluid">

    <h1 class="text-center"><?php echo SUBMENU_CONVERT_TITLE." to Image (.jpg)";?></h1>
    <div class="text-center"><?php do_action( 'add_gallery_button','gallery_media_button');?></div>
    <input type="file" id="file-to-upload" value="dasdsa"/>dasds

    <div id="pdf-main-container">
        <div id="pdf-loader">Loading document ...</div>
        <div id="pdf-contents">
            <div id="pdf-meta" style="display: none;">
                <div id="pdf-buttons">
                    <button id="pdf-prev">Previous</button>
                    <button id="pdf-next">Next</button>
                </div>
                <div id="page-count-container">Page <div id="pdf-current-page"></div> of <div id="pdf-total-pages"></div></div>
            </div>
            <canvas id="pdf-canvas" width="400"></canvas>
            <div id="page-loader">Loading page ...</div>
            <!--<a id="download-image" href="#">Download PNG</a>-->
            <button id="saveconvert" class="btn btn-success form-control">SAVE</button>
            <div id="container-file-progress-bar" class="row align-items-center">
                <div class="col">
                    <div class="progress">
                        <div id="file-progress-bar" class="progress-bar"></div>
                    </div>
                </div>
            </div>
            <div class="row text-center">
                <div class="col">
                    <div id="uploaded_file"></div>
                </div>
            </div>
        </div>

    </div>

    <p id="geturltomediaupload"></p>
    <p id="idfrommedia"></p>
    <table id="myTableGallery" cellpadding="0" cellspacing="0" border="0" class="datatable table table-striped table-bordered">
        <thead>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>["shortcode"]</th>
            <th>Download (image / pdf)</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </thead>
        <tbody>
        <?php
        $plugin_dir_path = WP_PLUGIN_URL . '/certificates_gallery';
        foreach ($GetAllConvertPdfs as $GetAllConvertPdf):
	        //print_r($GetAllConvertPdf->path_to_thumb_image);
	        //print_r($GetAllConvertPdf->path);
	        //print_r($GetAllConvertPdf->ID);
            ?>
            <tr class="gradeA">
                <td><img src="<?php echo $plugin_dir_path."/images"."/".$GetAllConvertPdf->path_to_thumb_image;?>" width="50" alt="..." class="img-thumbnail"></td>
                <td><?php echo $GetAllConvertPdf->name;?></td>
                <td><?php echo "[file id=".$GetAllConvertPdf->idfrommedia."]";?></td>
                <td><a href="<?php echo $plugin_dir_path."/images"."/".$GetAllConvertPdf->path_to_thumb_image;?>" download>Images</a> / <a href="<?php echo $plugin_dir_path."/pdf"."/".$GetAllConvertPdf->path;?>" download>Pdf</a></td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
	        <?php
	        //$plugin_dir_path = plugin_dir_url( __DIR__ ).'images/placeholder.png';
            ?>
        <?php endforeach; ?>


        </tbody>
        <tfoot>
        <tr>
            <th>Image</th>
            <th>Name</th>
            <th>["shortcode"]</th>
            <th>Download (image / pdf)</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
        </tfoot>
    </table>


</div>

<script>
    $(document).ready( function () {
        $('#myTableGallery').DataTable();
    } );

    $('#saveconvert').on('click',function(){
        var ajax_url = '<?php echo admin_url( "admin-ajax.php" ); ?>';
        form_data = new FormData();
        form_data.append('action', 'save_convert_pdf');
        form_data.append('file', $("#file-to-upload").prop('files')[0]);
        form_data.append('filefromurl',$("#geturltomediaupload").text());
        form_data.append('idfrommedia',$("#idfrommedia").text());
        form_data.append('imgBase64',  __CANVAS.toDataURL());
        $.ajax({
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(element) {
                    if (element.lengthComputable) {
                        var percentComplete = ((element.loaded / element.total) * 100);
                        $("#file-progress-bar").width(percentComplete + '%');
                        $("#file-progress-bar").html(percentComplete+'%');
                    }
                }, false);
                return xhr;
            },
            type: "POST",
            url: ajax_url,
            contentType: false,
            processData: false,
            data: form_data,
            dataType: "json",
            beforeSend: function(){
                $("#file-progress-bar").width('0%');
            },
            success: function (json) {
                console.log(json);
                if(json == 'success'){
                    $('#uploaded_file').html('<p style="color:#28A74B;">File has uploaded successfully!</p>');
                    window.setTimeout(function(){location.reload()},3000)
                }else if(json == 'failed'){
                    $('#uploaded_file').html('<p style="color:#EA4335;">Please select a valid file to upload.</p>');
                }
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }

        }).done(function(o) {
           // console.log('saved');
        });
    });


</script>
<script>

    var __PDF_DOC,
        __CURRENT_PAGE,
        __TOTAL_PAGES,
        __PAGE_RENDERING_IN_PROGRESS = 0,
        __CANVAS = $('#pdf-canvas').get(0),
        __CANVAS_CTX = __CANVAS.getContext('2d');

    function showPDF(pdf_url) {
        console.log('pdf_url: '+pdf_url);
        $("#pdf-loader").show();

        PDFJS.getDocument({ url: pdf_url }).then(function(pdf_doc) {
            __PDF_DOC = pdf_doc;
            __TOTAL_PAGES = __PDF_DOC.numPages;

            // Hide the pdf loader and show pdf container in HTML
            $("#pdf-loader").hide();
            $("#pdf-contents").show();
            $("#pdf-total-pages").text(__TOTAL_PAGES);

            // Show the first page
            showPage(1);
        }).catch(function(error) {
            // If error re-show the upload button
            $("#pdf-loader").hide();
            $("#upload-button").show();

            alert(error.message);
        });;
    }

    function showPage(page_no) {
        __PAGE_RENDERING_IN_PROGRESS = 1;
        __CURRENT_PAGE = page_no;

        // Disable Prev & Next buttons while page is being loaded
        $("#pdf-next, #pdf-prev").attr('disabled', 'disabled');

        // While page is being rendered hide the canvas and show a loading message
        $("#pdf-canvas").hide();
        $("#page-loader").show();
        $("#download-image").hide();
        $("#saveconvert").hide();


        // Update current page in HTML
        $("#pdf-current-page").text(page_no);

        // Fetch the page
        __PDF_DOC.getPage(page_no).then(function(page) {
            // As the canvas is of a fixed width we need to set the scale of the viewport accordingly
            var scale_required = __CANVAS.width / page.getViewport(1).width;

            // Get viewport of the page at required scale
            var viewport = page.getViewport(scale_required);

            // Set canvas height
            __CANVAS.height = viewport.height;

            var renderContext = {
                canvasContext: __CANVAS_CTX,
                viewport: viewport
            };

            // Render the page contents in the canvas
            page.render(renderContext).then(function() {
                __PAGE_RENDERING_IN_PROGRESS = 0;

                // Re-enable Prev & Next buttons
                $("#pdf-next, #pdf-prev").removeAttr('disabled');

                // Show the canvas and hide the page loader
                $("#pdf-canvas").show();
                $("#page-loader").hide();
                $("#download-image").show();
                $("#saveconvert").show();

            });
        });
    }

    // Upon click this should should trigger click on the #file-to-upload file input element
    // This is better than showing the not-good-looking file input element
    $("#upload-button").on('click', function() {
        $("#file-to-upload").trigger('click');
    });


    // When user chooses a PDF file
    $("#file-to-upload").on('change', function() {

        // Validate whether PDF
        if(['application/pdf'].indexOf($("#file-to-upload").get(0).files[0].type) == -1) {
            alert('Error : Not a PDF');
            return;
        }

        $("#upload-button").hide();

        // Send the object url of the pdf
        showPDF(URL.createObjectURL($("#file-to-upload").get(0).files[0]));

    });

    // Previous page of the PDF
    $("#pdf-prev").on('click', function() {
        if(__CURRENT_PAGE != 1)
            showPage(--__CURRENT_PAGE);
    });



    // Next page of the PDF
    $("#pdf-next").on('click', function() {
        if(__CURRENT_PAGE != __TOTAL_PAGES)
            showPage(++__CURRENT_PAGE);
    });

    // Download button
    $("#download-image").on('click', function() {
        $(this).attr('href', __CANVAS.toDataURL()).attr('download', 'page.png');
    });

</script>
<script type="text/javascript" src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
