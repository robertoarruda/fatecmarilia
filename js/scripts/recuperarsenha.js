$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function() {

    var backUrl = '/login/';
    var arqPost = '/recuperarsenha.php';

    $('#btnCancelar').click(function() {
        window.location.href = backUrl;
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