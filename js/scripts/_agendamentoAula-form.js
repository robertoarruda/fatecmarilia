$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function() {

    $('#manha').hide();
    $('#noite').hide();

    var agendas_codigo = $('#agendas_codigo').val();
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/agendas/a/' + agendas_codigo + '/';
    var arqPost = '/_agendamentoAula-form.php';

    $('#btnCancelar').click(function() {
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r) {
            if (r)
                window.location.href = backUrl;
        });
    });

    if (window.navigator.userAgent.indexOf('Chrome') < 0)
        $("#data").mask("99/99/9999", {placeholder: ' '});

    $('form').validate({
        rules: {
            data: {
                required: true,
                date: true,
                min: false
            },
            termo: {
                required: true
            },
            turno: {
                required: true
            },
            aula: {
                required: true
            }
        },
        messages: {
            data: {
                required: "Este campo é obrigatório.",
                date: "Este campo deve ser uma data válida (Ex: 00/00/0000)."
            },
            termo: {
                required: "Este campo é obrigatório."
            },
            turno: {
                required: "Este campo é obrigatório."
            },
            aula: {
                required: "Este campo é obrigatório."
            }
        },
        submitHandler: function(form) {
            $.loadingGif();
            var dados = $(form).serializeArray();
            var m1 = $('#m1').is(':checked') ? '1' : '0';
            var m2 = $('#m2').is(':checked') ? '1' : '0';
            var m3 = $('#m3').is(':checked') ? '1' : '0';
            var m4 = $('#m4').is(':checked') ? '1' : '0';
            var m5 = $('#m5').is(':checked') ? '1' : '0';
            var n1 = $('#n1').is(':checked') ? '1' : '0';
            var n2 = $('#n2').is(':checked') ? '1' : '0';
            var n3 = $('#n3').is(':checked') ? '1' : '0';
            var n4 = $('#n4').is(':checked') ? '1' : '0';
            var n5 = $('#n5').is(':checked') ? '1' : '0';
            
            $.post(arqPost,
                    {
                        dados: dados,
                        m1: m1,
                        m2: m2,
                        m3: m3,
                        m4: m4,
                        m5: m5,
                        n1: n1,
                        n2: n2,
                        n3: n3,
                        n4: n4,
                        n5: n5,
                        acao: $('#btnSalvar').val()
                    },
            function(res) {
                $.loadingGif({on: false});
                $('body').append(res);
            });
            return false;
        }
    });

    $('#data').change(function() {
        $.desabilitaHorarios();
    });

    $('#turno').change(function() {
        $.desabilitaHorarios();
    });

    (function($){
        $.getScript('/js/plugins/jquery.loadingGif.js');
        $.desabilitaHorarios = function(callback){
            var data = $('#data').val();
            var turno = $('#turno').val();
            if ((data) && (turno)) {
                $.loadingGif();
                $.post(arqPost,
                        {
                            agendas_codigo: $('#agendas_codigo').val(),
                            data: data,
                            turno: turno,
                            acao: 'desabilitahorarios'
                        },
                function(res) {
                    $(':checkbox').attr('checked', false).removeAttr('disabled');
                    if (turno == '1') {
                        if (res['0'] != '0')
                            $('#m1').attr('disabled', 'disabled');
                        if (res['1'] != '0')
                            $('#m2').attr('disabled', 'disabled');
                        if (res['2'] != '0')
                            $('#m3').attr('disabled', 'disabled');
                        if (res['3'] != '0')
                            $('#m4').attr('disabled', 'disabled');
                        if (res['4'] != '0')
                            $('#m5').attr('disabled', 'disabled');
                        $('#manha').show();
                        $('#noite').hide();
                    } else if (turno == '3') {
                        if (res['0'] != '0')
                            $('#n1').attr('disabled', 'disabled');
                        if (res['1'] != '0')
                            $('#n2').attr('disabled', 'disabled');
                        if (res['2'] != '0')
                            $('#n3').attr('disabled', 'disabled');
                        if (res['3'] != '0')
                            $('#n4').attr('disabled', 'disabled');
                        if (res['4'] != '0')
                            $('#n5').attr('disabled', 'disabled');
                        $('#manha').hide();
                        $('#noite').show();
                    }
                    $.loadingGif({on: false});
                });
                if (callback)
                    callback(true);
            } else {
                $('#manha').hide();
                $('#noite').hide();
            }
        }
    })(jQuery);
});