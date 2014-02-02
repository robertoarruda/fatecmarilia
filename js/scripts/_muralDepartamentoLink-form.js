$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/mural/' + $('#departamento_codigo').val() + '/';
    var arqPost = '/_muralDepartamentoLink-form.php';
    
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
            },
            linkUrl:{
                required: true,
                url: true
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
            },
            linkUrl:{
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