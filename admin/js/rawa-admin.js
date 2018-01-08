(function($){
    $(document).on('click', '.rawa-toggle', function(e) {
		e.preventDefault();

		var toggler = $(this);

		toggler.toggleClass('open');
		toggler.next().toggle();

		// Add display to local storage
		localStorage.setItem('rawaDisplay', toggler.next().is(':visible'));
	});

	$(document).on('widget-updated widget-added', function(event, widget){
		$(widget).each(function(){
			var toggler = $(this).find('.rawa-toggle');
			var display = localStorage.getItem('rawaDisplay');
			if (display == 'true') {
				toggler.toggleClass('open');
				toggler.next().show();
			}
		});
	});
})(jQuery);