$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/disciplinas/graduacao/';
    var arqPost = '/_disciplinaGraduacao-form.php';
    
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
            nome:{
                required: true
            },
            cargaHoraria: {
                required: true,
                number: true,
                min: 1
            },
            cursos_codigo: {
                required: true
            }
        },
        messages:{
            nome:{
                required: "Este campo é obrigatório."
            },
            cargaHoraria: {
                required: "Este campo é obrigatório.",
                number: "Este campo deve ser numérico.",
                min: "Este campo deve ser maior que zero."
            },
            cursos_codigo: {
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