<?php
// adding frontend js file 
add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );
function my_plugin_assets() {
wp_enqueue_script( 'jquery-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js' );
wp_enqueue_script( 'purevision-js', plugins_url( '/js/purevision.js' , __FILE__ ) );
wp_enqueue_style('purevision-style', plugins_url( '/style/main.css' , __FILE__ ) );
wp_enqueue_style('fontawesome-style', "https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.css" );
}

add_action( 'wp_enqueue_scripts', 'adding_bootstrap_for_purevision' );
function adding_bootstrap_for_purevision(){
$style = 'bootstrap';
if( ( ! wp_style_is( $style, 'queue' ) ) && ( ! wp_style_is( $style, 'done' ) ) ) {
    //queue up your bootstrap
    wp_enqueue_style('bootstrap-style', "https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" );
    wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' );
}
}

add_action('woocommerce_after_add_to_cart_button','select_lens_button');
function select_lens_button() {
$enbles = get_post_meta( get_the_ID(), 'pescription_status');
$enble_option = implode('',$enbles);
if ($enble_option == 'yes') {

function range_options($from, $to, $difference, $decimal, $zeroText = false, $selected = false, $showmark = false, $hideValues = []) {

$float_from = (float)$from;
$float_to = (float)$to;
$float_difference = (float)$difference;

for ($i=($float_from); $i <= ($float_to); $i+= ($float_difference) ) {

if (in_array($i, $hideValues)) {
continue;
}

$return_options = $i;

if($decimal == 'yes') {
$return_options = (number_format($i, 2) > 0) ? '+'.number_format($i, 2) : number_format($i, 2);
}

if ( ($return_options == '0' or $return_options == '0.00') && $zeroText != false ) {
$return_options	= $zeroText.'('.number_format($i, 2).')';
}

$sel = '';
if ( $selected != false && $selected == $return_options ) {
$sel = 'selected';
}

if ($showmark == false) {
$return_options = str_replace(['+', '-'], '',$return_options);
}

echo "<option value='$return_options' $sel>$return_options</option>";

}
}

$pres_type = get_post_meta( get_the_ID(), '_glass_type')[0];
$lens_type_glass = get_post_meta( get_the_ID(), '_lens_types')[0];
$lens_type_lens = get_post_meta( get_the_ID(), '_lens_types_lens');
if ($pres_type == 'eye-lens' && $lens_type_lens != 'Select Type') {
echo '<button class="custom-btn purevw_btn" id="select_lens" type="button">'. __('PureVision', 'glasses-prescription').'</button>';
} elseif($pres_type == 'eye-glass' && count($lens_type_glass) > 0) {

echo '<button class="custom-btn purevw_btn" id="select_lens" type="button">'. __('PureVision', 'glasses-prescription').'</button>';
}
}
}

// setting initail cookies 
add_action( "init", 'setting_cookies_for_lens_ids');
function setting_cookies_for_lens_ids(){
// lens type id
if(!isset($_COOKIE['lens_type_id'])) {
setcookie("lens_type_id","1",time()+ (86400), "/");
}

if(!isset($_COOKIE['lens_material_id'])) {
setcookie("lens_material_id","1",time()+ (86400), "/");
}

if(!isset($_COOKIE['lensFinish_id'])) {
setcookie("lensFinish_id","1",time()+ (86400), "/");
}

if(!isset($_COOKIE['prescription_id'])) {
   $token = bin2hex(random_bytes(16));
   setcookie("prescription_id","$token",time()+ (86400), "/");
   }

}


// getting lens type id from ajax 
if (!function_exists('get_lensType_id'))   {

add_action( 'wp_ajax_nopriv_get_lensType_id', 'get_lensType_id' );  
add_action( 'wp_ajax_get_lensType_id', 'get_lensType_id' );
function get_lensType_id(){
$lens_type_id = $_POST['lens_type'];
// bbloomer_custom_action($lens_type_id);
}
}

// getting lens material id from ajax 
// For the users that are not logged in
add_action( 'wp_ajax_nopriv_get_lensmaterial_id', 'get_lensmaterial_id' );  

// For the users that are  logged in:  
add_action( 'wp_ajax_get_lensmaterial_id', 'get_lensmaterial_id' );
function get_lensmaterial_id(){
$lens_material_id = $_POST['lens_material_id'];
setcookie("lens_material_id", $lens_material_id, time() + (86400), "/");
die;
}

// get lens finish id from ajax 
if (!function_exists('get_lensfinish_id'))   {

// For the users that are not logged in
add_action( 'wp_ajax_nopriv_get_lensfinish_id', 'get_lensfinish_id' );  

// For the users that are  logged in:  
add_action( 'wp_ajax_get_lensfinish_id', 'get_lensfinish_id' );
function get_lensfinish_id(){
$lens_finish_id = $_POST['lensFinish_id'];
setcookie("lensFinish_id","",time()-3600);
setcookie("lensFinish_id", $lens_finish_id, time() + (86400), "/");
die;
}
}


add_filter( 'woocommerce_add_cart_item_data', 'add_cart_item_data', 10, 3 );
function add_cart_item_data( $cart_item_data, $product_id, $variation_id ) {

   if( isset( $_POST['lens_type_PV'] ) ) {
     
   $lens_type           = $_POST['lens_type_PV'];
   $lens_prescription   = $_POST['tempfileid'];
   $lens_material       = $_POST['lens_material_pv'];
   $lens_Finish         = $_POST['lens_finish_pv'];
   $lens_choose         = $_POST['lens_choose_pv'];
   $options_addons      = $_POST['options_addon'];
   $lens_Tint           = $_POST['gradientcolor'];
   $lens_Gradient       = $_POST['gradient'];
   


	$cart_item_data['lens_type']      = $lens_type;

   if($lens_prescription != 'No Prescription'){
      $cart_item_data['tempfileid']     = "<a href = ".$lens_prescription." target='_blank'>View Prescription</a>";
   }	
   $cart_item_data['lens_material']  = $lens_material;
	$cart_item_data['lens_Finish']    = $lens_Finish;
	$cart_item_data['lens_choose']    = $lens_choose;
   $cart_item_data['gradientcolor']  = $lens_Tint;
	$cart_item_data['gradient']       = $lens_Gradient;
	
   
   if ($options_addons == 0){
      
   }	

   if ($options_addons > 0){
      $cart_item_data['options_addon']  = $options_addons;
   }	

  }
  echo '<pre>';
  print_r($cart_item_data);
  die;
 return $cart_item_data;
}

add_filter( 'woocommerce_get_item_data', 'display_cart_item_custom_meta_data', 10, 2 );
      function display_cart_item_custom_meta_data( $item_data, $cart_item ) {
         $Lens_Type          = 'Lens Type';
         $Lens_Prescription  = 'Lens Prescription';
         $Lens_Material      = 'Lens Material';
         $Lens_Finish        = 'Lens Finish';
         $Lens_Choose        = 'Lens Choose';
         $options_addon      = 'Options & Upgrades';

         if ( isset($cart_item['lens_type'])  ) {
            $item_data[] = array(
               'key'       => $Lens_Type,
               'value'      => $cart_item['lens_type'],
            );
         }
         
         if ( isset($cart_item['tempfileid'])  ) {
            $item_data[] = array(
               'key'       => $Lens_Prescription,
               'value'      => $cart_item['tempfileid'],
            );
         }
         if ( isset($cart_item['lens_material'])  ) {
            $item_data[] = array(
               'key'       => $Lens_Material,
               'value'      => $cart_item['lens_material'],
            );
         }
         if ( isset($cart_item['lens_Finish'])  ) {
            $item_data[] = array(
               'key'       => $Lens_Finish,
               'value'      => $cart_item['lens_Finish'],
            );
         }

         if ( isset($cart_item['lens_choose'])  ) {
            $item_data[] = array(
                  'key'       => $Lens_Choose,
                  'value'      => $cart_item['lens_choose'],
            );
         }

         
         if ( isset($cart_item['options_addon'])  ) {
            $item_data[] = array(
               'key'       => $options_addon,
               'value'      => $cart_item['options_addon'],
            );
         }

         return $item_data ;
         
      }

add_action( 'woocommerce_checkout_create_order_line_item', 'save_cart_item_custom_meta_as_order_item_meta', 10, 4 );
function save_cart_item_custom_meta_as_order_item_meta( $item, $cart_item_key, $values, $order ) {
   $meta_key = 'Lens Type';
   if ( isset($values['lens_type']) && isset($values['lens_type'][$meta_key]) ) {
      $item->update_meta_data( $meta_key, $values['add_size'][$meta_key] );
   }
}




add_action( 'woocommerce_before_calculate_totals', 'bbloomer_quantity_based_pricing', 9999 );
 
function bbloomer_quantity_based_pricing( $cart ) {
 foreach ( $cart->get_cart() as $cart_item_key => $cart_item ) {
     if(!empty($cart_item['options_addon'])){
      $option = $cart_item['options_addon'];
     }
     else{
      $option =0;
     }
      if (!empty($cart_item['lens_choose']) ) {
         $price = round( (int)$cart_item['data']->get_price() + (int)$cart_item['lens_choose'] +$option);
         $cart_item['data']->set_price( $price );
      }     
    }
     
 }

 // add data to order

 add_action( 'woocommerce_add_order_item_meta', 'lens_order_meta_handler', 1, 3 );
 // save into database
function lens_order_meta_handler( $item_id, $values, $cart_item_key ) {
   
   if( isset( $values['lens_type'] ) ) {
      wc_add_order_item_meta( $item_id, "lens Type", $values['lens_type'] );
     }
   if( isset( $values['tempfileid'] ) ) {
      wc_add_order_item_meta( $item_id, "lens Prescription", $values['tempfileid'] );
   }
   if( isset( $values['lens_material'] ) ) {
   wc_add_order_item_meta( $item_id, "lens material", $values['lens_material'] );
   }
   if( isset( $values['lens_Finish'] ) ) {
   wc_add_order_item_meta( $item_id, "lens Finish", $values['lens_Finish'] );
   }
   if( isset( $values['lens_choose'] ) ) {
      wc_add_order_item_meta( $item_id, "lens choose", $values['lens_choose'] );
   }
}

// upload prescription function
function upload_presxription_img()
{
   global $wpdb;
   // setting cookies for id
   $token = bin2hex(random_bytes(16));
   setcookie("prescription_id","$token",time()+ (86400), "/");
   // Upload Exhibitor Logo
   $file = $_FILES['file'];
   if (!empty($file)) {
       $uploads = wp_upload_dir();
       // Create 'user_avatar' directory if not exist
       $folderPath = ABSPATH . 'wp-content/uploads/purevision_prescription';
       if (!file_exists($folderPath)) {
           mkdir($folderPath, 0777, true);
       }
         $ext = end((explode(".", $_FILES['file']['name'])));
         if( $ext== 'png' || $ext== 'jpg' ){
         $ABSPATH_userAvatarFullImage = ABSPATH . 'wp-content/uploads/purevision_prescription/' . $_COOKIE['prescription_id'] . '.' . $ext;
         if (move_uploaded_file($_FILES['file']['tmp_name'], $ABSPATH_userAvatarFullImage)) {
           $prescription_url = get_home_url() . '/wp-content'. '/uploads'. '/purevision_prescription'.'/'.$_COOKIE['prescription_id']. '.' . $ext;
           echo $prescription_url;
         }
         else{
            echo "File not in format";
         }
      }
}
wp_die();
}
add_action("wp_ajax_upload_presxription_img", "upload_presxription_img");
add_action("wp_ajax_nopriv_upload_presxription_img", "upload_presxription_img");
