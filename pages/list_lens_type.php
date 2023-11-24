<?php  
/**
    *List Lens Type
*/
function lens_type() { 
    
class Lens_type_List_Table extends WP_List_Table { 
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
            'edit' => sprintf('<a href="?page=PureVision&lens_type_id=%s">%s</a>', $item['lens_type_id'], __('edit', 'wpbc')),
            'delete' => sprintf('<a href="?page=%s&action=delete&lens_type_id=%s" onclick="return confirm(\'Are you sure to delete this Lens Option?\')" >%s</a>', $_REQUEST['page'], $item['lens_type_id'], __('Delete', 'wpbc')),
        );
        return sprintf('%s %s',
            $item['lens_name'],
            $this->row_actions($actions)
        );
    }


    function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="lens_type_id[]" value="%s" />',
            $item['lens_type_id']
        );
    }

    function get_columns()
    {
        $columns = array(
            'cb'        => '<input type="checkbox" />', 
            'name'      => __('Name', 'wpbc'),
            'image'     => __('Image', 'wpbc'),
            'desc'      => __('Description', 'wpbc'),
            'thickness' => __('thickness', 'wpbc'),
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
        $table_name = $wpdb->prefix . 'purevision_lense_types'; 

        if ('delete' === $this->current_action()) {
            $ids = isset($_REQUEST['lens_type_id']) ? $_REQUEST['lens_type_id'] : array();
            if (is_array($ids)) $ids = implode(',', $ids);

            if (!empty($ids)) {
                $wpdb->query("DELETE FROM $table_name WHERE lens_type_id IN($ids)");
            }
        }
    }

    public function table_data($search_item = ''){
        global $wpdb;
        $table_name = $wpdb->prefix.'purevision_lense_types';

        $post_array = array();
        if(!empty($search_item)){
            $all_posts = $wpdb->get_results("SELECT * FROM $table_name WHERE lens_name LIKE '%$search_item%' order by lens_type_id DESC" );
            foreach($all_posts as $key => $value){ 
                $post_array[] = array(   
                    'lens_type_id' => $value->lens_type_id, 
                    'price'        => $value->price, 
                    'lens_name'    => $value->lens_name,
                    'desc'         => $value->desc,
                    'image'        => $value->image,
                    'thickness'    => $value->thickness
                    
                );
            }
        }else{
            $all_posts = $wpdb->get_results("SELECT * FROM $table_name order by lens_type_id DESC " );
            foreach($all_posts as $key => $value){
                $post_array[] = array(   
                    'lens_type_id' => $value->lens_type_id, 
                    'price'        => $value->price, 
                    'lens_name'    => $value->lens_name,
                    'desc'         => $value->desc,
                    'image'        => $value->image,
                    'thickness'    => $value->thickness
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

	    $table = new Lens_type_List_Table();
	    $table->prepare_items();

	    $message = '';
	    if ('delete' === $table->current_action()) {
	        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'wpbc'), count(array($_REQUEST['lens_type_id']))) . '</p></div>';
	    }
	    ?>
	<div class="wrap">

	    <div class="icon32 icon32-posts-post" id="icon-edit"><br></div>
	    <h2><?php _e('Lens Type', 'wpbc')?> 
            <a class="add-new-h2" href="<?php echo get_admin_url(get_current_blog_id(), 'admin.php?page=PureVision');?>"><?php _e('Add new', 'wpbc')?></a>
	    </h2>
	    <?php echo $message; ?>

        <form method = 'post' action='<?php echo $_SERVER['PHP_SELF']?>?page=lens_types'>
            <?php echo $table->search_box( 'Search', 'search_id' ); ?>
        
             <?php $table->display() ?>
        </form>
	   

	</div>

<?php } ?>