<?php
/**
*Front-layout

*/
// adding frontend js file 
add_action( 'wp_enqueue_scripts', 'my_plugin_assets' );
function my_plugin_assets() {
wp_enqueue_script( 'jquery-js', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js' );
wp_enqueue_script( 'bootstrap-js', 'https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js' );
wp_enqueue_script( 'purevision-js', plugins_url( '/js/purevision.js' , __FILE__ ) );
wp_enqueue_style('purevision-style', plugins_url( '/style/main.css' , __FILE__ ) );

}

add_action('woocommerce_after_add_to_cart_button','select_lens_button');
function select_lens_button() {
$enbles = get_post_meta( get_the_ID(), 'pescription_status')[0];
if ($enbles == 'yes') {

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

// For the users that are not logged in
add_action( 'wp_ajax_nopriv_get_lensType_id', 'get_lensType_id' );  

// For the users that are  logged in:  
add_action( 'wp_ajax_get_lensType_id', 'get_lensType_id' );
function get_lensType_id(){
$lens_type_id = $_POST['lens_type'];
setcookie("lens_type_id","",time()-3600);
setcookie("lens_type_id", $lens_type_id, time() + (86400), "/"); // 86400 = 1 day
die;
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


add_action( 'woocommerce_before_add_to_cart_button', 'bbloomer_custom_action' );
function bbloomer_custom_action() {

global $wpdb;
global $product;
$args = array(
'post_type' => 'product',
'posts_per_page' =>-1,
);
$loop = new WP_Query( $args );
foreach($loop as $productnew){
global $wpdb;
global $product;
$product_id = get_the_ID();
$title = get_the_title();
$image =  wp_get_attachment_image_url( get_post_thumbnail_id( $product_id ), 'single-post-thumbnail' );
$img = $image;
$curry= get_woocommerce_currency_symbol(); 
if ( $product->is_on_sale() ) {
   $salePrice = $product->get_sale_price($product_id);
   }
   else{
   $salePrice = $product->get_regular_price($product_id);
   }
}
?>
<!-- main -->
<section role="main">
<div role="main-wrap">
<div class = "Advanced_lens">
<div role="right-usage">
<div role="list-box">
<div role="left-wrap">
<div role="glasses-img">
<img src="<?php echo $img;?>"  alt="">
</div>
<div role="left-wrap-content" style="margin-top:100px;">
<!-- product brand name -->
<h4><a href="#"><?php echo $title;?></a></h4><p>Eyeglasses</p>

<!-- product name -->
<div role="final-price">
<!-- subtotal  price -->
<p class = "PV_total">Subtotal:<span> <?php echo $curry ?><span class = "PV_salePrice" data-price="<?php echo $salePrice; ?>" ><?php echo $salePrice; ?></span></span></p>
<p class = "PV_totalPrice" >Subtotal:<span> <?php echo $curry ?><span class = "PV_finalPrice"></span></span></p>
</div>
</div>
</div>
<!-- right-tabs -->
<div role="right-wrap-fullbody">
<span class="close_purevision">X</span>
<div class="purevw_nextprv">
<a href="#" id="prev" class="purevw_popup_prev" disabled="disabled" style="display:none;">Previous</a>
<!--<a href="#" id="next" class="purevw_popup_next" style="float:right; margin-right:25px;">Next</a>-->  
</div>
<div class="usage_s">
<div role="right-wrap" >
<div role="top">
<div id="progressbar">
</div> 
<img src="<?php echo plugins_url('Purevision/img/eyewear.gif'); ?>" id="loading_div" style="display:none;">
</div>

<!-- popup content start  -->
<!-- showing selected lens types from admin  -->
<fieldset>
<div class="usage_div_box step active">
<?php
$lens_types_front = get_post_meta( $product_id, '_lens_types', true);
foreach ($lens_types_front as $key => $lens_id){
$lens_type_item = $wpdb->get_row($wpdb->prepare("SELECT * FROM {$wpdb->prefix}purevision_lense_types WHERE lens_type_id = %d", $lens_id));
if($lens_type_item != NULL){?>
<li role="box" >
<input type="checkbox"  id = "lens_type" value="<?php echo $lens_type_item->lens_name; ?>" class="purevw_uses_box" data-name="<?php echo $lens_type_item->lens_type_id  ; ?>" name="lens_type_PV">
<?php
$lens_img = $lens_type_item->image;
if(!empty($lens_img)){
$lens_image = wp_get_attachment_image_url($lens_img, 'full');
}
else {
$lens_image = plugins_url( Plugin_folder_name().'/img/distance.png');
}
?>
<img src= "<?php echo $lens_image;?>">
<div role="info">
<h5><?php echo $lens_type_item->lens_name;?></h5>
<p><?php echo $lens_type_item->desc;?></p>
</div>
<span role="inforbutton">
i 
<div role="tootip--area">
<div role="inner--content">
<div role="tool--image">
<img src="<?php echo plugins_url( Plugin_folder_name().'/img/house.png');?>">
</div>
<div role="tool--text">
<h4>Single Vision Distance Lenses</h4>
<p>Distance lenses are needed when things up close appear clear, while things further away look
blurry.
</p>
</div>
</div>
</div>
</span>
<!-- tab-content -->
</li>
<?php 
}
}?>
</div>
</div>
</div>
</fieldset>

<!-- prescription part-->
<fieldset>
<div class="upload_prescription_div_box step" style="display: none;">
<div role="right-wrap">
<div role="top">
<div role="top-content">
<h5>Prescription</h5>
</div>
</div>
<div id="rx-prescription-container" class="rx-prescription-container none" style="display: block;">
<div role="purpose--spec">
<p>Please upload your prescription or email us</p>
<div role="form-inner">
<div role="radio-checkbox-col">
<label>
<input type="checkbox" id="persp_check" >
<span role="checkboxes"></span>
</label>
<span>
<h5>Select a file to upload.</h5>
<p>JPG OR PNG. Max file size 5 MB</p>
</span>
</div>
<div role="prescription_options">
<input type="file" class="purevw_prescription" id="upload_pres_file"  name = "file">
<div class="temp_file_id"></div>

<label for="upload-file">
<img src="<?php echo plugins_url( Plugin_folder_name().'/img/upload.svg');?>"> <span>Upload Prescription</span></label>
</div>
<div role="top" id="pers_progress">
<img src="https://media.geeksforgeeks.org/wp-content/uploads/20210722235713/hb.gif"/>
</div> 
<input type="button" id="removeImage1" value="x" class="btn-rmv1" />
<b class="text-success"><em>Successfully Uploaded!</em></b> 
</div>

<div role="form-inner" id="pers_email">
<div role="radio-checkbox-col">
<label>
<input type="checkbox" id="pers_email_check">
<span role="checkboxes"></span>
</label>
<span>
<h5>You can email your prescription to: </h5>
<a href="mailto:rx@domainname.com">rx@domainname.com</a>
</span>
</div>
<div role="patient-type">
<label>Patient's Name:</label>
<input type="text" disabled="disabled" id="prs_email">
<em>Name needed to help us match the submitted document to your order</em>
</div>
</div>
<a href="#" class="custom-btn purevw_btn mt-3 skipbtn" >Skip To Next Step</a>
</div>
</div>
</div>
</div>
<!--code section end -->
</fieldset>
<!-- prescription part end-->

<!-- Choose Lenses section start -->

<fieldset>

<div class="choose_material_lenses_div_box step" style="display: none;">
<div role="right-wrap">
<div role="top">
<div role="top-content">
<h5>Choose Lens Material</h5>

</div>
</div>
<div id="rx-prescription-container" class="rx-prescription-container none" style="display: block;">                      
<div class="tips-prescription-content">
<div role="lenses-row">
<?php
global $wpdb;

$lens_material_tbl = $wpdb->prefix . 'purevision_lens_material';
$lens_material_results = $wpdb->get_results("SELECT * FROM $lens_material_tbl");
foreach($lens_material_results as $lens_material => $value)
{
?>
<li role = "box">
<div class="purevw_lens_material_box">
<?php
$lensmaterial_img = $value->image;
if(!empty($lensmaterial_img)){
$lensmaterial_img = wp_get_attachment_image_url($lensmaterial_img, 'full');
}
else {
$lensmaterial_img = plugins_url( Plugin_folder_name().'/img/lens.png');
}
?>
<img src="<?php echo $lensmaterial_img; ?>" class="purevw_iconimg">
<h3><?php echo $value->lens_material_name;?></h3>
<input type="checkbox" value="<?php echo $value->lens_material_name;?>" class="lens_material_id" data-name = "<?php echo $value->lens_material_id;?>" name = "lens_material_pv">
<p><?php echo $value->desc;?></p>

<div role="price-range">
<span>Price Range</span>
<strong><?php echo get_woocommerce_currency_symbol(); ?>0-$129</strong>
</div>
</div>
</li>
<?php
}
?>
</div>
</div>


</div>
</div>

</div>
<!--code section end -->

</fieldset>
<!-- Choose Lenses section end -->

<!-- Choose Finish Lenses section start -->

<fieldset>

<div class="choose_finish_lenses_div_box step" id="lens_finish" style="display: none;">
<div role="right-wrap">
<div role="top">
<div role="top-content">
<h5>Choose Lens Finish</h5>
</div>
</div>
<div id="rx-prescription-container" class="rx-prescription-container none" style="display: block;">                      
<div class="tips-prescription-content">
<?php
global $wpdb;
if(isset($_COOKIE['lens_type_id'])) {
$lens_id_frm_cookie = (int)$_COOKIE['lens_type_id'];
$lens_finish_tbl = $wpdb->prefix . 'purevision_lens_finishing';
$lens_finish_results = $wpdb->get_results("SELECT * FROM $lens_finish_tbl WHERE `lens_type_id` =  $lens_id_frm_cookie");
foreach($lens_finish_results as $lens_finish => $value)
{
?>
<li role="box" >
<input type="checkbox"  id="<?php echo $value->lens_finish_id; ?>" class="purevw_lens_finish_box" data-name="<?php echo $value->lens_finish_name; ?>" name="lens_finish_pv" value = "<?php echo $value->lens_finish_name; ?>">
<?php
$lens_finish_img = $value->image;
if(!empty($lens_finish_img)){
$lens_finish_img = wp_get_attachment_image_url($lens_finish_img, 'full');
}
else {
$lens_finish_img = plugins_url( Plugin_folder_name().'/img/book.png');
}
?>
<img src="<?php echo $lens_finish_img; ?>">
<div role="info">

<h5><?php echo $value->lens_finish_name;?></h5>
<p><?php echo $value->desc;?></p>
</div>
<!-- tab-content -->
</li>
<?php
}
}else {
?>
<h3>Nothing Found!!</h3>
<p>Please Refresh to continue</p>
<?php
}
?>
</div>


</div>
</div>
<!--code section end -->


</fieldset>
<!-- Choose Finish Lenses section end -->



<!-- Choose Lenses section start -->

<fieldset>

<div class="choose_lenses_div_box step" style="display: none;">
<div role="right-wrap">
<div role="top">
<div role="top-content">
<h5>Choose Lens</h5>
</div>
</div>
<div id="rx-prescription-container" class="rx-prescription-container none" style="display: block;">
<div class="tips-prescription-content">
<div role="tint-color">
<div role="tint-density">
<?php
global $wpdb;
$lens_materialID = (int)$_COOKIE['lens_material_id'];
$lens_FinishID = (int)$_COOKIE['lensFinish_id'];
$lens_choose_tbl = $wpdb->prefix . 'purevision_lens_choose';
$lens_choose_results = $wpdb->get_results("SELECT * FROM $lens_choose_tbl WHERE `lens_material_id` = $lens_materialID OR `lens_finish_id`= $lens_FinishID; ");
foreach($lens_choose_results as $lens_choose)
{
?>
<li role="box" >
<div class="choose_purevision">
<!-- <img src="<?php echo plugins_url( Plugin_folder_name().'/img/lens.png');?>" class="purevw_iconimg"> -->

<h3><?php echo $lens_choose->name;?></h3>
<input type="checkbox" name = "lens_choose_pv" value="<?php echo $lens_choose->price;?>" class="lens_price" data-name = "<?php echo $lens_choose->price; ?>" >
<p><?php echo $lens_choose->desc;?></p>

<div role="price-range">
<span>Price Range</span>
<strong><?php echo $lens_choose->price; ?></strong>
</div>
</div>
</li>
  
<?php
}
?>
 </div>
</div>
</div>
<!--code section end -->


</fieldset>
<!-- Choose Finish Lenses section end -->

<!-- step checkout row -->
<fieldset>
   <div class="step_checkout_div_box step" style="display: none;">
   <div role="stepper-step">
                  <div role="upgardes">
                     <!-- <div role="top"> 
                        <h4>Options & Upgrades </h4>
                        <ul>
                           <li class="step-complete"></li>
                           <li  class="step-complete"></li>
                           <li  class="step-complete"></li>
                           <li  class="step-complete"></li>
                           <li class="active"></li>
                           <li></li>
                        </ul>
                     </div> -->
                     <div role="tint-color">
                        <h6>Tint Density:</h6>
                        <div role="tint-density">
                           <div role="density-col" class="density-active add-on-select">
                              <h4>UV Protection</h4>
                              <p>A clear UV casting to help protect your eyes from harmful sun exposure.
                              </p>
                              <div role="additional-text">
                              <h5 role="included" class="included">included</h5>
                              </div>
                           </div>
                           <div role="density-col"  class="density-active add-on-select">
                              <h4>Scratch-Resistant Coating</h4>
                              <p>Keep your lenses looking like new.
                              </p>
                              <div role="additional-text">
                              <h5 role="included" class="included">included</h5>
                              </div>
                           </div>
                           <div role="density-col" class="add-on-coatings">
                              <h4>Lens Edge Polish</h4>
                              <p>Provides a glossy edge finish </p>
                              <div role="additional-text">
                                 <input type="hidden" value="0" name="options_addon" class="options_addon_input">
                                 <button class="not_included add_oncaoting_price" data-price="5" disabled>Add <?php echo get_woocommerce_currency_symbol(); ?>5</button>
                              <h5 role="included" class="included" style="display:none;">Added</h5>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- step checkout row -->
       <div role="stepper-step">
            <div role="checkout-row">
               <div role="checkout-col">
                  <table>
                     <tbody>
                        <tr>
                           <td>
                              Frames:
                           </td>
                           <td><?php echo get_woocommerce_currency_symbol() . $salePrice ?></td>
                        </tr>
                        <tr>
                           <td>
                              Lenses:
                           </td>
                           <td><?php echo get_woocommerce_currency_symbol(); ?><span class = "PV_lensprice"></span></td>
                        </tr>
                        <tr>
                           <td>
                              Option & Upgrades:
                           </td>
                           <td><?php echo get_woocommerce_currency_symbol(); ?><span class = "coating_price">0</span></td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                           <td>Subtotal:</td>
                           <td><?php echo get_woocommerce_currency_symbol(); ?><span class = "PV_finalPrice"></span></td>
                        </tr>
                     </tfoot>
                  </table>
                  <div role="cart-option">
                  <button role = "addto-cart" class="purevision_add_to_cart" type="submit" name="add-to-cart" value="<?php echo $product_id;?>" >Add to cart</button>
                  </div>
            </div>
         </div>
</div>
</div>
<!-- right part end-->
</div>
</div>
</div>
</section>
<?php 
// endwhile;



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
   
    

	$cart_item_data['lens_type']      = $lens_type;

   if($lens_prescription != 'No Prescription'){
      $cart_item_data['tempfileid']     = "<a href = ".$lens_prescription." target='_blank'>View Prescription</a>";
   }	
   $cart_item_data['lens_material']  = $lens_material;
	$cart_item_data['lens_Finish']    = $lens_Finish;
	$cart_item_data['lens_choose']    = $lens_choose;
   
   if ($options_addons == 0){
      
   }	

   if ($options_addons > 0){
      $cart_item_data['options_addon']  = $options_addons;
   }	

  }
 
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














