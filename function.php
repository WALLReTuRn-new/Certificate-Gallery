<?php

// ShortCode Gallery
add_shortcode('gallery', 'show_gallery_shortcode');
function show_gallery_shortcode($gallery_atts){
	global $wpdb;
	// Атрибуты шорткода
	$gallery_atts = shortcode_atts(array(
		'id' => '',
		'href' => '',
		'title' => '',
		'type' => 'doc',
		'size' => '',
		'parent' => '',
		'h3' => 'no',
	) , $gallery_atts, 'gallery');
	$GalleryId = $gallery_atts['id']; // ID Gallery
	$sql = "SELECT * FROM `{$wpdb->prefix}certificate_gallery` WHERE id_gallery = '".$GalleryId."'";
	$GetAllGallerys = $wpdb->get_results($sql);
	foreach( $GetAllGallerys as $key => $row) {
		$SHORTCODE = $row->shortcode_in_gallery;
	    $title = $row->name_gallery;
		$DescriptionGallery = $row->description_gallery;

	}
	$shortcodes = json_decode($SHORTCODE, TRUE);
	$output = '<div class="gallery-pdf"><div class="row"><div class="col-sm-12"><h3 class="mb-4">'.$title.'</h3><p class="mb-5">'.$DescriptionGallery.'</p></div>';
	foreach ( $shortcodes as $value ) {
		$output .= do_shortcode($value);
	}
	$output .= '</div></div>';
	return $output;
}
add_shortcode('file', 'ShowFile');
function ShowFile($showfile_atts){
	global $wpdb;
	wp_enqueue_style( 'bootstrap-gallery' );
	wp_enqueue_style( 'front-end-gallery' );
	// Атрибуты шорткода
	$showfile_atts = shortcode_atts(array(
		'id' => '',
		'text'=>'',
		'href' => '',
		'title' => '',
		'type' => 'doc',
		'size' => '',
		'parent' => '',
		'h3' => 'no',
	) , $showfile_atts, 'file');


	//print_r($showfile_atts);
	$dwn_id = $showfile_atts['id']; // ID файла
	$href = $showfile_atts['href']; // Ссылка на файл
	$title = $showfile_atts['title']; // Название файла
	$type = $showfile_atts['type']; // Формат файла
	$size = $showfile_atts['size']; // Размер файла
	$parent = $showfile_atts['parent']; // Ссылка на родительскую статью файла
	$h3 = $showfile_atts['h3']; // Обернуть название файла в H3 (yes/no)



	if ($dwn_id)
	{ // Если есть id то выводим все данные на автомате
		$attachment = get_post( $dwn_id );
		$description = $attachment->post_content;

		$href = wp_get_attachment_url($dwn_id);
		$title = get_the_title($dwn_id);
		$size = size_format(filesize(get_attached_file($dwn_id)) , 2);
	}

	if ($parent) $title = "<a href=" . $parent . ">" . $title . "</a>"; // Обёртываем название файла в ссылку
	if ($h3 == "yes") $title = '<h3>' . $title . '</h3>'; // Обёртываем название файла в H3
	if($size) $p_size = '<p class="download-file-size">velikost souboru: <i class="fas fa-hdd ml-3"></i> '.$size.'</p>'; // temp

	// Удаляем слово "скачать" из названия файла
	$title_replace = array(
		'Stáhnout' => '',
		'образец' => 'Образец'
	);
	$title = str_replace(array_keys($title_replace) , $title_replace, $title);
	$sql = "SELECT * FROM `{$wpdb->prefix}certificate_gallery_assets` WHERE idfrommedia = '".$dwn_id."'";
	$GetFilesToGallery = $wpdb->get_results($sql);
	//print_r($GetFilesToGallery);
	foreach ($GetFilesToGallery as $GetFileToGallery):
		$PDFPATH = $GetFileToGallery->path;
		$IMAGEPATH = $GetFileToGallery->path_to_thumb_image;
	endforeach;
	$plugin_dir_path = WP_PLUGIN_URL . '/certificates_gallery';
	$endpdf = $plugin_dir_path."/pdf"."/".$PDFPATH;
	$endimage = $plugin_dir_path."/images"."/".$IMAGEPATH;


	//$permalink = wp_get_attachment_url($dwn_id);

	// if the result is a PDF, link directly to the file not the attachment page
	//$permalink = esc_url(wp_get_attachment_url( $dwn_id ));
	$permalink = get_permalink($dwn_id);



	// Выводим результат шорткода
	$output = <<<HTML
  <div class="col-sm-3 mb-3"><a class="d-block h-100 p-4 rounded border" href="{$permalink}" target="_blank">
  <h5 class="mt-0">{$title}</h5>
  <img class="img-fluid" src="{$endimage}" alt="{$title}">
  <p class="description mb-5 my-5">{$description}</p>
  </a>
  
  </div>        

HTML;


	return $output;
}


add_action('init', 'my_register_styles');

function my_register_styles() {
	wp_register_style( 'bootstrap-gallery', plugins_url('assets/css/Bootstrap-4.5.2/bootstrap.min.css',__FILE__ ),array(), '4.5.2');
	wp_register_style( 'front-end-gallery', plugins_url('assets/css/front-end.css',__FILE__ ),array(), '0.0.1');
}


add_action('wp_ajax_submit_form', 'submit_form');
add_action('wp_ajax_nopriv_submit_form', 'submit_form');
function submit_form(){
	global $wpdb;

	//$json = $_POST['dataString'];
	foreach($_POST['dataString'] as $data):
		$sendData[$data['name']] = $data['value'];
	endforeach;
	$arrayComma = explode(',', $sendData['ShortcodeInGallery']);
	$i = 0;
	foreach($arrayComma as $vals):

     $test[]= $vals;
	endforeach;

	$sendetjson = $test;

	if($wpdb->update("{$wpdb->prefix}certificate_gallery", array(
			"name_gallery" =>$sendData['InputName'],
			"description_gallery" =>$sendData['DescriptionGallery'],
			"type_gallery" =>$sendData['TypeGallerySelect'],
			"shortcode_in_gallery" => json_encode($sendetjson)
		), array('id_gallery'=>$_POST['id_gallery'])) == FALSE ):
		$sucess = 'false';
	else:
		if($wpdb->update("{$wpdb->prefix}certificate_gallery_list", array(
				"name" =>$sendData['InputName']
			), array('ID'=>$_POST['id_gallery'])) == FALSE):
			$sucess = 'false';
		else:
			$sucess = 'true';
		endif;
	endif;

//$json['InputName']
	wp_send_json(json_encode($sucess));
}

add_action('wp_ajax_get_type_gallery', 'get_type_gallery');
add_action('wp_ajax_nopriv_get_type_gallery', 'get_type_gallery');
function get_type_gallery(){

	global $wpdb;
	$sql = "SELECT gt.mimetype FROM `{$wpdb->prefix}certificate_gallery` cg LEFT JOIN `{$wpdb->prefix}certificate_gallery_type` gt ON cg.type_gallery = gt.type_id WHERE id_gallery = '".$_POST['id']."'";
	$GetTypeofGallery = $wpdb->get_results($sql);
	foreach($GetTypeofGallery as $val):
	$mimetype = $val->mimetype;
	endforeach;
	$json = $mimetype;
	wp_send_json($json);
}

add_action('wp_ajax_update_type_gallery', 'update_type_gallery');
add_action('wp_ajax_nopriv_update_type_gallery', 'update_type_gallery');
function update_type_gallery(){
	global $wpdb;
	if($wpdb->update("{$wpdb->prefix}certificate_gallery", array(
		"type_gallery" => $_POST['type_values']
	), array('id_gallery'=>$_POST['id'])) == FALSE):
		$sucess = 'false';
	else:
		$sucess = 'true';

	endif;

	wp_send_json($sucess);
}




add_action('wp_ajax_convert_pdf_from_media', 'convert_pdf_from_media');
add_action('wp_ajax_nopriv_convert_pdf_from_media', 'convert_pdf_from_media');

function convert_pdf_from_media(){

	// Атрибуты шорткода
	$showfile_atts = shortcode_atts(array(
		'id' => $_POST['id_of_file'],
		'href' => '',
		'title' => '',
		'type' => 'doc',
		'size' => '',
		'parent' => '',
		'h3' => 'no',
	) , 'file');
	$dwn_id = $showfile_atts['id']; // ID файла
	$href = $showfile_atts['href']; // Ссылка на файл
	$href = wp_get_attachment_url($dwn_id);

	$name = basename($href);
	list($txt, $ext) = explode(".", $name);
	$name = $txt.time();
	$name = $name.".".$ext;
	$pdfPath = Pdfs_Dir_Path.'/';

	//check if the files are only image / document
	if($ext == "jpg" or $ext == "png" or $ext == "gif" or $ext == "doc" or $ext == "docx" or $ext == "pdf") {
//here is the actual code to get the file from the url and save it to the uploads folder
//get the file from the url using file_get_contents and put it into the folder using file_put_contents
		$upload = file_put_contents( $pdfPath . $name, file_get_contents( $href ) );
//check success
		if ( $upload ):
			$success = "true";
		else:
			$success = "false";
		endif;
	}
	//$_POST['imgBase64']
	wp_send_json($success);
}








//$imagePath = Images_Dir_Path . '/convertedpdf.jpg';
//new_gallery save Function
add_action('wp_ajax_save_convert_pdf', 'save_convert_pdf');
add_action('wp_ajax_nopriv_save_convert_pdf', 'save_convert_pdf');
function save_convert_pdf(){
	global $wpdb;

	//$json = array();
	$pdfPath = Pdfs_Dir_Path.'/';
	$imagePath = Images_Dir_Path . '/';
	if(isset($_FILES['file'])):
			//$old_file = $_FILES['file']['name'];
			$new_file = date('Y_m_d_His')."-".$_FILES['file']['name'];
			if(move_uploaded_file($_FILES['file']['tmp_name'], $pdfPath . $new_file) && file_put_contents($imagePath.$new_file.".jpg", file_get_contents($_POST['imgBase64']))){
				$json = 'success';
			} else {
				$json = 'failed';
			}
			if($json == 'success'):
				$wpdb->insert("{$wpdb->prefix}certificate_gallery_assets", array(
					"name" => $_FILES['file']['name'],
					"path" => $new_file,
					"path_to_thumb_image" => $new_file.".jpg",
					"owner" => 1
				));
			endif;

	else:

		if(isset($_POST['filefromurl'])):
			$tester = $_POST['filefromurl'];
			$url = $_POST['filefromurl'];
			$file_name = basename($url);
			$new_file = date('Y_m_d_His')."-".$file_name;
			if(file_put_contents($imagePath.$new_file.".jpg", file_get_contents($_POST['imgBase64']))){
				$json = 'success';
			} else {
				$json = 'failed';
			}
			if($json == 'success'):
				$wpdb->insert("{$wpdb->prefix}certificate_gallery_assets", array(
					"name" => $file_name,
					"path" => $new_file,
					"path_to_thumb_image" => $new_file.".jpg",
					"idfrommedia" => $_POST['idfrommedia'],
					"owner" => 1
				));
			endif;
		else:
			$json = 'No have File';
		endif;

	endif;
	wp_send_json($json);
}