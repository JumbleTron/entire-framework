(function($) {   
    var custom_uploader;
     
    $(".options-main-wrapper").tabs().addClass("ui-tabs-vertical ui-helper-clearfix");
    $(".menu li").removeClass("ui-corner-top").addClass("ui-corner-left");
    
     $('.ef-insert-media').click(function(e) {
        e.preventDefault();
        var $button = $(this);
        var multi = $(this).data('multi') == 'true' ? true : false;
        custom_uploader = wp.media.frames.file_frame = wp.media({
            title: 'Choose Image',
            button: {
                text: 'Choose Image'
            },
            multiple: multi
        });
        
        custom_uploader.on('select', function() {
            attachment = custom_uploader.state().get('selection').toJSON();
            if(!multi) {
                $('.ef-image-wrapper').html('<img src = "'+attachment[0].url+'" />');
                $button.parent().find('input[type="hidden"]').val(attachment[0].name);
            } 
            /*$.each(attachment, function(i, item) {
                $('.ef-image-wrapper').html('<img src = "'+item.url+'" />');
                $button.parent().find('input[type="hidden"]').val(item.name);
            });*/
        });
        
        custom_uploader.open();
        
    });
    
    
})(jQuery);

