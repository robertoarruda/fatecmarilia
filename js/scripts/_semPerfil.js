$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    var arqPost = '/_semPerfil.php';
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
});