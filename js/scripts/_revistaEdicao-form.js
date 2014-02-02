$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/revista/edicoes/';
    var arqPost = '/_revistaEdicao-form.php';
    
    $('#btnCancelar').click(function(){
        $.showMsg({
            msg: 'Deseja realmente cancelar as alterações?',
            tipo: 'confirm'
        }, function(r){
            if (r)
                window.location.href = backUrl;
        });
    });
    var hoje = new Date();
    $('form').validate({
        rules:{
            volume:{
                required: true,
                number: true,
                min: 1
            },
            numero: {
                required: true,
                number: true,
                min: 1
            },
            mes: {
                required: true
            },
            ano: {
                required: true,
                number: true
            }
        },
        messages:{
            volume:{
                required: "Este campo é obrigatório.",
                number: "Este campo deve ser numérico.",
                min: "Este campo deve ser maior que zero."
            },
            numero: {
                required: "Este campo é obrigatório.",
                number: "Este campo deve ser numérico.",
                min: "Este campo deve ser maior que zero."
            },
            mes: {
                required: "Este campo é obrigatório."
            },
            ano: {
                required: "Este campo é obrigatório.",
                number: "Este campo deve ser numérico."
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