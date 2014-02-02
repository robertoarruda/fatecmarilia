(function($){
    $.getScript('/js/plugins/jquery.centraliza.js');
    $.showMsg = function(settings, callback){
        var config = {
            msg: '',
            titulo: '',
            tipo: 'message',
            btnClose: '/imagens/layout/estrutura/png/fechar.btn.png'
        };
        if (settings){
            $.extend(config, settings);
        }
        var msg = config.msg;
        var title = config.titulo;
        var scrollbar = $('html').css('overflow');

        if(!$('#showMsg').length){
            var style =
            '<style type="text/css" media="all">'+
            'div#showMsg {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'position: fixed !important;'+
            'background-color: rgba(0,0,0,0.9) !important;'+
            'left: 0px !important;'+
            'top: 0px !important;'+
            'width: 100% !important;'+
            'height: 100% !important;'+
            'z-index: 1000 !important;'+
            '}'+
            'div#showMsg div#showMsgDialog {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'position: absolute !important;'+
            'background: #EEE !important;'+
            'border: rgb(38,77,155) 4px solid !important;'+
            'width: auto !important;'+
            'height: auto !important;'+
            'max-width: 500px !important;'+
            'min-width: 200px !important;'+
            'word-wrap: break-word !important;'+
            '}'+
            'div#showMsg div#showMsgpanelTitle {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'font-family: \'Muli\', sans-serif !important;'+
            'color: #FFF !important;'+
            'font-size: 15px !important;'+
            'font-weight: bolder !important;'+
            'min-width: 100% !important;'+
            'width: 100% !important;'+
            'alignment-baseline: central !important;'+
            'text-align: left !important;'+
            'background-color: rgb(51,102,204) !important;'+
            'padding-bottom: 4px !important;'+
            'padding-top: 6px !important;'+
            '}'+
            'div#showMsg div#showMsgpanelTitle img {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'float: right !important;'+
            'margin-right: 6px !important;'+
            'cursor: pointer !important;'+
            '}'+
            'div#showMsg div#showMsgpanelMsg {'+
            'margin: 0px !important;'+
            'padding: 20px !important;'+
            '}'+
            'div#showMsg div#showMsgpanelMsg p.dialog {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'font-family: \'Muli\', sans-serif !important;'+
            'color: #000 !important;'+
            'font-size: 14px !important;'+
            'line-height: 20px !important;'+
            '}'+
            'div#showMsg div#showMsgpanelButtons {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'alignment-baseline: central !important;'+
            'text-align: right !important;'+
            'min-width: 100% !important;'+
            'width: 100% !important;'+
            'padding: 5px !important;'+
            '}'+
            'div#showMsg div#showMsgpanelButtons input.button {'+
            'margin: 0px !important;'+
            'padding: 0px !important;'+
            'float: right !important;'+
            'margin-bottom: 5px !important;'+
            'margin-right: 10px !important;'+
            'display: block !important;'+
            'background-color: rgb(51,102,204) !important;'+
            'width: 100px !important;'+
            'height: 45px !important;'+
            '-moz-border-radius: 11px !important;'+
            '-webkit-border-radius: 11px !important;'+
            'border-radius: 11px !important;'+
            'cursor: pointer !important;'+
            'padding-bottom: 2px !important;'+
            'font-family: \'Anton\', sans-serif !important;'+
            'font-size: 20px !important;'+
            'color: rgb(255,255,255) !important;'+
            'text-align: center !important;'+
            '}'+
            '</style>';
            if(config.tipo == 'message'){
                if (!title)
                    title = 'Aviso';
                $('<div id="showMsg">')
                .hide()
                .html(
                    style+
                    '<div id=\'showMsgDialog\'>'+
                    '<div id=\'showMsgpanelTitle\'>'+
                    ' '+title+
                    '<img src="'+config.btnClose+'" />'+
                    '</div>'+
                    '<div id=\'showMsgpanelMsg\'>'+
                    '<p class="dialog">'+msg+'</p>'+
                    '</div>'+
                    '<div id=\'showMsgpanelButtons\'>'+
                    '<input id="btnOKsm" name="btnOKsm" value="OK" type="button" class="button"> '+
                    '</div>'+
                    '</div>'
                    )
                .appendTo('body')
                .fadeIn('fast', function(){
                    $('html').css('overflow', 'hidden');
                });
                $('#btnOKsm').focus();
            }
            else if (config.tipo == 'confirm') {
                if (!title)
                    title = 'Confirmação';
                $('<div id="showMsg">')
                .hide()
                .html(
                    style+
                    '<div id=\'showMsgDialog\'>'+
                    '<div id=\'showMsgpanelTitle\'>'+
                    ' '+title+
                    '<img src="'+config.btnClose+'">'+
                    '</div>'+
                    '<div id=\'showMsgpanelMsg\'>'+
                    '<p class="dialog">'+msg+'</p>'+
                    '</div>'+
                    '<div id=\'showMsgpanelButtons\'>'+
                    '<input id="btnOKsm" name="btnOKsm" value="Sim" type="button" class="button" tabindex="0"> '+
                    '<input id="btnNosm" name="btnNosm" value="Não" type="button" class="button" tabindex="0"> '+
                    '</div>'+
                    '</div>'
                    )
                .appendTo('body')
                .fadeIn('fast', function(){
                    $('html').css('overflow', 'hidden');
                });
                $('#btnYessm').focus();
            }
            $(document).ready(function(){
                var t = setTimeout(
                    function(){
                        if ($('#showMsgDialog').length) 
                            $.centraliza($('#showMsgDialog'));
                        else
                            t;
                    }, 10
                );
                $('#btnOKsm').click(function(){
                    if (scrollbar != 'hidden')
                        $('html').css('overflow', 'auto');
                    $('#showMsg').fadeOut('fast',function(){
                        if(callback)
                            callback(true);
                    }).remove();
                });
                $('#showMsgpanelTitle img').click(function(){
                    if($('#btnNosm').length)
                        $('#btnNosm').trigger('click');
                    else
                        $('#btnOKsm').trigger('click');
                });
                $('#btnNosm').click(function(){
                    if (scrollbar != 'hidden')
                        $('html').css('overflow', 'auto');
                    $('#showMsg').fadeOut('fast',function(){
                        if(callback)
                            callback(false);
                    }).remove();
                });
            });

            $(window).resize(function() {
                $.centraliza($('#showMsgDialog'));
            });
        }
    }
})(jQuery);