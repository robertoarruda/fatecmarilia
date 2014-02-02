$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    var arqPost = '/_funcionario-form.php';
    $('a[title="Desativar"], a[title="Ativar"]').click(function(){
        var dados = $(this).attr('data-codigo');
        var tipo = $(this).attr('title').toLowerCase();
        $.showMsg({
            msg: 'Deseja realmente ' + tipo + '?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.loadingGif();
                $.post(arqPost,
                {
                    dados: dados,
                    acao: tipo
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