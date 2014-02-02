$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/parceiros/';
    var arqPost = '/_parceiro-form.php';
    
    $('#btnSalvar').click(function(){
        if ($(this).val() == 'Cadastrar') {
            if ($('#file_upload-queue').html()) {
                if ($('form').valid())
                    $('#file_upload').uploadify('upload','*');
            } else {
                $.showMsg({
                    msg: 'Selecione uma imagem.',
                    titulo: 'Erro'
                });
            }
        } else {
            if ($('#file_upload-queue').html()) {
                if ($('form').valid())
                   $('#file_upload').uploadify('upload','*');
            } else {
                $('form').submit();
            }
        }
    }); 
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    $('form').validate({
        rules:{
            nomeArquivoNovo:{
                required: true,
                url: true
            }
        },
        messages:{
            nomeArquivoNovo:{
                required: "Este campo é obrigatório.",
                url: "Este campo deve ser uma URL válida (Ex: http://www.google.com)."
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