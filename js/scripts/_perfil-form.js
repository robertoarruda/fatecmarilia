$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/';
    var arqPost = '/_perfil-form.php';
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    if (window.navigator.userAgent.indexOf('Chrome') < 0)
        $("#dataNascimento").mask("99/99/9999",{placeholder: ' ' });
    
    $('form').validate({
        rules:{
            nome:{
                required: true,
                minlength: 3
            },
            sobrenome: {
                required: true,
                minlength: 3
            },
            sexo: {
                required: true
            },
            dataNascimento: {
                required: true,
                date: true
            },
            titulacao: {
                required: true
            },
            urlLattes: {
                url: true
            }
            
        },
        messages:{
            nome:{
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 3 caracteres."
            },
            sobrenome:{
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 3 caracteres."
            },
            sexo: {
                required: "Este campo é obrigatório."
            },
            dataNascimento: {
                required: "Este campo é obrigatório.",
                date: "Este campo deve ser uma data válida (Ex: 00/00/000)."
            },
            titulacao: {
                required: "Este campo é obrigatório."
            },
            urlLattes: {
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