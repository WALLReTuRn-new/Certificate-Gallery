<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
global $wpdb;
$sql = "SELECT * FROM `{$wpdb->prefix}certificate_gallery_list` cgl LEFT JOIN `{$wpdb->prefix}certificate_gallery` cg ON cgl.ID = cg.id_gallery";
$GetAllGallerys = $wpdb->get_results($sql);
do_action('header_gallery');
?>
<div id="base_content_gallery" class="container-fluid">
    <h1 class="text-center"><?php echo PLUGIN_NAME;?></h1>
    <!--<div id="add-new-cert-gallery" class="text-right"><a href="admin.php?page=new_gallery" target="_parent"><button type="button" class="btn btn-success"><i class="fa fa-plus-circle"></i> Add new Gallery</button></a></div>-->
    <table class="Certificate_table table table-striped text-center">
        <thead>
            <tr class="Certificate_title">
                <td>No</td>
                <td>Certificate Title</td>
                <td>Certificate Template</td>
                <td>ShortCode</td>
                <td>Certificates</td>
                <td>Live Preview</td>
                <td>Edit</td>
                <td>Delete</td>
            </tr>
        </thead>
        <tbody>
        <?php
        foreach($GetAllGallerys as $GetAllGallery): ?>
            <?php
	        if(isset($GetAllGallery->shortcode_in_gallery)): $countfileingallery = count(json_decode($GetAllGallery->shortcode_in_gallery,true)); else: $countfileingallery = 0; endif;
	        ?>
            <tr>
                <th scope="row"><?php echo $GetAllGallery->ID;?></th>
                <td><?php echo $GetAllGallery->name;?></td>
                <td><?php if($GetAllGallery->cert_template == 1):echo 'Default'; else: endif; ?></td>
                <td><?php echo $GetAllGallery->shortcode;?></td>
                <td><?php echo $countfileingallery;?></td>
                <td><i class="fa fa-eye" style="color:green;"></i></td>
                <td><a href="<?php echo 'admin.php?page='.PLUGIN_SLAG.'&action=edit'.'&id_gallery='.$GetAllGallery->ID;?>"><i class="fa fa-pencil" style="color:#FF4500;"></i></a></td>
                <td><i class="fa fa-minus-circle" style="color:red;"></i></td>
            </tr>
        <?php endforeach;?>
        </tbody>
    </table>
	<?php
	do_action('footer_gallery');
	?>
</div>
