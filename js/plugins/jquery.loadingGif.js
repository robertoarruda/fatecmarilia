(function($){
    $.getScript('/js/plugins/jquery.centraliza.js');
    
    $.loadingGif = function(settings, callback){
        var config = {
            on: true,
            scrollbarOnClose: true,
            img: '/imagens/layout/estrutura/gif/loadingBlack.gif'
        };
        if (settings){
            $.extend(config, settings);
        }
        
        if(config.on){
            if(!$('#divLoadingGif').length){
                $('<div id="divLoadingGif">').html(
                    '<style type="text/css" media="all">'+
                    'div#divLoadingGif {'+
                    'position: fixed !important;'+
                    'background-color: rgba(0,0,0,0.9) !important;'+
                    'left: 0px !important;'+
                    'top: 0px !important;'+
                    'width: 100% !important;'+
                    'height: 100% !important;'+
                    'z-index: 1000 !important;'+
                    '}'+
                    'div#divLoadingGif img#gif {'+
                    'position: absolute !important;'+
                    'width: 116px !important;'+
                    'height: 116px !important;'+
                    'left: 50% !important;'+
                    'top: 50% !important;'+
                    'margin-left: -58px !important;'+
                    'margin-top: -58px !important;'+
                    '}'+
                    '</style>'+
                    '<img id="gif" src="'+config.img+'">'
                    )
                .appendTo('body');
                $('#divLoadingGif').hide();
                $('#divLoadingGif img').load(function(){
                    $('#divLoadingGif').fadeIn('fast', function(){
                        if ($('html').css('overflow') != 'hidden')
                            $('html').css('overflow', 'hidden');
                    });
                });
            }
            $(document).ready(function() {
                $('img,#divLoadingGif').load(function() {
                    $.centraliza($('#gif,#divLoadingGif'));
                });
            });

            $(window).resize(function() {
                $.centraliza($('#gif,#divLoadingGif'));
            });
        } else {
            setTimeout(function() {
                if($('#divLoadingGif').length) {
                    if(config.scrollbarOnClose)
                        if ($('html').css('overflow') == 'hidden')
                            $('html').css('overflow', 'auto');
                    $('#divLoadingGif').fadeOut('fast',function(){
                        if(callback)
                            callback(true);
                    }).remove();
                }
            }, 100);
        }
        return this;
    };
})(jQuery);