(function($) {
    $.marquee = function(selector, settings) {
        var config = {
            delay: 2000,
            fadeSpeed: 500,
            minLi: 8,
            directionMarquee: 'right2left'
        };
        if (settings) {
            $.extend(config, settings);
        }

        var delay = config.delay < 500 ? 500 : config.delay;
        var fadeSpeed = config.fadeSpeed < 100 ? 100 : config.fadeSpeed;

        var obj = $(selector);

        if (obj.length) {
            while (config.minLi > obj.find('li').size()) {
                obj.append(obj.html());
            }
            setTimeout(function() {
                moveMarquee();
            }, delay);
        }

        //==== Rolling do Slide ====================================================/
        function moveMarquee() {
            if (document.hasFocus()) {
                var liFirst = $('li',obj).first();
                var liLast = $('li',obj).last();
                switch (config.directionMarquee) {
                    case 'right2left':
                        liFirst.animate({width: '0px'}, fadeSpeed, function(){
                            obj.append('<li>' + liFirst.html() + '</li>');
                            liFirst.remove();
                        });
                        break;
                    case 'left2right':
                        liLast.animate({width: '0px'}, fadeSpeed, function(){
                            obj.append('<li>' + liLast.html() + '</li>');
                            liLast.remove();
                        });
                        break;
                }
                setTimeout(function() {
                    setTimeout(function() {
                        moveMarquee();
                    }, delay);
                }, 50 + fadeSpeed);
            } else
                setTimeout(function() {
                    setTimeout(function() {
                        moveMarquee();
                    }, delay);
                }, 50 + fadeSpeed);
        }
        return this;
    };
})(jQuery);