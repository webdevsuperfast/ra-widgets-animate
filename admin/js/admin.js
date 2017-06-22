(function($){
    $(document).on('panelsopen', function(e){
        var dialog = $(e.target);
        if ( !dialog.has('.so-panels-dialog-wrapper') ) return;
        $('.rawa-fields').hide();
    });
})(jQuery);