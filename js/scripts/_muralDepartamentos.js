$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    $('a[title="Excluir"]').click(function(){
        var arqPost = '/_muralDepartamento' + $(this).attr('data-tipo') + '-form.php';
        var dados = $(this).attr('data-codigo');
        var departamento = $(this).attr('data-departamento');
        $.showMsg({
            msg: 'Deseja realmente excluir?',
            tipo: 'confirm'
        }, function(r){
            if (r) {
                $.loadingGif();
                $.post(arqPost,
                {
                    dados: dados,
                    departamento_codigo: departamento,
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