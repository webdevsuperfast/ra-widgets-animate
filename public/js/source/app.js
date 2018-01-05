(function($){
    AOS.init({
        offset: parseInt(rawa_aos.offset),
        duration: parseInt(rawa_aos.duration),
        easing: rawa_aos.easing,
        delay: parseInt(rawa_aos.delay),
        anchor: rawa_aos.anchor,
        disable: rawa_aos.disable,
        once: (rawa_aos.once == "true"),
    });
})(jQuery);