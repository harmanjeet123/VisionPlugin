<?php
/**
     * Add choose lens
*/
function add_tint_density() {
        global $wpdb; 
        $table_name = $wpdb->prefix . 'purevision_tint_density';
        $message = '';
        $notice = '';
        $default = array(
            'id'               => 0,
            'percentage'       => '',
            'text'             => '',
            'others'           => '',

        );
        if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
            $item = shortcode_atts($default, $_REQUEST);
            $item_valid = true; //wpbc_validate_contact($item);
            $retrieve_data = $wpdb->get_var( "SELECT percentage FROM $table_name 
                                  where percentage ='".$item['percentage']."'" );
        
           if ($item_valid === true) {
                if ($item['id'] == 0) {
					if(empty($retrieve_data)){
                    $result = $wpdb->insert($table_name, $item);
                    $wpdb->show_errors();
                    $item['id'] = $wpdb->insert_id;
                    if ($result) {
                        $message = __('Item was successfully saved', 'wpbc');
                    } else {
                        $wpdb->show_errors();
                        $wpdb->print_error();
                    }
				}
				else{
					$message = __('Tint Density Percentage should be unique', 'wpbc');
				}
                } else {
                    $result = $wpdb->update($table_name, $item, array('id' => $item['id']));
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
            if (isset($_REQUEST['id'])) {
                $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $_REQUEST['id']), ARRAY_A);
                if (!$item) {
                    $item = $default;
                    $notice = __('Item not found', 'wpbc');
                }
            }
        }
        add_meta_box('lens_type_form_meta_box', __('Tint Density', 'wpbc'), 'wpbc_tint_density_form_meta_box_handler', 'lens_type', 'normal', 'default'); ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Tint Density', 'wpbc')?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=tint_density');?>"><?php _e('Back To List', 'wpbc')?></a>
        </h2>
        <?php if (!empty($notice)): ?>
        <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif;?>
        <form id="form" method="POST">
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
            <input type="hidden" name="id" value="<?php echo $item['id'] ?>"/>
            <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">
                        <?php do_meta_boxes('lens_type', 'normal', $item); ?>
                        <?php
                            $btnname = 'Save';
                            if ($item['id'] != 0) {
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
function wpbc_tint_density_form_meta_box_handler($item) { ?>
    <tbody>
        <style>
            div.postbox { width: 75%; }
        </style>
        <div class="formdata">
        <form>
            <p>
                <label for="percentage"><?php _e('Percentage:', 'wpbc')?></label>
            <br>
                <input id="percentage" name="percentage" type="number" min="0" style="width: 60%" value="<?php echo esc_attr($item['percentage'])?>"
                        required> <span><strong>%<strong></span>
            </p>
            <p>
                <label for="text"><?php _e('Text:', 'wpbc')?></label>
            <br>
                <input id="text" name="text" type="text"  step= 0.01 style="width: 60%" value="<?php echo esc_attr($item['text'])?>"
                        required>
            </p>
            <p>
                <label for="others"><?php _e('Others:', 'wpbc')?></label>
            <br>
                <input id="others" name="others" type="number"  min="0" style="width: 60%" value="<?php echo esc_attr($item['others'])?>"
                        required><span><strong> %<strong></span>
            </p>
            </form>
            </div>
    </tbody>
    <?php
}