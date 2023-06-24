<?php

/**
 * Plugins primary file, in charge of including all other dependencies.
 *
 * @package websitetoyou
 *
 * @wordpress-plugin
 * Plugin Name: Certificate Gallery
 * Plugin URI: https://www.websitetoyou.cz/index.php?route=wordpress/plugins
 * Description: Certificate Gallery to Custom Page.
 * Author: WALLReTuRn
 * Version: 1.0.5
 * Author URI: https://www.websitetoyou.cz/index.php?route=wordpress/plugins
 * Text Domain: certificate-gallery
 */
 
 
 
 
CONST FILE_PATH_DATA = "/wp-content/plugins/certificates_gallery/data/";
CONST FILE_PATH_RESOURCES = "/wp-content/plugins/certificates_gallery/resources/";
//Load configs
require_once( dirname(__FILE__) . '/config.php');


require_once( dirname(__FILE__) . '/function.php');



//function certificates_gallery() {
//   add_menu_page('Certificate Gallery', 'Certificate Gallery', 'administrator', 'certificates_gallery', 'certificates_gallery_index');
//}
//function certificates_gallery_index() {
//   echo "certificates_gallery";
//}

add_action('admin_enqueue_scripts', 'Widget_Style');

function Widget_Style() {

    //wp_register_style('certificate_gallery', Assets_Dir_Path . '/css/style.css',array(), '0.0.1');
    
    
   
    wp_enqueue_style('certificate-gallery',  plugins_url('assets/css/style.css',__FILE__ ),array(), '0.0.1');
    wp_enqueue_style('certificate-bootstrap-min',  plugins_url('assets/css/Bootstrap-4.5.2/bootstrap.min.css',__FILE__ ),array(), '4.5.2');
    wp_enqueue_style('certificate-fontawesome',  plugins_url('assets/css/fontawesome-free-5.12.0-web/css/all.min.css',__FILE__ ),array(), '5.12.0');

	//wp_enqueue_script('jQuery',  'https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js',array(), '2.2.4');
	//wp_enqueue_script('jQuery',  'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',array(), '3.5.1');
	wp_enqueue_media();
	wp_enqueue_script('media_button_gallery',  plugins_url('assets/js/wp_media_button.js',__FILE__ ),array(), '0.0.1');

	wp_enqueue_script('common_script_gallery',  plugins_url('assets/js/commons.js',__FILE__ ),array(), '0.0.1');


	if(isset($_GET['page'])):
		if($_GET['page'] == 'convert_pdf'):
			wp_enqueue_style('datatable-style',  '//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css'  ,array(), '1.11.5');
			wp_enqueue_script('pdf',  plugins_url('assets/js/pdf_convert/pdf.js',__FILE__ ),array(), '0.0.1');
			wp_enqueue_script('pdf_worker',  plugins_url('assets/js/pdf_convert/pdf.worker.js',__FILE__ ),array(), '0.0.1');
		endif;
	endif;
             
    //wp_register_style('Total_Soft_Portfolio2', plugins_url('/CSS/Filt_popup.min.css',__FILE__ ));
    //wp_enqueue_style('Total_Soft_Portfolio');
    //wp_enqueue_style('Total_Soft_Portfolio2');
    //wp_register_script('Total_Soft_Portfolio',plugins_url('/JS/Total-Soft-Portfolio-Widget.js',__FILE__),array('jquery','jquery-ui-core'));
    //wp_localize_script('Total_Soft_Portfolio', 'object', array('ajaxurl' => admin_url('admin-ajax.php')));
    //wp_enqueue_script('Total_Soft_Portfolio');
    //wp_enqueue_script("jquery");
    //wp_register_style('fontawesome-css', plugins_url('/CSS/totalsoft.css', __FILE__));
    //wp_enqueue_style('fontawesome-css');
}

//add_action('widgets_init', 'Widget_Reg');

//function Widget_Reg() {
 //   register_widget('Certificate_Gallery');
//}

//Register action hooks

add_action('admin_menu', 'certificates_gallery_admin_menu_action');

function certificates_gallery_admin_menu_action() {
    setup_admin_menu();
}

//Internal functionality
function setup_admin_menu() {
    add_menu_page(PLUGIN_NAME, PLUGIN_NAME, 'administrator', PLUGIN_SLAG, "admin_certificate_page", 'dashicons-portfolio', 76);
	add_submenu_page(PLUGIN_SLAG, ADD_NEW_GALLERY, ADD_NEW_GALLERY, 'administrator', ADD_NEW_GALLERY_SLUG, 'add_new_gallery');
    add_submenu_page(PLUGIN_SLAG, SUBMENU_CONVERT_TITLE, SUBMENU_CONVERT_TITLE, 'administrator', SUBMENU_CONVERT_SLUG, 'admin_certificate_convert_pdf');
    // add_submenu_page(CRP_PLUGIN_SLAG, CRP_SUBMENU_GALLERIES_TITLE, CRP_SUBMENU_GALLERIES_TITLE, 'edit_posts', CRP_SUBMENU_GALLERIES_SLUG, 'crp_admin_galleries_page');
    // add_submenu_page(CRP_PLUGIN_SLAG, CRP_SUBMENU_CLIENT_LOGOS_TITLE, CRP_SUBMENU_CLIENT_LOGOS_TITLE, 'edit_posts', CRP_SUBMENU_CLIENT_LOGOS_SLUG, 'crp_admin_client_logos_page');
    // add_submenu_page(CRP_PLUGIN_SLAG, CRP_SUBMENU_TEAMS_TITLE, CRP_SUBMENU_TEAMS_TITLE, 'edit_posts', CRP_SUBMENU_TEAMS_SLUG, 'crp_admin_teams_page');
    // add_submenu_page(CRP_PLUGIN_SLAG, CRP_SUBMENU_PRODUCT_CATALOGS_TITLE, CRP_SUBMENU_PRODUCT_CATALOGS_TITLE, 'edit_posts', CRP_SUBMENU_PRODUCT_CATALOGS_SLUG, 'crp_admin_catalogs_page');
    add_submenu_page(PLUGIN_SLAG, SUBMENU_SETTING_TITLE, SUBMENU_SETTING_TITLE, 'administrator', SUBMENU_SETTING_SLUG, 'settings');
}
function header_gallery() {
	// Your PHP goes here
	require_once(ADMIN_VIEWS_DIR_PATH . '/common/header.php');
}
add_action( 'header_gallery', 'header_gallery' );
function footer_gallery() {
	// Your PHP goes here
	require_once(ADMIN_VIEWS_DIR_PATH . '/common/footer.php');
}
add_action( 'footer_gallery', 'footer_gallery' );


function admin_certificate_page() {
	require dirname( __FILE__ ) . '/includes/media_button.php';


	if(isset($_GET['action'])):
		if($_GET['action'] == 'edit'):
			require_once(ADMIN_VIEWS_DIR_PATH . '/includes/gallery_edit.php');
		else:
			require_once(ADMIN_VIEWS_DIR_PATH . '/includes/gallery_delete.php');
		endif;
	else:
		require_once(ADMIN_VIEWS_DIR_PATH . '/index.php');
	endif;
}
function admin_certificate_convert_pdf() {

	require dirname( __FILE__ ) . '/includes/media_button.php';

	require_once(ADMIN_VIEWS_DIR_PATH . '/convert_pdf.php');
}
function add_new_gallery() {
	require_once(ADMIN_VIEWS_DIR_PATH . '/new_gallery.php');
}
function settings(){
	require dirname( __FILE__ ) . '/settings.php';
}

function Certificate_install()
	{
    require_once(dirname(__FILE__) . '/includes/install.php');
}

register_activation_hook(__FILE__, 'Certificate_install');
