$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    var arqPost = '/_noticia-form.php';
    $('a[title="Ativar"]').click(function(){
        var dados = $(this).attr('data-codigo');
        $.showMsg({
            msg: 'Deseja realmente ativar?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.loadingGif();
                $.post(arqPost,
                {
                    dados: dados,
                    acao: 'ativar'
                },
                function(res){
                    $.loadingGif({on: false});
                    $('body').append(res);
                });
            }
        });
    });
    
    $('a[title="Excluir"]').click(function(){
        var dados = $(this).attr('data-codigo');
        $.showMsg({
            msg: 'Deseja realmente excluir?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.loadingGif();
                $.post(arqPost,
                {
                    dados: dados,
                    acao: 'excluir'
                },
                function(res){
                    $.loadingGif({on: false});
                    $('body').append(res);
                });
            }
        });
    });
    
    $('img.lazy').lazyload({
        effect : 'fadeIn'
    });
});