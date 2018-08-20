(function($){
    var $disable;
    
    switch(rawa_aos.disable) {
        case 'phone':
            $disable = 'phone';
            break;
        case 'mobile':
            $disable = 'mobile';
            break;
        case 'tablet':
            $disable = 'tablet';
            break;
        case 'custom':
            $disable = function() {
                var maxWidth = parseInt(rawa_aos.custom);
                return window.innerWidth < maxWidth;
            }
            break;
        default:
            $disable = false;
            break;
    }

    AOS.init({
        offset: parseInt(rawa_aos.offset),
        duration: parseInt(rawa_aos.duration),
        easing: rawa_aos.easing,
        delay: parseInt(rawa_aos.delay),
        anchor: rawa_aos.anchor,
        disable: $disable,
        once: (rawa_aos.once == "true"),
    });
})(jQuery);