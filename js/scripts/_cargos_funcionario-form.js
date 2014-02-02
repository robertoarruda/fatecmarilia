$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function() {

    var cpf = $('#cpf').val();
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/funcionarios/cargos/' + cpf + '/cargos.html';
    var arqPost = '/_cargos_funcionario-form.php';

    $('#btnCancelar').click(function() {
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });

    $('form').validate({
        rules: {
            departamentos_codigo: {
                required: true
            },
            cargos_codigo: {
                required: true
            }
        },
        messages: {
            departamentos_codigo: {
                required: "Este campo é obrigatório."
            },
            cargos_codigo: {
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

    $('#departamentos_codigo').change(function() {
        if ($(this).val()) {
            $('#cargos_codigo').attr('disabled', 'disabled');
            $('#cargos_codigo').html('<option value="">Carregando...</opton>');
            $.post(arqPost,
            {
                departamento: true,
                departamento_codigo: $(this).val()
            },
            function(res) {
                $('#cargos_codigo').removeAttr('disabled');
                $('#cargos_codigo').html(res);
            });
        } else {
            $('#cargos_codigo').attr('disabled', 'disabled');
            $('#cargos_codigo').html('<option value="">Selecione um departamento</option>');
        }
    });
});