<?php
/**
 * List Lens Choose
 */
 function list_choose_lens(){
    class Template_Listing extends WP_List_Table{
        
        function __construct()
        {
            global $status, $page;
    
            parent::__construct(array(
                'singular' => 'lens_type',
                'plural' => 'lens_types',
            ));
        }
    
        function column_default($item, $column_name)
        {
            return $item[$column_name];
        }
    
        function column_image($item)
        {
            $image = wp_get_attachment_thumb_url($item['image']);
            return '<em><img width="70" src="' . $image . '"></em>';
        }
    
        function column_name($item)
        {
    
            $actions = array(
                'edit' => sprintf('<a href="?page=add_lens_Choose&id=%s">%s</a>', $item['id'], __('edit', 'wpbc')),
                'delete' => sprintf('<a href="?page=%s&action=delete&id=%s" onclick="return confirm(\'Are you sure to delete this Lens Choose?\')" >%s</a>', $_REQUEST['page'], $item['id'], __('Delete', 'wpbc')),
            );
    
            return sprintf('%s %s',
                $item['name'],
                $this->row_actions($actions)
            );
        }
    
    
        function column_cb($item)
        {
            return sprintf(
                '<input type="checkbox" name="id[]" value="%s" />',
                $item['id']
            );
        }
    
        function get_columns()
        {
            $columns = array(
                'cb' => '<input type="checkbox" />', 
                'name' => __('Name', 'wpbc'),
                'short_desc' => __('Short Description', 'wpbc'),
                'desc' => __('Description', 'wpbc'),
                'price' => __('Price', 'wpbc'),
                'lens_material_name' => __('Lens Material Parent Name', 'wpbc'),
                'lens_finish_name' => __('Lens Finishing Parent Name', 'wpbc'),

            );
            return $columns;
        }
    
        function get_sortable_columns()
        {
            $sortable_columns = false;
            return $sortable_columns;
        }
    
        function get_bulk_actions()
        {
            $actions = array(
                'delete' => 'Delete'
            );
            return $actions;
        }
    
        function process_bulk_action()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'purevision_lens_choose';  
    
            if ('delete' === $this->current_action()) {
                $ids = isset($_REQUEST['id']) ? $_REQUEST['id'] : array();
                if (is_array($ids)) $ids = implode(',', $ids);
    
                if (!empty($ids)) {
                    $wpdb->query("DELETE FROM $table_name WHERE id IN($ids)");
                }
            }
        }

        public function table_data($search_item = ''){
            global $wpdb;
            $table_name = $wpdb->prefix.'purevision_lens_choose';
            $curry= get_woocommerce_currency_symbol();
            $lens_finish_table = $wpdb->prefix.'purevision_lens_finishing';

            $lens_material_table = $wpdb->prefix.'purevision_lens_material';
            $post_array = array();
            if(!empty($search_item)){
                $all_posts = $wpdb->get_results("SELECT $table_name.id,$table_name.`name`,$table_name.`short_desc`,$table_name.`desc`,$table_name.`price`,$lens_finish_table.`lens_finish_name` , $lens_material_table.`lens_material_name` FROM $table_name INNER JOIN $lens_finish_table ON $table_name.lens_finish_id= $lens_finish_table.lens_finish_id INNER JOIN $lens_material_table ON $table_name.`lens_material_id` = $lens_material_table.lens_material_id WHERE name LIKE '%$search_item%' order by $table_name.id DESC"  );
                foreach($all_posts as $key => $value){
                    $post_array[] = array(   
                        'id'                 => $value->id, 
                        'price'              => $curry.$value->price, 
                        'name'               => $value->name,
                        'short_desc'         => $value->short_desc,
                        'desc'               => $value->desc,
                        'lens_material_name' => $value->lens_material_name,
                        'lens_finish_name'   => $value->lens_finish_name
                    );
                }
    
            }else{
                $all_posts = $wpdb->get_results("SELECT $table_name.id,$table_name.`name`,$table_name.`short_desc`,$table_name.`desc`,$table_name.`price`,$lens_finish_table.`lens_finish_name` , $lens_material_table.`lens_material_name` FROM $table_name INNER JOIN $lens_finish_table ON $table_name.lens_finish_id= $lens_finish_table.lens_finish_id INNER JOIN $lens_material_table ON $table_name.`lens_material_id` = $lens_material_table.lens_material_id order by $table_name.id DESC");
                foreach($all_posts as $key => $value){
                    $post_array[] = array(    
                        'id'                 => $value->id,
                        'name'               => $value->name,
                        'short_desc'         => $value->short_desc,
                        'desc'               => $value->desc,
                        'price'              => $curry.$value->price,
                        'lens_material_name' => $value->lens_material_name,
                        'lens_finish_name'   => $value->lens_finish_name
                    );
                }
                
            }
            
                
            return $post_array;
                
                
        }
    
    
        function prepare_items()
        {
            global $wpdb;
            $search_item = isset($_POST['s'])? trim($_POST['s']):'';
            $table_name = $this->table_data($search_item); 
            
    
            $per_page = 10; 
    
            $columns = $this->get_columns();
            $hidden = array();
            $sortable = $this->get_sortable_columns();
            
            $this->_column_headers = array($columns, $hidden, $sortable);
            
            $this->process_bulk_action();
    
            //pagination
            $per_page = 10;
            $current_page = $this->get_pagenum();
            $total_items = count($table_name);
            $this->set_pagination_args(array(
                'total_items' => $total_items,
                'per_page'    => $per_page,
            ));
            $this->items = array_slice($table_name ,(($current_page - 1) * $per_page ), $per_page);
            
        }
    }
    
            global $wpdb;
    
            $table = new Template_Listing();
            $table->prepare_items();
    
            $message = '';
            if ('delete' === $table->current_action()) {
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), count(array($_REQUEST['id']))) . '</p></div>';
            }
            ?>
        <div class="wrap">
    
            <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
            <h2><?php _e('Lens Choose', 'wpbc')?> 
                <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=add_lens_Choose');?>"><?php _e('Add new', 'wpbc')?></a>
            </h2>
            <?php echo $message; ?>
    
            <form method = 'post' action='<?php echo $_SERVER['PHP_SELF']?>?page=lens_choose'>
                <?php echo $table->search_box( 'Search', 'search_id' ); ?>
                <?php $table->display() ?>
		    </form>
            
        
    
        </div>
    
    <?php } ?>
