<?php

// Добавляем шорткод "download"
add_shortcode('download', 'cdwp_download_shortcode');

if (!function_exists('cdwp_download_shortcode'))
{
	function cdwp_download_shortcode($cdwp_atts)
	{
		// Атрибуты шорткода
		$cdwp_atts = shortcode_atts(array(
			'id' => '',
			'href' => '',
			'title' => '',
			'type' => 'doc',
			'size' => '',
			'parent' => '',
			'h3' => 'no',
		) , $cdwp_atts, 'download');

		$dwn_id = $cdwp_atts['id']; // ID файла
		$href = $cdwp_atts['href']; // Ссылка на файл
		$title = $cdwp_atts['title']; // Название файла
		$type = $cdwp_atts['type']; // Формат файла
		$size = $cdwp_atts['size']; // Размер файла
		$parent = $cdwp_atts['parent']; // Ссылка на родительскую статью файла
		$h3 = $cdwp_atts['h3']; // Обернуть название файла в H3 (yes/no)

		if ($dwn_id)
		{ // Если есть id то выводим все данные на автомате
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
		// Выводим результат шорткода
		$output = <<<HTML
<div class="download {$type}">
    <div class="download-icon"></div>
    <div class="download-info">
        <div class="download-file-name">{$title}</div>
        {$p_size}
    </div>
    <div class="download-button-area">
        <a href="{$href}" class="download-button" target="_blank" rel="noopener noreferrer nofollow">Stáhnout</a>
    </div>

</div>
HTML;


		return $output;
	}}

// Добавляем шорткод в произвольные поля файлов
function gallery_custom_field($form_fields, $post)
{

	$form_fields['download-shorcode-filed'] = array(
		'label' => __('ShortCode') ,
		'input' => 'html',
		'html' => '<input type="text" id="attachment-details-two-column-copy-link" value="[download id=&#34;' . $post->ID . '&#34;]" readonly="">',
	);
	return $form_fields;
}

add_filter('attachment_fields_to_edit', 'gallery_custom_field', null, 2);

// Выводим кнопку "Добавить файл" над редактором
//if (get_option('gallery_media_button') == 0)
//{

//if ( function_exists( 'wp_enqueue_media' ) ) :
//	wp_enqueue_media();
//else :
	//echo "no";
//endif;





	add_action('add_gallery_button', 'gallery_media_button');
	function gallery_media_button()
	{
		echo '<a href="#" id="insert-gallery-media" class="button">Add Files</a>';
	}

//}

