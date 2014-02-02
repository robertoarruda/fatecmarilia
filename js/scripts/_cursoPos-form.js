$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/cursos/pos-graduacao/';
    var arqPost = '/_cursoPos-form.php';
    
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
            tipo:{
                required: true
            },
            nome:{
                required: true
            },
            nomeCompleto: {
                required: true
            },
            imagem: {
                required: true
            },
            objetivo:{
                required: true
            },
            publicoAlvo:{
                required: true
            },
            quadroDeDisciplinas:{
                required: true
            },
            duracao:{
                required: true
            },
            instituicao_codigo:{
                required: true
            }
        },
        messages:{
            tipo:{
                required: "Este campo é obrigatório."
            },
            nome:{
                required: "Este campo é obrigatório."
            },
            nomeCompleto: {
                required: "Este campo é obrigatório."
            },
            imagem: {
                required: "Este campo é obrigatório."
            },
            objetivo:{
                required: "Este campo é obrigatório."
            },
            publicoAlvo:{
                required: "Este campo é obrigatório."
            },
            quadroDeDisciplinas:{
                required: "Este campo é obrigatório."
            },
            duracao:{
                required: "Este campo é obrigatório."
            },
            instituicao_codigo:{
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