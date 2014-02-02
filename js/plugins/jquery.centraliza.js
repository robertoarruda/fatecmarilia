(function($){
    $.centraliza = function (e, callback){
        if(e.length) {
            e.css('position','absolute');
            var w= e.width()/2;
            var h= e.height()/2;
            var rw= $(window).width()/2;
            var rh= $(window).height()/2;
            var x= rw-w;
            var y= rh-h;

            if (w > rw)
                e.css('left',0);
            else
                e.css('left',x);
            if (h > rh) 
                e.css('top',0);
            else
                e.css('top',y);
            
            if(callback)
                callback(true);
            
            return this;
            
        } else {
            if(callback)
                callback(false);
            
            return false;
        }
    };
})(jQuery);