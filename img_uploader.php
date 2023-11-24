<?php
/**
     * image Uploader
*/
function arthur_image_uploader( $name, $item ) {
// Set variables
$options = $item;
$default_image = plugins_url( Plugin_folder_name().'/images/no-image.png');
if ( !empty( $options[$name] ) ) {
$image_attributes = wp_get_attachment_image_url( $options[$name]);

$value = $options[$name];
} else {
$image_attributes = $default_image;
$value = '';
}
$text = __( 'Upload');
// Print HTML field
echo '
<div class="upload">
<img class = "upload_image" data-src="' . $default_image . '" src="' . $image_attributes . '" />
<div>
<input type="hidden" name="'.$name.'" id="'.$name.'[' . $name . ']" value="' . $value . '" />
<button type="submit" class="upload_image_button button" >' . $text . '</button>
<button type="submit" class="remove_image_button button" >&times;</button>
</div>
</div>
';
}
function arthur_load_scripts_admin() {
// WordPress library
wp_enqueue_media();
}

add_action( 'admin_enqueue_scripts', 'arthur_load_scripts_admin' );
function my_enqueue() {
wp_enqueue_script('my_custom_script', plugins_url(Plugin_folder_name().'/js/media_uploaders.js'));
}
add_action('admin_enqueue_scripts', 'my_enqueue');

?>