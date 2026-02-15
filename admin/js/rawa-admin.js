(function($) {
  $(document).on("click", ".rawa-toggle", function(e) {
    e.preventDefault();
    const $toggler = $(this);
    const $next = $toggler.next();
    $toggler.toggleClass("open");
    $next.toggle();
    localStorage.setItem("rawaDisplay", $next.is(":visible"));
  });
  $(document).on("widget-updated widget-added", function(event, widget) {
    const $toggler = $(widget).find(".rawa-toggle");
    const display = localStorage.getItem("rawaDisplay");
    if (display === "true") {
      $toggler.addClass("open");
      $toggler.next().show();
    }
  });
})(jQuery);
