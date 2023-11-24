<?php
/**
 * Add Lens type
*/
function add_lens_form() {

    global $wpdb;
    $table_name = $wpdb->prefix . 'purevision_lense_types'; 
    $message = '';
    $notice = '';

    $default = array(
        'lens_type_id'=> 0,
        'lens_name'   => '',
        'image'       => '',
        'price'       => '',
        'desc'        => '',
    );

    if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
        
        $item = shortcode_atts($default, $_REQUEST);
        $error = new WP_Error();

        if (!$_POST['tos_agree']){
            $error->add('notchecked','You must agree to the Terms.');
        }

        $item_valid = true; //wpbc_validate_contact($item);
        $retrieve_data = $wpdb->get_var( "SELECT lens_name FROM $table_name 
                                  where lens_name ='".$item['lens_name']."'" );
        
        if ($item_valid === true) {
            if ($item['lens_type_id'] == 0) {
				if(empty($retrieve_data)){
                $result = $wpdb->insert($table_name, $item);
                $item['lens_type_id'] = $wpdb->insert_id;
                if ($result) {
                    $message = __('Item was successfully saved', 'wpbc');
                } else {
                    $notice = __('There was an error while saving item', 'wpbc');
                }
			  }
			  else{
				  $message = __('Lens Finish Name should be unique', 'wpbc');
			  }
            } else {
                $result = $wpdb->update($table_name, $item, array('lens_type_id' => $item['lens_type_id']));
                if ($result) {
                    $message = __('Item was successfully updated', 'wpbc');
                } 
            }
        } else {
            
            $notice = $item_valid;
        }
       
       
    }
    else {
        
        $item = $default;
        if (isset($_REQUEST['lens_type_id'])) {
            $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE lens_type_id = %d", $_REQUEST['lens_type_id']), ARRAY_A);
            if (!$item) {
                $item = $default;
                $notice = __('Item not found', 'wpbc');
            }
        }
    }
  
    add_meta_box('glass_coatings_form_meta_box', __('Add Lens Type', 'wpbc'), 'wpbc_lens_type_form_meta_box_handler', 'glass_coatings', 'normal', 'default'); ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Add Lens Type', 'wpbc')?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=lens_types'); ?>"><?php _e('Back To List', 'wpbc')?></a>
        </h2>

        <?php if (!empty($notice)): ?>
        <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif;?>
         
        <form id="form" method="POST">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
            
            <input type="hidden" name="lens_type_id" value="<?php echo $item['lens_type_id'] ?>"/>

            <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">

                        <?php do_meta_boxes('glass_coatings', 'normal', $item); ?>
                        <?php 
                            $btnname = 'Save';
                            if ($item['lens_type_id'] != 0) {
                            $btnname = 'Update';
                            }
                        ?>
                        <input type="submit" value="<?= $btnname; ?>" id="submit" class="button-primary" name="submit">
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php
}

function wpbc_lens_type_form_meta_box_handler($item) { ?>
<?php
         $curry= get_woocommerce_currency_symbol(); 
        ?>
<tbody>
<style>
div.postbox { width: 75%; }
</style>	  
<div class="formdata">		
<form>
<p>			
<label for="lens_name"><b><?php _e('NAME:', 'wpbc')?></b></label>
<br>	
<input id="lens_name" name="lens_name" type="text" style="width: 60%" value="<?php echo esc_attr($item['lens_name'])?>" required>
</p>

<p>
<td>
<label><b>IMAGE:</b></label>
<?php arthur_image_uploader('image', $item); ?>
</td>
</p>		

<p>	
<label for="price"><b>PRICE: (<?php echo $curry;?>)</b></label>
<br>
<input id="price" name="price" type="number" step=0.01 min="0" style="width: 60%" value="<?php echo esc_attr($item['price'])?>" required>
</p>

<p>
<label for="address"><b><?php _e('DESCRIPTION:', 'wpbc')?></b></label> 
<br>
<textarea id="desc" name="desc" cols="100" rows="10" maxlength="240"><?php echo esc_attr($item['desc'])?></textarea>
</p>
</form>
</div>
</tbody>
<?php
}

global $pagenow;
if ( (  $pagenow === 'admin.php' ) && ( 'PureVision' === $_GET['page'] ) ){

add_filter( 'upload_mimes', 'images_upload_mimes' ); 
function images_upload_mimes ( $mimes)
{
    global $pagenow;
    if ( (  $pagenow === 'admin.php' ) && ( 'PureVision' === $_GET['page'] ) ){
       
    $mimes = array(
        'jpg|jpeg' => 'image/jpeg',
        'png' => 'image/png',
    );
    return $mimes;
    }
    else{
        return false;
    }
}
}
