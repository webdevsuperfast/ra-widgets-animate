(function($){
  function toggleIt() {
    $('body').on('click', '.rawa-toggle', function(e){
      $(this).toggleClass('open');
      $('.rawa-field').toggle();
      e.preventDefault();
    });
  }

  $(document).on('widget-updated', function(event, widget){
    $(widget).each(function(){
      $('.rawa-field').toggle();
    });
  });

  toggleIt();
})(jQuery);