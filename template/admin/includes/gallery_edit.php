<?php
global $wpdb;
$sql = "SELECT * FROM `{$wpdb->prefix}certificate_gallery` WHERE id_gallery = '".$_GET['id_gallery']."'";
$GetAllGallerys = $wpdb->get_results($sql);
//print_r($GetAllGallerys);
//echo "edit".$_GET['id_gallery'];
foreach( $GetAllGallerys as $key => $row) {
// each column in your row will be accessible like this
	$ID = $row->id_gallery;
	$TYPE = $row->type_gallery;
	$NAME = $row->name_gallery;
	$DESCRIPTION = $row->description_gallery;
	$THEME = $row->theme_gallery;
	$SHORTCODE = $row->shortcode_in_gallery;
}
$sqltypes = "SELECT * FROM `{$wpdb->prefix}certificate_gallery_type`";
$types = $wpdb->get_results($sqltypes);
$sqlthemes = "SELECT * FROM `{$wpdb->prefix}certificate_gallery_template`";
$themes = $wpdb->get_results($sqlthemes);
//print_r($themes);
//echo $ID;
$shortcodes = json_decode($SHORTCODE, TRUE);
?>
<div class="container-fluid">
	<h1 class="text-center"><?php echo EDIT_GALLERY_TITLE;?></h1>
    <p class="text-center">(<?php echo $NAME; ?>)</p>
<form id="gallery_edit">
	<div class="form-group">
		<label for="InputName">Name</label>
		<input type="text" class="form-control" id="InputName" name="InputName" placeholder="Type you name of gallery" value="<?php echo $NAME; ?>">
	</div>
    <div class="form-group">
        <label for="DescriptionGallery">Description Gallery</label>
        <textarea class="form-control" name="DescriptionGallery" id="DescriptionGallery" placeholder="Type you description" rows="3"><?php echo $DESCRIPTION;?></textarea>
    </div>
    <div class="form-group">

        <label for="ShortcodeInGallery">Shortcode description</label><br>
	    <?php do_action( 'add_gallery_button','gallery_media_button');?>
        <br><br><textarea class="form-control" name="ShortcodeInGallery" id="ShortcodeInGallery" placeholder="Add shortcode description" rows="3"><?php if(isset($shortcodes)){ $str = implode (",", $shortcodes); echo $str;} //foreach ( $shortcodes as $value ) {echo implode(', ',$value);} ?></textarea>
        <small id="emailHelp" class="form-text text-muted">Need Separate Shortcode with comma ("," -> [file id=1],[file id=2] ) .</small>
    </div>
	<div class="form-group">
		<label for="TypeGallerySelect">Type Of Gallery</label>
		<select class="form-control" id="TypeGallerySelect" name="TypeGallerySelect">
            <?php
            foreach($types as $type):
            if($type->type_id == $TYPE):
	            echo '<option value="'.$type->type_id.'" selected>'.$type->type_name.'</option>';
            else:
	            echo '<option value="'.$type->type_id.'">'.$type->type_name.'</option>';
            endif;
            endforeach;
            ?>
		</select>
	</div>
    <div class="form-group">
        <label for="ThemeGallerySelect">Theme Of Gallery</label>
        <select class="form-control" id="ThemeGallerySelect" name="ThemeGallerySelect">
			<?php
			foreach($themes as $theme):
				if($theme->ID == $THEME):
					echo '<option id="'.$theme->ID.'" selected>'.$theme->name.'</option>';
				else:
					echo '<option id="'.$theme->ID.'">'.$theme->name.'</option>';
				endif;
			endforeach;
			?>
        </select>
    </div>
    <div class="submitform text-center"><input type="submit" name="submit" class="btn btn-primary" id="submit_gallery" value="Save Gallery" /></div>
</form>
</div>