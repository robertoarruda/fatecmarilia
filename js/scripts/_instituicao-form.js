$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');

$(function() {
  new dgCidadesEstados({
    estado: $('#estado').get(0),
    cidade: $('#cidade').get(0),
    change: true
  });
});

$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/';
    var arqPost = '/_instituicao-form.php';
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    $("#cep").mask("99999-999",{placeholder: ' ' });
    $("#telefone").mask("(99) 9999-9999",{placeholder: ' ' });
    $("#fax").mask("(99) 9999-9999",{placeholder: ' ' });
    
    $('form').validate({
        rules:{
            nome:{
                required: true,
                minlength: 3
            },
            nomeFantasia: {
                required: true
            },
            imagem: {
                required: true
            },
            descricao:{
                required: true
            },
            endereco:{
                required: true
            },
            cep:{
                required: true
            },
            cidade:{
                required: true
            },
            estado:{
                required: true
            },
            telefone:{
                required: true
            },
            email:{
                required: true,
                email: true
            },
            emailSuporte:{
                required: true,
                email: true
            }
        },
        messages:{
            nome:{
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 3 caracteres."
            },
            nomeFantasia: {
                required: "Este campo é obrigatório."
            },
            imagem: {
                required: "Este campo é obrigatório."
            },
            descricao:{
                required: "Este campo é obrigatório."
            },
            endereco:{
                required: "Este campo é obrigatório."
            },
            cep:{
                required: "Este campo é obrigatório."
            },
            cidade:{
                required: "Este campo é obrigatório."
            },
            estado:{
                required: "Este campo é obrigatório."
            },
            telefone:{
                required: "Este campo é obrigatório."
            },
            email:{
                required: "Este campo é obrigatório.",
                email: "Este campo deve ser um email válido."
            },
            emailSuporte:{
                required: "Este campo é obrigatório.",
                email: "Este campo deve ser um email válido."
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