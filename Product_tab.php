<?php 
/**
* Softprodigy
* https://www.softprodigy.com/
*/

function custom_product_tabs($tabs) {
$tabs['purevision'] = array(
'label'		=> __( 'PureVision', 'woocommerce' ),
'target'	=> 'purevision_options',
'class'		=> array( 'show_if_simple', 'show_if_variable'  ),
);
return $tabs;
}
add_filter( 'woocommerce_product_data_tabs', 'custom_product_tabs' );

/**
* Contents of the product tab.
*/
function product_tab_content() {
global $post;

global $wpdb;
$lens_types = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}purevision_lense_types", OBJECT );

	$lens_finishing = $wpdb->get_results("SELECT `{$wpdb->prefix}purevision_lens_finishing`.lens_finish_id,`{$wpdb->prefix}purevision_lens_finishing`.lens_finish_name, `{$wpdb->prefix}purevision_lense_types`.lens_name FROM `{$wpdb->prefix}purevision_lens_finishing`	LEFT JOIN `{$wpdb->prefix}purevision_lense_types` ON `{$wpdb->prefix}purevision_lens_finishing`.lens_type_id = `{$wpdb->prefix}purevision_lense_types`.lens_type_id ORDER BY `{$wpdb->prefix}purevision_lens_finishing`.lens_finish_name") ; 

	$lens_choose = $wpdb->get_results("SELECT {$wpdb->prefix}purevision_lens_choose.id,`{$wpdb->prefix}purevision_lens_choose`.`name`,`{$wpdb->prefix}purevision_lens_finishing`.`lens_finish_name` , `{$wpdb->prefix}purevision_lens_material`.`lens_material_name` FROM `{$wpdb->prefix}purevision_lens_choose` INNER JOIN `{$wpdb->prefix}purevision_lens_finishing` ON `{$wpdb->prefix}purevision_lens_choose`.lens_finish_id= `{$wpdb->prefix}purevision_lens_finishing`.lens_finish_id INNER JOIN `{$wpdb->prefix}purevision_lens_material` ON `{$wpdb->prefix}purevision_lens_choose`.`lens_material_id` = `{$wpdb->prefix}purevision_lens_material`.lens_material_id ORDER BY `{$wpdb->prefix}purevision_lens_choose`.`name`;") ; 
	
	
	// Note the 'id' attribute needs to match the 'target' parameter set above
	?><div id='purevision_options' class='panel woocommerce_options_panel'><?php
		?><div class='options_group'>

		<?php
			woocommerce_wp_checkbox( array(
				'id' 		=> 'pescription_status',
				'label' 	=> __( 'Show', 'woocommerce' ),
			) );
			woocommerce_wp_checkbox( array(
				'id' 		=> 'show_price',
				'label' 	=> __( 'Prescription Price', 'woocommerce' ),
			) );

			$selected_pres_type = get_post_meta( $post->ID, '_glass_type', true ); ?>
			<p class='form-field _glass_type'>
				<label for='_glass_type'><?php _e( 'Prescription Type', 'woocommerce' ); ?></label>
				<select name='_glass_type' class='wc-enhanced-select' style='width: 80%;'>
					<option>Select Type</option>
					<option <?php if($selected_pres_type == 'eye-glass') echo 'selected'; ?> value='eye-glass'>Eye Glass</option>
					<option <?php if($selected_pres_type == 'eye-lens')  echo 'selected'; ?> value='eye-lens'>Lens</option>
				</select>
			</p>

			<?php $selected_lens_type = (array) get_post_meta( $post->ID, '_lens_types', true ); ?>
			<p class='form-field _lens_types hide_on_option hidenn'>
				<label for='_lens_types'><?php _e( 'Lens Types', 'woocommerce' ); ?></label>
				<select name='_lens_types[]' class='wc-enhanced-select' multiple='multiple' style='width: 80%;'>
					<?php foreach ($lens_types as $key => $lens_type): ?>
						<option <?php selected( in_array( $lens_type->lens_type_id, $selected_lens_type ) ); ?> value='<?php echo $lens_type->lens_type_id; ?>'><?php echo $lens_type->lens_name; ?></option>
					<?php endforeach ?>
				</select>
			</p>
			<?php $selected_lens_finishing_type = (array) get_post_meta( $post->ID, '_lens_finishing', true ); ?>
			<p class='form-field _lens_finishing hide_on_option hidenn'>
				<label for='_lens_finishing'><?php _e( 'Lens Finishing', 'woocommerce' ); ?></label>
				<select name='_lens_finishing[]' class='wc-enhanced-select' multiple='multiple' style='width: 80%;'>
					<?php foreach ($lens_finishing as $key => $lens_finish): ?>
						<option <?php selected(in_array($lens_finish->lens_finish_id, $selected_lens_finishing_type) ); ?> value='<?php echo $lens_finish->lens_finish_id; ?>'><?php echo $lens_finish->lens_finish_name.'('.$lens_finish->lens_name.')'; ?></option>
					<?php endforeach ?>
				</select>
			</p>

			<?php $selected_lens_choose = (array) get_post_meta( $post->ID, '_lens_choose', true );?>
			<p class='form-field _lens_choose hide_on_option hidenn'>
				<label for='_lens_choose'><?php _e( 'Lens Choose', 'woocommerce' ); ?></label>
				<select name='_lens_choose[]' class='wc-enhanced-select' multiple='multiple' style='width: 80%;'>
					<?php foreach ($lens_choose as $key => $lens_choosen):?>
						<option <?php selected( in_array( $lens_choosen->id, $selected_lens_choose ) ); ?> value='<?php echo $lens_choosen->id; ?>'><?php echo (!empty($lens_choosen->name))? $lens_choosen->name.' ( '.$lens_choosen->lens_finish_name.' )'.' ( '.$lens_choosen->lens_material_name.' )':''; ?></option>
					<?php endforeach ?>
				</select>
			</p>
</div>

</div><?php
}

add_filter( 'woocommerce_product_data_panels', 'product_tab_content' ); 
/**
* Save the custom fields.
*/
function save_prescription_option_fields( $post_id ) {

$prescription_status = isset( $_POST['pescription_status'] ) ? 'yes' : 'no';
update_post_meta( $post_id, 'pescription_status', $prescription_status );

	//Show price
	$show_price = isset( $_POST['show_price'] ) ? 'yes' : 'no';
	update_post_meta( $post_id, 'show_price', $show_price );
	update_post_meta( $post_id, '_glass_type', $_POST['_glass_type'] );
	update_post_meta( $post_id, '_lens_types', (array) $_POST['_lens_types'] );
	update_post_meta( $post_id, '_lens_finishing', (array) $_POST['_lens_finishing'] );
	update_post_meta( $post_id, '_lens_choose', (array) $_POST['_lens_choose'] );
	
}
add_action( 'woocommerce_process_product_meta_simple', 'save_prescription_option_fields'  );
add_action( 'woocommerce_process_product_meta_variable', 'save_prescription_option_fields'  );

// admin js 
require(dirname(__FILE__). '/js/admin-js.php');


