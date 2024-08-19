jQuery(document).ready(function($) {
    $('.upload-image-button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        var custom_uploader = wp.media({
            title: 'Upload Image',
            button: {
                text: 'Use Image'
            },
            multiple: false
        });
        custom_uploader.on('select', function() {
            var attachment = custom_uploader.state().get('selection').first().toJSON();
            button.siblings('.store-icon').val(attachment.url);
            button.siblings('.image-preview').html('<img src="' + attachment.url + '" style="max-width: 100px; max-height: 100px;" />');
            button.siblings('.remove-image-button').show();
        });
        custom_uploader.open();
    });

    $('.remove-image-button').click(function(e) {
        e.preventDefault();
        var button = $(this);
        button.siblings('.store-icon').val('');
        button.siblings('.image-preview').html('');
        button.hide();
    });

    $('.image-preview').each(function() {
        var $this = $(this);
        if ($this.children('img').length === 0) {
            var defaultImage = '/wp-content/plugins/custom-store-map/images/default.jpg';
            $this.html('<img src="' + defaultImage + '" style="max-width: 100px; max-height: 100px;" />');
        }
    });
    $('.remove-image-button').each(function() {
        var button = $(this);
        if (button.siblings('.store-icon').val() === '') {
            button.hide();
        }
    });
});
