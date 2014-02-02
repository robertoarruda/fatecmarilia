$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/revista/';
    var arqPost = '/_revista-form.php';
    
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
            decricao:{
                required: true
            },
            equipeEditorial: {
                required: true
            },
            comiteCientifico: {
                required: true
            },
            equipeDiagramacaoWebDesigner: {
                required: true
            }
        },
        messages:{
            decricao:{
                required: "Este campo é obrigatório."
            },
            equipeEditorial: {
                required: "Este campo é obrigatório."
            },
            comiteCientifico: {
                required: "Este campo é obrigatório."
            },
            equipeDiagramacaoWebDesigner: {
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