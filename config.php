<?php

/* Enable debugging */
/*
ini_set('display_startup_errors',1);
ini_set('display_errors',1);
error_reporting(-1);
*/
//***************** Config Settings ********************//

define( 'Root_Dir_Name', 'certificates_gallery');
define( 'Root_Dir_Path', plugin_dir_path( __FILE__ ) );
define( 'Classes_DIR_PATH' , Root_Dir_Path.'classes' );
define( 'Images_Dir_Path', Root_Dir_Path.'images' );
define( 'Pdfs_Dir_Path', Root_Dir_Path.'pdf' );
define( 'Template_Dir_Path', Root_Dir_Path.'template' );
define( 'ADMIN_VIEWS_DIR_PATH', Template_Dir_Path.'/admin' );
define( 'FRONT_VIEWS_DIR_PATH', Template_Dir_Path.'/front' );

global $wpdb;

define( 'PLUGIN_PREFIX', 'certgal');
define( 'DB_PREFIX'     , $wpdb->prefix.PLUGIN_PREFIX.'_' );

define("PLUGIN_NAME","Certificate Gallery");
define("PLUGIN_SLAG","certificates_gallery");


define("SUBMENU_CONVERT_TITLE","Convert PDF");
define("SUBMENU_CONVERT_SLUG","convert_pdf");

define("ADD_NEW_GALLERY","New Gallery");
define("ADD_NEW_GALLERY_SLUG","new_gallery");

define("EDIT_GALLERY_TITLE","Edit Gallery");
define("EDIT_GALLERY_SLUG","edit_gallery");



define("SUBMENU_SETTING_TITLE","Settings");
define("SUBMENU_SETTING_SLUG","settings");