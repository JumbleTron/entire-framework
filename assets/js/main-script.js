(function($) {   
    var custom_uploader;
    
    $(".options-main-wrapper").tabs();
    $(".menu li").removeClass("ui-corner-top").addClass("ui-corner-left");
    
    $('.remove_file').click(function(e) {
        e.preventDefault();
        $(this).parent().find('.ef-image-wrapper').html('');
        $(this).parent().find('input[type="hidden"]').val('');
    });
    
    $('.ef-insert-media').click(function(e) {
        e.preventDefault();
        var $button = $(this);
        var multi = $(this).data('multi') == 'true' ? true : false;
        custom_uploader = wp.media({
            title: 'Choose Image',
            library: { 
                type: $(this).data('file_type'),
            },
            button: {
                text: 'Choose Image',
                close: true
            },
            multiple: multi,
            returned_image_size: 'thumbnail'
        });
        
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').toJSON();
            if(!multi) {
                $button.parent().find('.ef-image-wrapper').html('<img src = "'+attachment[0].url+'" />');
                $button.parent().find('input[type="hidden"]').val(attachment[0].name);
            } 
            /*$.each(attachment, function(i, item) {
                $('.ef-image-wrapper').html('<img src = "'+item.url+'" />');
                $button.parent().find('input[type="hidden"]').val(item.name);
            });*/
        });
        
        custom_uploader.open();
    });
    
    $('.ef-color_picker').wpColorPicker();
        
    $(window).scroll(function() {
        var top = $(this).scrollTop();
        if(top > $('.ef-theme-options-buttons').offset().top) {
            if($(this).scrollTop()+$(this).height() > $(document).height()-50) {
                $('.ef-theme-options-buttons-bottom').removeClass('sticky');
            } else {
                $('.ef-theme-options-buttons-bottom').addClass('sticky'); 
            }
        } else {
           $('.ef-theme-options-buttons-bottom').removeClass('sticky'); 
        }
    });
    
})(jQuery);



