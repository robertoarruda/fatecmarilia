$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function() {
    
    var agendas_codigo = $('#agendas_codigo').val();
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/agendas/l/' + agendas_codigo + '/';
    var arqPost = '/_agendamentoLivre-form.php';

    $('#btnCancelar').click(function() {
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    
    if (window.navigator.userAgent.indexOf('Chrome') < 0)
        $("#data").mask("99/99/9999",{placeholder: ' ' });

    $('form').validate({
        rules: {
            data: {
                required: true,
                date: true
            },
            horarioInicial: {
                required: true
            },
            horarioFinal: {
                required: true
            }
        },
        messages: {
            data: {
                required: "Este campo é obrigatório.",
                date: "Este campo deve ser uma data válida (Ex: 00/00/0000).",
                min: "Este campo deve ser maior que " + $('#data').attr('min-data') + "."
            },
            horarioInicial: {
                required: "Este campo é obrigatório."
            },
            horarioFinal: {
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