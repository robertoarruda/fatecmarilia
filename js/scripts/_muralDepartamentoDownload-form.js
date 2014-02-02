$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/mural/' + $('#departamento_codigo').val() + '/';
    var arqPost = '/_muralDepartamentoDownload-form.php';
    
    $('#btnSalvar').click(function(){
        if ($(this).val() == 'Cadastrar') {
            if ($('#file_upload-queue').html()) {
                if ($('form').valid())
                    $('#file_upload').uploadify('upload','*');
            } else {
                $.showMsg({
                    msg: 'Selecione um arquivo.',
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
            titulo:{
                required: true
            },
            imagem:{
                required: true
            },
            descricao:{
                required: true
            }
        },
        messages:{
            titulo:{
                required: "Este campo é obrigatório."
            },
            imagem:{
                required: "Este campo é obrigatório."
            },
            descricao:{
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