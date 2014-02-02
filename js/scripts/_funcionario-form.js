$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function() {

    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/funcionarios/';
    var arqPost = '/_funcionario-form.php';

    $('#btnCancelar').click(function() {
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    $("#cpf").mask("***.***.***-**",{placeholder: ' ' });

    $('form').validate({
        rules: {
            cpf: {
                required: true,
                cpf: 'both' // valid - format
            },
            email: {
                required: true,
                email: true
            },
            instituicao_codigo: {
                required: true
            },
            tipo: {
                required: true
            }
        },
        messages: {
            cpf: {
                required: "Este campo é obrigatório.",
                cpf: "Este campo deve ser um CPF válido (Ex: 000.000.000-00)."
            },
            email: {
                required: "Este campo é obrigatório.",
                email: "Este campo deve ser um email válido."
            },
            instituicao_codigo: {
                required: "Este campo é obrigatório."
            },
            tipo: {
                required: "Este campo é obrigatório."
            }
        },
        submitHandler: function(form) {
            $.loadingGif();
            var dados = $(form).serializeArray();

            $.post(arqPost,
                    {
                        dados: dados,
                        acao: $('#btnSalvar').val()
                    },
            function(res) {
                $.loadingGif({on: false});
                $('body').append(res);
            });
            return false;
        }
    });
});