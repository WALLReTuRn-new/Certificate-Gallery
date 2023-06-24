<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $wpdb;

$sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}certificate_gallery_list` (
  `ID` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `cert_template` int(255) NOT NULL,
  `shortcode` varchar(150) NOT NULL,
  `metadata` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$sqls[] ="INSERT INTO `{$wpdb->prefix}certificate_gallery_list` (`ID`, `name`, `cert_template`, `shortcode`, `metadata`) VALUES
(1, 'Certifikáty', 1, '[gallery id=1]', ''),
(2, 'Certifikáty2', 1, '[gallery id=2]', '');";

$sqls[] ="ALTER TABLE `{$wpdb->prefix}certificate_gallery_list`
  ADD PRIMARY KEY (`ID`);";

$sqls[] ="ALTER TABLE `{$wpdb->prefix}certificate_gallery_list`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;";

//Template
$sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}certificate_gallery_template` (
  `ID` bigint(20) NOT NULL,
  `name` text NOT NULL,
  `metadata` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sqls[] = "INSERT INTO `{$wpdb->prefix}certificate_gallery_template` (`ID`, `name`, `metadata`) VALUES
(1, 'Default', '');";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_template`
  ADD PRIMARY KEY (`ID`);";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_template`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;";

$sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}certificate_gallery_assets` (
  `ID` bigint(20) NOT NULL,
  `idfrommedia` int(150) NOT NULL,
  `path` text NOT NULL,
  `path_to_thumb_image` text NOT NULL,
  `name` text NOT NULL,
  `owner` int(11) NOT NULL,
  `activities` text NOT NULL,
  `comments` text NOT NULL,
  `access` text NOT NULL,
  `metadata` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_assets`
  ADD PRIMARY KEY (`ID`);";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_assets`
  MODIFY `ID` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=32;
COMMIT;";
//$sqls[] = "";
$sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}certificate_gallery_type` (
  `type_id` int(255) NOT NULL,
  `type_name` varchar(100) NOT NULL,
  `type_slug` varchar(255) NOT NULL,
  `mimetype` varchar(150) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sqls[] = "INSERT INTO `{$wpdb->prefix}certificate_gallery_type` (`type_id`, `type_name`, `type_slug`, `mimetype`) VALUES
(1, 'Image Gallery', 'image_gallery', 'image'),
(2, 'Pdf Gallery', 'pdf_gallery', 'application/pdf');";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_type`
  ADD PRIMARY KEY (`type_id`);";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery_type`
  MODIFY `type_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;";


$sqls[] = "CREATE TABLE IF NOT EXISTS `{$wpdb->prefix}certificate_gallery` (
  `id_gallery` int(25) NOT NULL,
  `type_gallery` int(10) NOT NULL,
  `name_gallery` varchar(125) NOT NULL,
  `description_gallery` varchar(225) NOT NULL,
  `theme_gallery` int(10) NOT NULL,
  `shortcode_in_gallery` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
$sqls[] = "INSERT INTO `{$wpdb->prefix}certificate_gallery` (`id_gallery`, `type_gallery`, `name_gallery`, `description_gallery`, `theme_gallery`, `shortcode_in_gallery`) VALUES
(1, 2, 'Certifikáty', 'Certifikáty', 1, '[2]'),
(2, 2, 'Certifikáty2', 'Certifikáty second', 1, '[2]');";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery`
  ADD PRIMARY KEY (`id_gallery`);";
$sqls[] = "ALTER TABLE `{$wpdb->prefix}certificate_gallery`
  MODIFY `id_gallery` int(25) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;";


//$sqls[] = "";
//$sqls[] = "";
//$sqls[] = "";


require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
foreach($sqls as $sql){
	$wpdb->query($sql);
	///dbDelta($sql);
}


//$this->RegisterPostTypeTaxonomy();
flush_rewrite_rules();
//self::createDir();