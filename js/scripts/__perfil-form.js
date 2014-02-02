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
    
    var backUrl = '/aluno/';
    var arqPost = '/__perfil-form.php';
    
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
    $("#celular").mask("(99) 9999-9999",{placeholder: ' ' });
    $("#telefoneRecado").mask("(99) 9999-9999",{placeholder: ' ' });
    
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
            estadoCivil: {
                required: true
            },
            dataNascimento:{
                required: true,
                date: true
            },
            endereco:{
                required: true
            },
            bairro:{
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
            celular:{
                required: true
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
            estadoCivil: {
                required: "Este campo é obrigatório."
            },
            dataNascimento:{
                required: "Este campo é obrigatório.",
                date: "Este campo deve ser uma data válida (Ex: 00/00/000)."
            },
            endereco:{
                required: "Este campo é obrigatório."
            },
            bairro: {
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
            celular:{
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