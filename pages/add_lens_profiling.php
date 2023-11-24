<?php
/**
     * Add Profiling lens
*/
function add_lens_profile() {
        global $wpdb;
        $table_name = $wpdb->prefix . 'purevision_lens_profiling';
        $table_name_demo  = $wpdb->prefix . 'profile_demos';
        $message = '';
        $notice = '';
        $default = array(
            'profile_id'        => 0,
            'profile_name'      => '',
            'glass_type'        => '', 
            'lens_type_id'      => '',
            'lens_material_id'  => '',
            'lens_finish_id'    => '',
            'id'                => ''
        );
        if ( isset($_REQUEST['nonce']) && wp_verify_nonce($_REQUEST['nonce'], basename(__FILE__))) {
            $item = shortcode_atts($default, $_REQUEST);


            $item_valid = true; //wpbc_validate_contact($item);
           if ($item_valid == true) {
                if ($item['profile_id'] == 0) {
                    $ary = explode(',',$item['lens_finish_id']);
                    $profileName = $item['profile_name'];
                    $prepared_statement = $wpdb->prepare( "SELECT profile_name FROM $table_name WHERE  profile_name = '$profileName'" );
                    $values = $wpdb->get_col( $prepared_statement );
                    if(count($values) > 0){
                        $notice = __('Profile Name already in table', 'wpbc');
                    }
                    else{
                     foreach($ary as $item_val){
                     $result = $wpdb->insert($table_name, array(
                        'profile_name' => $item['profile_name'],
                        'glass_type' => $item['glass_type'],
                        'lens_type_id' => $item['lens_type_id'],
                        'lens_material_id' =>$item['lens_material_id'],
                        'lens_finish_id'=>$item_val,
                        'id' => $item['id'],
                    ));
                    }
                       $item['profile_id'] = $wpdb->insert_id;
                       $last_id =$wpdb->insert_id; 
                       if ($result) {
                           $message = __('Item was successfully saved', 'wpbc');
                       } else {
                        $notice = __('There was an error while saving item', 'wpbc');
                       }
                       $all_posts = $wpdb->get_results("select
                         $table_name.`profile_id` ,
                         $table_name.`profile_name` ,
                         $table_name.`glass_type`,
                         $table_name.`lens_type_id`,
                         $table_name.`id`,
                         $table_name.`lens_material_id`,
                         $table_name.`lens_finish_id`,
                         $table_name.`created_on`,
                         $table_name.`updated_on`,
                         GROUP_CONCAT($table_name.`lens_finish_id`) as `lens_finish_id`
                       from
                         $table_name
                       group by
                        $table_name.`profile_name`");
                       foreach($all_posts as $item){
                        $checkIfExists = $wpdb->get_var("SELECT profile_id FROM $table_name_demo WHERE profile_id = '$item->profile_id'");
                        if ($checkIfExists == NULL) {
                        $wpdb->insert($table_name_demo, array(
                            'profile_id' => $last_id,
                            'profile_name' => $item->profile_name,
                            'glass_type' => $item->glass_type,
                            'lens_type_id' => $item->lens_type_id,
                            'lens_material_id' =>$item->lens_material_id,
                            'lens_finish_id'=>$item->lens_finish_id,
                            'id' => $item->id,
                        ));
                       }
                    }
                }  
                } else {
                    $result = $wpdb->update($table_name, $item, array('profile_id' => $item['profile_id']));
                    if ($result) {
                        $message = __('Item was successfully updated', 'wpbc');
                    } else {
                        $notice = __('There was an error while updating item', 'wpbc');
                    }
                }
            } else {
                $notice = $item_valid;
            }
        }
        else {
            $item = $default;
            if (isset($_REQUEST['profile_id'])) {
                $item = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name_demo WHERE profile_id = %d", $_REQUEST['profile_id']), ARRAY_A);
                if (!$item) {
                    $item = $default;
                    $notice = __('Item not found', 'wpbc');
                }
            }
        }
        add_meta_box('lens_profile_form_meta_box', __('Lens Profile', 'wpbc'), 'wpbc_lense_profile_form_meta_box_handler', 'lens_type', 'normal', 'default'); ?>
    <div class="wrap">
        <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
        <h2><?php _e('Lens Profile', 'wpbc')?> <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=lens_profile');?>"><?php _e('Back To List', 'wpbc')?></a>
        </h2>
        <?php if (!empty($notice)): ?>
        <div id="notice" class="error"><p><?php echo $notice ?></p></div>
        <?php endif;?>
        <?php if (!empty($message)): ?>
        <div id="message" class="updated"><p><?php echo $message ?></p></div>
        <?php endif;?>
        <form id="form" method="POST" >
            <input type="hidden" name="nonce" value="<?php echo wp_create_nonce(basename(__FILE__))?>"/>
            <input type="hidden" name="profile_id" value="<?php echo $item['profile_id'] ?>"/>
            <div class="metabox-holder" id="poststuff">
                <div id="post-body">
                    <div id="post-body-content">
                        <?php do_meta_boxes('lens_type', 'normal', $item); ?>
                        <?php
                            $btnname = 'Save';
                            if ($item['profile_id'] != 0) {
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
function wpbc_lense_profile_form_meta_box_handler($item) { ?>
    <tbody>
        <style>
            div.postbox { width: 75%; }
        </style>
        <div class="formdata">
        <form>
            <p>
                <label for="profile_"><?php _e('Name:', 'wpbc')?></label>
            <br>
                <input id="profile_name" name="profile_name" type="text" style="width: 60%" value="<?php echo esc_attr($item['profile_name'])?>"
                        required>
            </p>
            <p>
                <label for="glass_type"><?php _e('Lens Finishing Parent Name:', 'wpbc')?></label>
                <select name='glass_type' >
                    <option>Select Glass Type</option>
                    <option>Sun Glass</option>
                    <option>Eye Glass</option>
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
                    <select name='lens_material_id'>
                    <?php foreach($fetch  as  $key):?>
                    <option value = "<?php echo $key->lens_material_id; ?>"><?php echo $key->lens_material_name; ?></option>
                    <?php endforeach;  ?>
                </select>
            </p>
            <p>
              <?php $len_parent_name = !empty( $row['lens_type_id'] ) ? $row['lens_type_id'] : "";?>
              <label for="lens_type_id"><?php _e('Lens Type Parent Name:', 'wpbc')?></label>
              <br>
              <?php  global $wpdb;
                    $table_name = $wpdb->prefix . 'purevision_lense_types';
                    $fetch = $wpdb->get_results("SELECT * from $table_name"); ?>
                    <select name='lens_type_id' >
                    <?php foreach($fetch  as  $key):?>
                    <option value = "<?php echo $key->lens_type_id; ?>"><?php echo $key->lens_name  ?></option>
                    <?php endforeach;  ?>
                </select>
            </p>

            <p>
              <?php $len_parent_name = !empty( $row['id'] ) ? $row['id'] : "";?>
              <label for="id"><?php _e('Lens Choose Parent Name:', 'wpbc')?></label>
              <br>
              <?php  global $wpdb;
                    $table_name = $wpdb->prefix . 'purevision_lens_choose';
                    $fetch = $wpdb->get_results("SELECT * from $table_name"); ?>
                    <select name='id' >
                    <?php foreach($fetch  as  $key):?>
                    <option value = "<?php echo $key->id; ?>"><?php echo $key->name  ?></option>
                    <?php endforeach;  ?>
                </select>
            </p>
             <?php
                global $wpdb;
                $thickness = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}purevision_lens_finishing", OBJECT );
                $thickness_in_current = array(0);
                if (esc_attr($item['lens_finish_id']) != '') {
                    $array = explode(',', $item['lens_finish_id']);
                    
                    foreach ($array as $key => $value) {
                        array_push($thickness_in_current, $value);
                    }
                }
            ?> 
            <?php if (count($thickness) > 0): ?>
            <p class="thickness_p">
                <label for="thickness">Lens Finish Parent Name</label>
                <br>
                <?php foreach ($thickness as $key => $thickne): ?>
                    <input type="checkbox" class="thickness_check" value="<?= $thickne->lens_finish_id; ?>" id="thickness_<?= $thickne->lens_finish_id; ?>" <?php if(in_array($thickne->lens_finish_id, $thickness_in_current)) echo 'checked'; ?> >
                    
                    <label for="thickness_<?= $thickne->lens_finish_id; ?>"><?= $thickne->lens_finish_name ?> </label>
                    <br>
                <?php endforeach ?>
                <input type="hidden"  name = "lens_finish_id" id="thickness_hidden" value="">
            </p>
            <?php endif ?>
            </form>
            </div>
    </tbody>
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $(".thickness_check").click(function() {
                var checkbox_Array = $('.thickness_check:checked').map(function() {return this.value;}).get().join(',');
                $("#thickness_hidden").val(checkbox_Array);
                console.log(checkbox_Array);
            });
        });
       
    </script>
    <?php
}