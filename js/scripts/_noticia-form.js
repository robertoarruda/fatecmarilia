$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/noticias/';
    var arqPost = '/_noticia-form.php';
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    $('a.album').click(function(){
        $.showMsg({
            msg: 'Deseja realmente sair sem salvar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = $('a.album').attr('data-url'); 
        });
    });
    
    $('form').validate({
        rules:{
            titulo:{
                required: true
            },
            resumo:{
                required: true
            },
            imagem:{
                required: true
            },
            conteudo:{
                required: true
            },
            linkUrl:{
                required: function() {
                    return ($('#linkTitulo').val()) ? true : false;
                },
                url: true
            }
            
        },
        messages:{
            titulo:{
                required: "Este campo é obrigatório."
            },
            resumo:{
                required: "Este campo é obrigatório."
            },
            imagem:{
                required: "Este campo é obrigatório."
            },
            conteudo:{
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