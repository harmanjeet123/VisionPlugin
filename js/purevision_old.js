// Scripting for frontend PureVision


jQuery(document).ready(function () {
  var price, total_price, salePrice;
  // popup screens 
  var choose_lens_type = jQuery(".usage_div_box");
  var add_priscription = jQuery(".upload_prescription_div_box");
  var lens_material = jQuery(".choose_material_lenses_div_box");
  var lens_finish = jQuery(".choose_finish_lenses_div_box");
  var choose_lens = jQuery(".choose_lenses_div_box");
  var step_to_checkout = jQuery(".step_checkout_div_box");
  var currentScreen = choose_lens_type;

  // purevision popup open
  jQuery("#select_lens").click(function () {
    jQuery(".Advanced_lens").show();
  });
  // purevision popup close
  jQuery(document).on("click", ".close_purevision", function () {
    jQuery(".Advanced_lens").delay("slow").hide();
  });

  // lens type function
  jQuery(document).on("click", ".purevw_uses_box", function () {
    lensType = jQuery(this).attr("value");
    lens_type = $(this).data("name");
    jQuery.ajax({
      type: "POST",
      dataType: "html",
      url: ajaxurl,
      data: {
        action: "get_lensType_id",
        lens_type: lens_type,
      },
      beforeSend: function () {
        jQuery('#loading_div').show();
      },
      success: function (response) {
        if (lensType == "NON-PRESCRIPTION") {
          choose_lens_type.hide();
          lens_material.show();
          currentScreen = lens_material;
          jQuery("#prev").show();
        } else {
          choose_lens_type.hide();
          add_priscription.show();
          currentScreen = add_priscription;
          jQuery("#prev").show();
        }
        jQuery('#loading_div').hide();
      },
    });
  });
  jQuery(document).on("click", ".purevw_prescription", function () {
    document.getElementById("persp_check").checked = true;
    jQuery(".purevw_prescription_checkbox").attr("checked", true)
    $('#pers_email_check').prop('checked', false);
    $('#prs_email').prop("disabled", true);
  });


  jQuery(document).on("change", ".purevw_prescription", function () {
    if (jQuery(this).val() != "") {
      prescription_values = jQuery(".purevw_prescription").prop("files");
      prescription_uploaded = true;
      var files = jQuery(".purevw_prescription").prop("files");
      var file_name = jQuery(".purevw_prescription").prop("files")[0].name;
      var file_size = jQuery(".purevw_prescription").prop("files")[0].size;
      var fileSize = Math.round((file_size / 1024));
      var fileInput =
        document.getElementById('upload_pres_file');

      var filePath = fileInput.value;
      var allowedExtensions = /(\.jpg|\.png)$/i;

      if (!allowedExtensions.exec(filePath)) {
        alert('Invalid file type');
        fileInput.value = '';
        return false;
      }
      else if (fileSize >= 5 * 1024) {
        alert('File size too Big');
        return false;
      }
      else {
        var fd = new FormData();
        fd.append("file", files[0]);
        fd.append("name", file_name);
        fd.append("action", "upload_presxription_img"); // your ajax function
        jQuery.ajax({
          type: "POST",
          url: ajaxurl, //  var ajax_url = " <?= admin_url('admin-ajax.php'); ?>"; pass it in the php file
          processData: false,
          contentType: false,
          data: fd,
          beforeSend: function () {
            jQuery('#pers_progress').show();
          },
          success: function (result) {
            // Success code
            jQuery('#loading_div').hide();
            jQuery('.tempfile_id').remove();
            jQuery('.temp_file_id').append('<input type="hidden" class="tempfile_id" value="' + result + '" name="tempfileid">');
            jQuery('.skipbtn').addClass('nextbtn');
            jQuery('.nextbtn').removeClass('skipbtn');
            jQuery('.nextbtn').html("Proceed to next step")
            jQuery('b.text-success').show();
            jQuery('.btn-rmv1').addClass('rmv');
            jQuery('#pers_progress').hide();
            jQuery('#persp_check').prop('checked', true);
          },
          error: function (request, status, error) {
            alert(request.responseText);
          },
        });
      }
    } else {
      alert("Please Select a Prescription File.");
    }
  });
  jQuery(document).on("click", ".purevw_lens_material_box", function () {
    // lensType = jQuery(this).attr('name');
    lens_material.hide();
    lens_finish.show();
    currentScreen = lens_finish;
  });


  jQuery(document).on("click", ".purevw_lens_finish_box", function () {
    lensType = jQuery(this).attr("name");
    lens_finish.hide();
    choose_lens.show();
    currentScreen = choose_lens;
  });

  jQuery(document).on("click", ".choose_purevision", function () {
    lensType = jQuery(this).attr("name");
    choose_lens.hide();
    step_to_checkout.show();
    currentScreen = step_to_checkout;
  });

  //skip step
  jQuery(document).on("click", ".skipbtn", function () {
    jQuery('.temp_file_id').append('<input type="hidden" value="No Prescription" name="tempfileid">');
    add_priscription.hide(200);
    lens_material.show(200);
    currentScreen = lens_material;
  });

  // previous next function
  jQuery(document).on("click", "#prev", function () {
    if (currentScreen == add_priscription) {
      add_priscription.hide(200);
      choose_lens_type.show(200);
      currentScreen = choose_lens_type;
      jQuery("#prev").hide();
    } else if (currentScreen == lens_material) {
      if (lensType == "NON-PRESCRIPTION") {
        lens_material.hide(200);
        add_priscription.hide(200);
        choose_lens_type.show(200);
      } else {
        lens_material.hide(200);
        add_priscription.show(200);
        currentScreen = add_priscription;
      }
    } else if (currentScreen == lens_finish) {
      lens_finish.hide(200);
      lens_material.show(200);
      currentScreen = lens_material;
    } else if (currentScreen == choose_lens) {
      choose_lens.hide(200);
      lens_finish.show(200);
      currentScreen = lens_finish;
    }
    else if (currentScreen == step_to_checkout) {
      step_to_checkout.hide(200);
      choose_lens.show(200);
      currentScreen = choose_lens;
    }
  });
  // prev function end


  // choose lens material ---- getting id 
  jQuery(document).on("click", '.purevw_lens_material_box', function () {
    lens_material_id = jQuery(this).find(".lens_material_id").data("name");
    jQuery.ajax({
      type: "POST",
      dataType: "html",
      url: ajaxurl,
      data: {
        action: "get_lensmaterial_id",
        lens_material_id: lens_material_id,
      },
      beforeSend: function () {
        jQuery('#loading_div').show();
      },
      success: function (response) {
        jQuery('#loading_div').hide();
      },
    });
  });

  // lens finish id 

  jQuery(document).on("click", '.purevw_lens_finish_box', function () {
    lensFinish_id = jQuery(this).attr("id");
    console.log(lensFinish_id);
    jQuery.ajax({
      type: "POST",
      dataType: "html",
      url: ajaxurl,
      data: {
        action: "get_lensfinish_id",
        lensFinish_id: lensFinish_id,
      },
      beforeSend: function () {
        jQuery('#loading_div').show();
      },
      success: function (response) {
        jQuery('#loading_div').hide();
      },
    });
  });
  //for selcting price from subtotal 


  salePrice = jQuery('.PV_salePrice').data("price");
  console.log(salePrice);
  jQuery(".PV_total").show();
  jQuery('.PV_totalPrice').hide();

  jQuery('.choose_purevision').click(function () {
    price = jQuery(this).find('.lens_price').data("name");
    console.log(price);

    total_price = + parseFloat(salePrice).toFixed(2) + +parseFloat(price).toFixed(2);
    console.log(parseFloat(total_price).toFixed(2));

    // jQuery('.').html();
    if (jQuery("span").hasClass('PV_finalPrice')) {
      jQuery(".PV_finalPrice").html('');
      jQuery(".PV_finalPrice").html((total_price).toFixed(2));
      jQuery(".PV_total").hide();
      jQuery('.PV_totalPrice').show();
    }


  });
  jQuery('.choose_purevision').click(function () {
    price = jQuery(this).find('.lens_price').val();
    jQuery(".PV_lensprice").html(price);
  });


  jQuery("#persp_check").click(function () {
    if (jQuery(this).is(":checked")) {
      jQuery('#pers_email_check').prop('checked', false);
      jQuery('#prs_email').prop("disabled", true);
    }
  });
  jQuery("#pers_email_check").click(function () {
    if (jQuery(this).is(":checked")) {
      jQuery('#persp_check').prop('checked', false);
      jQuery('#prs_email').prop("disabled", false);
    }
    jQuery("#removeImage1").trigger('click');
  });
  jQuery("#removeImage1").click(function (e) {
    e.preventDefault();
    jQuery(".tempfile_id").remove();
    jQuery(".purevw_prescription").val('');
    jQuery("#imag").val("");
    jQuery("#ImgPreview").attr("src", "");
    jQuery('.preview1').removeClass('it');
    jQuery('.btn-rmv1').removeClass('rmv');
    jQuery('b.text-success').hide();
  });
  jQuery('b.text-success').hide();
  jQuery('#pers_progress').hide();

  jQuery('.add-on-coatings').click(function () {

    coating_price = jQuery(this).find(".add_oncaoting_price").data("price");
    if (jQuery(this).hasClass("density-active")) {
      jQuery('input[name="options_addon"]').val(coating_price);
      jQuery(this).removeClass("density-active");
      jQuery(this).find('.not_included').show();
      jQuery(this).find('.included').hide()
      jQuery(".coating_price").html("0");
      jQuery(".PV_finalPrice").html(parseFloat(total_price).toFixed(2));
    } else {
      jQuery(this).addClass("density-active");
      jQuery(this).find('.not_included').hide();
      jQuery(this).find('.included').show();
      jQuery('input[name="options_addon"]').val(coating_price);
      jQuery(".coating_price").html(coating_price);
      jQuery(".PV_finalPrice").html(parseFloat(total_price + coating_price).toFixed(2));
    }
  });

  jQuery('.add-on-select').click(function () {
    coating_price = jQuery(this).find(".add_oncaoting_price").data("price");
    if (jQuery(this).hasClass("density-active")) {
      jQuery(this).removeClass("density-active");
      jQuery(this).find('.not_included').show();
      jQuery(this).find('.included').hide()
    } else {
      jQuery(this).addClass("density-active");
      jQuery(this).find('.not_included').hide();
      jQuery(this).find('.included').show();
    }
  });

  jQuery(document).on("click", ".nextbtn", function () {
    add_priscription.hide(200);
    lens_material.show(200);
    currentScreen = lens_material;
  })

  jQuery(".add_oncaoting_price").click(function () {
    jQuery('.add-on-coatings').addClass("density-active");
  });
});   // document ready end 