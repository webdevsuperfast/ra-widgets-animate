(function($) {
  var $disable;
  switch (rawa_usal.disable) {
    case "phone":
      $disable = "phone";
      break;
    case "mobile":
      $disable = "mobile";
      break;
    case "tablet":
      $disable = "tablet";
      break;
    case "custom":
      $disable = function() {
        var maxWidth = parseInt(rawa_usal.custom);
        return window.innerWidth < maxWidth;
      };
      break;
    default:
      $disable = false;
      break;
  }
  if ($disable && typeof $disable === "function" ? $disable() : $disable) {
    return;
  }
  window.USAL.config(
    {
      defaults: {
        duration: parseInt(rawa_usal.duration),
        delay: parseInt(rawa_usal.delay),
        threshold: parseInt(rawa_usal.threshold),
        easing: rawa_usal.easing
      },
      observersDelay: 50,
      once: rawa_usal.once
    }
  );
})(jQuery);
