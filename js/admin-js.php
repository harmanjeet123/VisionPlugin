<?php

// woocommerce product tav js 
function wccp_custom_script() {
?>

<script>

if(window.jQuery)
{
jQuery(document).ready(function($) {

function change_options() {

var typeval = $('[name="_glass_type"]').val();

if (typeval == 'eye-glass') {
$('._lens_types.hide_on_option').removeClass('hidenn');
$('._lens_finishing.hide_on_option').removeClass('hidenn');
$('._lens_choose.hide_on_option').removeClass('hidenn');

$('._lens_types_lens.hide_on_option').addClass('hidenn');

} else if(typeval == 'sun-glass') {
$('._lens_types_lens.hide_on_option').addClass('hidenn');
$('._lens_types.hide_on_option').removeClass('hidenn');
$('._lens_finishing.hide_on_option').removeClass('hidenn');
$('._lens_choose.hide_on_option').removeClass('hidenn');


} else {
$('._lens_types_lens.hide_on_option, ._lens_types.hide_on_option').addClass('hidenn');
}

}

$('[name="_glass_type"]').change(function(e) {
change_options();
});

change_options();

});
}
</script>

<?php
}
add_action( 'admin_footer', 'wccp_custom_script' );  


// add choose lens function script 
add_action( 'admin_footer', 'add_choose_lens_script' );  
function add_choose_lens_script(){
?>
<script type="text/javascript">
jQuery(document).ready(function($){
$(".thickness_check").click(function() {
var checkbox_Array = $('.thickness_check:checked').map(function() {return this.value;}).get().join(',');
$("#thickness_hidden").val(checkbox_Array);
recommended_radio($);
});
recommended_radio($);
});
function recommended_radio($) {
$(".recommended_p").remove();
if ($('.thickness_p input:checked').length > 0) {
var already = '<?= $item['recommended_thickness']; ?>';
var html = '<p class="recommended_p"><label>Recommended Thickness</label><br>';
var checked = '';
$('.thickness_p input:checked').each(function(index, el) {
var checkbox = $(el);
var title = checkbox.next().text();
if (already == checkbox.val()) {
checked = 'checked';
}
html += '<input type="radio" name="recommended_thickness" value="'+checkbox.val()+'" id="radio-r-'+checkbox.val()+'" '+checked+'><label for="radio-r-'+checkbox.val()+'">'+title+'</label><br>';
checked = '';
});
html += '</p>';
$(html).insertAfter('.thickness_p');
}
}
</script>
<?php
}


// add lens finish fn 
add_action( 'admin_footer', 'add_lens_finish_script' );  

function add_lens_finish_script(){
?>
<script type="text/javascript">
jQuery(document).ready(function($){

$(".thickness_check").click(function() {
var checkbox_Array = $('.thickness_check:checked').map(function() {return this.value;}).get().join(',');
$("#thickness_hidden").val(checkbox_Array);

recommended_radio($);

});

recommended_radio($);

});

function recommended_radio($) {

$(".recommended_p").remove();

if ($('.thickness_p input:checked').length > 0) {

var already = '<?= $item['recommended_thickness']; ?>';

var html = '<p class="recommended_p"><label>Recommended Thickness</label><br>';

var checked = '';

$('.thickness_p input:checked').each(function(index, el) {

var checkbox = $(el);
var title = checkbox.next().text();

if (already == checkbox.val()) {
checked = 'checked';
}

html += '<input type="radio" name="recommended_thickness" value="'+checkbox.val()+'" id="radio-r-'+checkbox.val()+'" '+checked+'><label for="radio-r-'+checkbox.val()+'">'+title+'</label><br>';
checked = '';

});

html += '</p>';

$(html).insertAfter('.thickness_p');

}


}

</script>
<?php
}
function select_multiple_value(){
    ?>
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

add_action( 'admin_footer', 'select_multiple_value' );  
