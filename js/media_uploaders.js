jQuery(document).ready(function($) {
    $('.upload_image_button').click(function() {
        var send_attachment_bkp = wp.media.editor.send.attachment;
        var button = $(this);
        wp.media.editor.send.attachment = function(props, attachment) {
            imgpath= document.getElementsByClassName('pure_view_lens_image');
            console.log(imgpath);
            console.log($(button).parent().prev().attr('src', attachment.url));
            $(button).prev().val(attachment.id);
            wp.media.editor.send.attachment = send_attachment_bkp;
            console.log(attachment.url)
        }
        wp.media.editor.open(button);
        return false;
    });

    $('.remove_image_button').click(function() {
        if (confirm('Are you sure?')) {
            var src = $(this).parent().prev().attr('data-src');
            $(this).parent().prev().attr('src', src);
            $(this).prev().prev().val('');
        }else {
        return false;
        }
    });

    $('a:contains("Tints of Coatings")').parent('li').hide();

});