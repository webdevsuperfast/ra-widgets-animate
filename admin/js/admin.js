(function($){
    $('body').on('click', '.rawa-toggle', function(e){
		$(this).toggleClass('open');
		$('.rawa-field').toggle();
    });
})(jQuery);