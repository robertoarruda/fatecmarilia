$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/albuns/';
    var arqPost = '/_album-form.php';
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
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
    
    $('form').validate({
        rules:{
            nomeArquivoNovo:{
                required: true
            }
        },
        messages:{
            nomeArquivoNovo:{
                required: "Este campo é obrigatório."
            }
        },
        submitHandler: function(form){
            $.loadingGif();
            var dados = $(form).serializeArray();

            $.post(arqPost,
            {
                dados: dados,
                acao: $('#btnSalvar').val()
            },
            function(res){
                $.loadingGif({on: false});
                $('body').append(res);
            });
            return false;
        }
    });
});