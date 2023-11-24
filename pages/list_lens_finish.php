<?php
/**
 * List lens finish 
 */
 function lens_option(){
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
            $iamge = wp_get_attachment_thumb_url($item['image']);
            return '<em><img width="70" src="' . $iamge . '"></em>';
        }
    
        function column_lens_finish_name($item)
        {
    
            $actions = array(
                'edit' => sprintf('<a href="?page=Add_lens_finish&lens_finish_id=%s">%s</a>', $item['lens_finish_id'], __('edit', 'wpbc')),
                'delete' => sprintf('<a href="?page=%s&action=delete&lens_finish_id=%s" onclick="return confirm(\'Are you sure to delete this Lens Finish?\')" >%s</a>', $_REQUEST['page'], $item['lens_finish_id'], __('Delete', 'wpbc')),
            );
    
            return sprintf('%s %s',
                $item['lens_finish_name'],
                $this->row_actions($actions)
            );
        }
    
    
        function column_cb($item)
        {
            return sprintf(
                '<input type="checkbox" name="lens_finish_id[]" value="%s" />',
                $item['lens_finish_id']
            );
        }
    
        function get_columns()
        {
            $columns = array(
                'cb'               => '<input type="checkbox" />', 
                'lens_finish_name' => __('Name', 'wpbc'),
                'image'            => __('Image', 'wpbc'),
                'desc'             => __('Description', 'wpbc'),
                'price'            => __('Price', 'wpbc'),
                'lens_name'        => __('Lens parent Name', 'wpbc'),
            );
            return $columns;
        }
    
        function get_sortable_columns()
        {
            return array(
                'name'  => array('name', true),
                'price' => array('price', true),
                'image' => array('image', true)
            );
            $sortable_columns = false;
            return $sortable_columns;
        }
    
        function get_bulk_actions()
        {
            $actions = array(
                'delete' => 'delete'
            );
          return $actions;
        }
    
        function process_bulk_action()
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'purevision_lens_finishing'; 
           
            if ('delete' === $this->current_action()) {
              
                $ids = isset($_REQUEST['lens_finish_id']) ? $_REQUEST['lens_finish_id'] : array();
                if (is_array($ids)) $ids = implode(',', $ids);
   
                if (!empty($ids)) {

                    $wpdb->query("DELETE FROM $table_name WHERE lens_finish_id IN($ids)");
               
                }
            }
        }
        public function table_data($search_item = ''){
            global $wpdb;
            $table_name = $wpdb->prefix.'purevision_lens_finishing'; 
            $curry= get_woocommerce_currency_symbol(); 
            $table_lens_type = $wpdb->prefix. 'purevision_lense_types';

            $post_array = array();
            if(!empty($search_item)){
                $all_posts = $wpdb->get_results("SELECT $table_name.`lens_finish_id`, $table_name.`lens_finish_name`,$table_name.`desc`, $table_name.`image`, $table_name.`price`, $table_lens_type.lens_name FROM $table_name LEFT JOIN $table_lens_type ON $table_name.lens_type_id = $table_lens_type.lens_type_id WHERE lens_finish_name LIKE '%$search_item%' order by $table_name.lens_finish_id DESC" );
                foreach($all_posts as $key => $value){
                    $post_array[] = array(   
                        'lens_finish_id'   => $value->lens_finish_id, 
                        'price'            => $curry.$value->price, 
                        'lens_finish_name' => $value->lens_finish_name,
                        'desc'             => $value->desc,
                        'image'            => $value->image,
                        'lens_name'        => $value->lens_name
                    );
                }
            }else{
                $all_posts = $wpdb->get_results("SELECT $table_name.`lens_finish_id`, $table_name.`lens_finish_name`,$table_name.`desc`, $table_name.`image`, $table_name.`price`, $table_lens_type.lens_name FROM $table_name LEFT JOIN $table_lens_type ON $table_name.lens_type_id = $table_lens_type.lens_type_id order by $table_name.lens_finish_id DESC" );
                foreach($all_posts as $key => $value){
                    $post_array[] = array(   
                        'lens_finish_id'   => $value->lens_finish_id, 
                        'price'            => $curry.$value->price, 
                        'lens_finish_name' => $value->lens_finish_name,
                        'desc'             => $value->desc,
                        'image'            => $value->image,
                        'lens_name'        => $value->lens_name
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
                $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), count(array($_REQUEST['lens_finish_id']))) . '</p></div>';
            }
            ?>
        <div class="wrap">
    
            <div class="icon32 icon32-posts-post shubh" id="icon-edit"><br></div>
            <h2><?php _e('Lens Finish', 'wpbc')?> 
                <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=Add_lens_finish');?>"><?php _e('Add new', 'wpbc')?></a>
            </h2>
            <?php echo $message; ?>

                <form method = 'post' action='<?php echo $_SERVER['PHP_SELF']?>?page=List_lens_option'>
                <?php echo $table->search_box( 'Search', 'search_id' ); ?>
                <?php $table->display() ?>
		    </form>
            
        </div>
    
    <?php } ?>
