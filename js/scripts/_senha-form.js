$.getScript('/js/plugins/jquery.loadingGif.js');
$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    
    var tipoUrl = $('body').attr('data-tipo');
    var backUrl = '/' + tipoUrl + '/';
    var arqPost = '/_senha-form.php';
    
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
            senhaAtual:{
                required: true,
                minlength: 6
            },
            novaSenha: {
                required: true,
                minlength: 6
            },
            repetirNovaSenha:{
                equalTo: "#novaSenha",
                required: true,
                minlength: 6
            }
            
        },
        messages:{
            senhaAtual:{
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 6 caracteres."
            },
            novaSenha:{
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 6 caracteres."
            },
            repetirNovaSenha:{
                equalTo: 'As novas senhas não são iguais.',
                required: "Este campo é obrigatório.",
                minlength: "Este campo deve conter no mínimo 6 caracteres."
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