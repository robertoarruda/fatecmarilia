$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/departamentos/';
    var arqPost = '/_departamento-form.php';
    
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
            mural: {
                required: true
            },
            oculto: {
                required: true
            },
            instituicao_codigo: {
                required: true
            }
        },
        messages:{
            nome:{
                required: "Este campo é obrigatório."
            },
            mural: {
                required: "Este campo é obrigatório."
            },
            oculto: {
                required: "Este campo é obrigatório."
            },
            instituicao_codigo: {
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