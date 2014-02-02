$.getScript('/js/plugins/jquery.centraliza.js');
$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');

function listView(dir, arqSel, tipo, delBtn){
    if(!arqSel)
        arqSel = '';
    if(!delBtn)
        delBtn = 0;
    if(!$('#imagesManager').length){
        $.loadingGif();
        $('<div id="imagesManager"></div>')
        .appendTo('body')
        .hide();
        $('<div id="imagesManagerDialog"></div>')
        .appendTo('#imagesManager')
        .load('/plugins/imagesManager/list.php?s='+arqSel+'&d='+dir+'&tipo='+tipo+'&delbtn='+delBtn, function(){
            $.centraliza($('#imagesManagerDialog'), function(){
                $.loadingGif({
                    on: false,
                    scrollbarOnClose: false
                });
                $('#imagesManager').fadeIn('fast');
                $('img.lazyIM').lazyload({
                    container: $('.listImages').scrollTop(1),
                    effect: 'fadeIn'
                });
                $('.listImages').scrollTop(0);
            });
        });
    }
}

function jcropView(dir, arq, tipo){
    arq = encodeURIComponent(arq);
    $.loadingGif();
    $('<div id="imagesManager"></div>')
    .appendTo('body')
    .hide();
    $('<div id="imagesManagerDialog"></div>')
    .appendTo('#imagesManager')
    .load('/plugins/imagesManager/resize.php?arq='+arq+'&d='+dir+'&tipo='+tipo, function(){
        $.centraliza($('#imagesManagerDialog'), function(){
            $.loadingGif({
                on: false,
                scrollbarOnClose: false
            });
            $('#imagesManager').fadeIn('fast');
        });
    });
}

$(document).ready(function(){
    $(':text.imageManager').click(function(){
        $(':button[imageManager=true]').trigger('click');
    });
    
    $(':button[imageManager=true]').click(function(){
        var arqSel = encodeURIComponent($(':text.imageManager').val());
        var dir = $(this).attr('imageManager-dir');
        var tipo = $(this).attr('imageManager-tipo');
        var delBtn = $(this).attr('imageManager-delbtn');
        dir = encodeURIComponent(dir);
        listView(dir, arqSel, tipo, delBtn);
    });

    $(window).resize(function(){
        $.centraliza($('#imagesManagerDialog'));
    });

    $('img','ul.listImages li').click(function(){
        $('img','ul.listImages li')
        .removeClass('clicked')
        $(this).addClass('clicked');
        $('#nomeImagemSel').val($(this).attr('data-title'));
    });
    
    $('a.delBtnIM').click(function(){
        var file = $(this).attr('data-file');
        $.showMsg({
            msg: 'Deseja realmente excluir?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.post('/plugins/imagesManager/del.php',
                {
                    file: file,
                    acao: 'excluir'
                },
                function(res){
                    $('body').append(res);
                });
            }
        });
    });
    
    $('#btnAddImagem').click(function(){
        $('iframe').contents().find('#arquivoIM').trigger('click');
    });
    
    $('#btnSalvarImagem').click(function(){
        if ($('#nomeImagemSel').val() != 'undefined') {
            $(':text.imageManager').val($('#nomeImagemSel').val());
            $('#btnCancelImagem').trigger('click');
        } else {
            $.showMsg({
                msg: 'Nenhuma imagem selecionada.'
            }, function(){
                $('html').css('overflow', 'hidden');
            });
        }
    });
    $('#btnCancelImagem').click(function(){
        $.loadingGif({
            on: false,
            scrollbarOnClose: false
        });
        $('html').css('overflow', 'auto');
        $('#imagesManager')
        .fadeOut('fast')
        .remove();
    });
});