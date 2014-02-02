(function($) {
    $.getScript('/js/plugins/jquery.centraliza.js');
    $.getScript('/js/plugins/jquery.loadingGif.js');
    $.getScript('/js/functions/base64.js');

    $.viewImage = function(settings, callback) {
        var config = {
            img: '',
            titulo: '',
            width: '',
            height: '',
            btnClose: '/imagens/layout/estrutura/png/fechar.btn.png',
            tipo: 'preenchetudo'
        };
        if (settings) {
            $.extend(config, settings);
        }
        var img = config.img.replace(/^\/+/,'');;
        var title = config.titulo;
        var width = config.width;
        var height = config.height;
        var tipo = config.tipo;
        var scrollbar = $('html').css('overflow');

        if (!$('#viewImage').length) {
            var rWidth = $(window).width() / 1.3;
            var rHeight = $(window).height() / 1.3;
            var w = 0;
            var h = 0;
            var css = '';
            switch (tipo) {
                case 'preenchetudo':
                    var ratio_orig = width / height;
                    if (rWidth / rHeight > ratio_orig) {
                        w = rHeight * ratio_orig;
                        h = rHeight;
                    } else {
                        w = rWidth;
                        h = rWidth / ratio_orig;
                    }
                    break;
                case 'proporcional':
                    var fator = 0;
                    if ((width / rWidth) < (height / rHeight)) {
                        fator = width / rWidth;
                    } else {
                        fator = width / rHeight;
                    }
                    w = width / fator;
                    h = height / fator;
                    css = 'overflow: scroll; padding: 10px;';
                    break;
            }

            if (!title)
                title = '';
            $('<div id="viewImage">')
                    .html(
                    '<style type="text/css" media="all">' +
                    'div#viewImage {' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'position: fixed !important;' +
                    'background-color: rgba(0,0,0,0.9) !important;' +
                    'left: 0px !important;' +
                    'top: 0px !important;' +
                    'width: 100% !important;' +
                    'height: 100% !important;' +
                    'z-index: 1000 !important;' +
                    css +
                    '}' +
                    'div#viewImage div#viewImageDialog {' +
                    'position: absolute !important;' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'width: auto !important;' +
                    'height: auto !important;' +
                    'word-wrap: break-word !important;' +
                    '}' +
                    'div#viewImage div#viewImageDialog div#viewImagepanelTitle {' +
                    'visibility: hidden !important;' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'font-family: \'Muli\', sans-serif !important;' +
                    'color: #FFF !important;' +
                    'font-size: 15px !important;' +
                    'font-weight: bolder !important;' +
                    'min-width: 100% !important;' +
                    'width: 100% !important;' +
                    'alignment-baseline: central !important;' +
                    'text-align: left !important;' +
                    'background-color: rgb(51,102,204) !important;' +
                    'padding-bottom: 2px !important;' +
                    'padding-top: 6px !important;' +
                    '}' +
                    'div#viewImage div#viewImageDialog div#viewImagepanelTitle img {' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'float: right !important;' +
                    'margin-right: 6px !important;' +
                    'cursor: pointer !important;' +
                    '}' +
                    'div#viewImage div#viewImageDialog img {' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'border: 0px !important;' +
                    'width: auto !important;' +
                    'height: auto !important;' +
                    '}' +
                    'div#viewImage div#viewImageDialog img#image {' +
                    'margin: 0px !important;' +
                    'padding: 0px !important;' +
                    'border: 0px !important;' +
                    'width: ' + w + 'px !important;' +
                    'height: ' + h + 'px !important;' +
                    '}' +
                    '</style>' +
                    '<div id="viewImageDialog">' +
                    '<div id="viewImagepanelTitle">' +
                    ' ' + title +
                    '<img src="' + config.btnClose + '">' +
                    '</div>' +
                    '<img id="image" src="/' + img + '" title="Dê um duplo clique para fechar">' +
                    '</div>'
                    )
                    .appendTo('body')
                    .hide();
            $('#viewImageDialog').hide();

            $(document).ready(function() {
                $.loadingGif();
                $('#viewImage').click(function(e) {
                    if (!$(e.target).closest('#viewImageDialog').length)
                        $('#viewImagepanelTitle img').trigger('click');
                });
                $('#viewImageDialog').dblclick(function() {
                        $('#viewImagepanelTitle img').trigger('click');
                });
                $('#image').load(function() {
                    $('#viewImage').fadeIn('fast', function() {
                        $.loadingGif({
                            on: false,
                            scrollbarOnClose: false
                        });
                    });
                    $.centraliza($('#viewImageDialog'));
                    $('#viewImageDialog').fadeIn('fast');
                });
                $('#viewImagepanelTitle img').click(function() {
                    if (scrollbar != 'hidden')
                        $('html').css('overflow', 'auto');
                    $('#viewImage').fadeOut('fast', function() {
                        if (callback)
                            callback(true);
                    }).remove();
                });
                $('#image').mouseover(function() {
                    $('#viewImageDialog')
                            .css('margin-top', '-1px')
                            .css('margin-left', '-1px');
                    $('#image').css('border', 'rgb(51,102,204) 1px solid');
                    $('#viewImagepanelTitle').css('visibility', 'visible');
                });
                $('#image').mouseout(function() {
                    $('#viewImageDialog')
                            .css('margin-top', '0')
                            .css('margin-left', '0');
                    $('#image').css('border', '0px');
                    $('#viewImagepanelTitle').css('visibility', 'hidden');
                });
                $('#viewImagepanelTitle').mouseover(function() {
                    $('#image').trigger('mouseover');
                });
                $('#viewImagepanelTitle').mouseout(function() {
                    $('#image').trigger('mouseout');
                });
            });

            $(window).resize(function() {
                $.centraliza($('#viewImageDialog'));
            });
        }
    }
})(jQuery);