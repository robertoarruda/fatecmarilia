$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/parceiros/';
    var arqPost = '/_parceiros.php';
    
    $('a.excluir').click(function(){
        var dados = $(this).attr('data-codigo');
        $.showMsg({
            msg: 'Deseja realmente excluir?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.loadingGif();
                $.post(arqPost,
                {
                    nomeArquivo: dados,
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
        container: $('.albumView'),
        effect: 'fadeIn'
    });
});