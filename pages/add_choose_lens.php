<?php
/**
     * Add choose lens
*/
function add_lens_Choose() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'purevision_lens_choose'; 
        $message = '';
        $notice = '';
        $default = array(
            'id'                => 0,
            'name'              => '',
            'short_desc'        => '',
            'desc'              => '',
            'price'             => '',
            'lens_material_id'  => '',
            'lens_finish_id'    => '',
        );
        if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
            $item = shortcode_atts($default, $_REQUEST);
            $item_valid = true; //wpbc_validate_contact($item);
            $retrieve_data = $wpdb->get_var( "SELECT name FROM $table_name 
                                  where name ='".$item['name']."'" );
        
            if ($item_valid === true) {
                if ($item['id'] == 0) {
					if(empty($retrieve_data)){
                    $result = $wpdb->insert($table_name, $item);
                    $item['id'] = $wpdb->insert_id;
                    if ($result) {
                        $message = __('Item was successfully saved', 'wpbc');
                    } else {
                        $notice = __('There was an error while saving item', 'wpbc');
                    }
					}
					else{
            $message = __('Lens Choose name should be unique', 'wpbc');
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
        add_meta_box('lens_type_form_meta_box', __('Lens Choose', 'wpbc'), 'wpbc_lense_choose_form_meta_box_handler', 'lens_type', 'normal', 'default'); ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Lens Choose', 'wpbc')?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=lens_choose');?>"><?php _e('Back To List', 'wpbc')?></a>
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
function wpbc_lense_choose_form_meta_box_handler($item) { ?>
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
                <label for="name"><?php _e('Name:', 'wpbc')?></label>
            <br>
                <input id="name" name="name" type="text" style="width: 60%" value="<?php echo esc_attr($item['name'])?>"
                        required>
            </p>
            <p>
            <label for="price"><b>PRICE: (<?php echo $curry;?>)</b></label>
            <br>
                <input id="price" name="price" type="number" step=0.01 min="0" style="width: 60%" value="<?php echo esc_attr($item['price'])?>"
                        required>
            </p>
            <p>
              <?php $len_parent_name = !empty( $row['lens_finish_id'] ) ? $row['lens_finish_id'] : "";?>
              <label for="lens_finish_id"><?php _e('Lens Finishing Parent Name:', 'wpbc')?></label>
              <br>
              <?php  global $wpdb;
                    $table_name = $wpdb->prefix . 'purevision_lens_finishing';
                    $fetch = $wpdb->get_results("SELECT * from $table_name");
                    ?>
                    <select name='lens_finish_id' >
                    <?php foreach($fetch  as  $key):?>
                    <option value = "<?php echo $key->lens_finish_id; ?>"><?php echo $key->lens_finish_name; ?></option>
                    <?php endforeach;  ?>
                </select>
            </p>
            <p>
              <?php $len_parent_name = !empty( $row['lens_material_id'] ) ? $row['lens_material_id'] : "";?>
              <label for="lens_material_id"><?php _e('Lens Material Parent Name:', 'wpbc')?></label>
              <br>
              <?php  global $wpdb;
                    $table_name = $wpdb->prefix . 'purevision_lens_material';
                    $fetch = $wpdb->get_results("SELECT * from $table_name");
                    ?>
                    <select name='lens_material_id' >
                    <?php foreach($fetch  as  $key):?>
                    <option value = "<?php echo $key->lens_material_id; ?>"><?php echo $key->lens_material_name; ?></option>
                    <?php endforeach;  ?>
                </select>
            </p>
<p>
                <label for="short_desc"><?php _e('Short Description:', 'wpbc')?></label>
                <br>
                <textarea id="short_desc" name="short_desc" cols="100" rows="3" maxlength="240"><?php echo esc_attr($item['short_desc'])?></textarea>
            </p>
            <p>
                <label for="address"><?php _e('Description:', 'wpbc')?></label>
                <br>
                <textarea id="desc" name="desc" cols="100" rows="3" maxlength="240"><?php echo esc_attr($item['desc'])?></textarea>
            </p>
            <!-- <?php 
                global $wpdb;
                $thickness = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}purevision_lense_thickness", OBJECT );
                $thickness_in_current = array(0);
                if (esc_attr($item['thickness']) != '') {
                    $array = explode(',', $item['thickness']);
                    foreach ($array as $key => $value) {
                        array_push($thickness_in_current, $value);
                    }
                }
            ?> -->
            <?php if (count($thickness) > 0): ?>
            <p class="thickness_p">
                <label for="thickness">Thickness</label>
                <br>
                <?php foreach ($thickness as $key => $thickne): ?>
                    <input type="checkbox" class="thickness_check" value="<?= $thickne->id; ?>" id="thickness_<?= $thickne->id; ?>" <?php if(in_array($thickne->id, $thickness_in_current)) echo 'checked'; ?> >
                    <label for="thickness_<?= $thickne->id; ?>"><?= $thickne->name ?> </label>
                    <br>
                <?php endforeach ?>
                <input type="hidden" name="thickness" id="thickness_hidden" value="<?php echo esc_attr($item['thickness']) ?>">
            </p>
            <?php endif ?>
            </form>
            </div>
    </tbody>
    <?php
}

