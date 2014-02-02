$.getScript('/js/plugins/jquery.showMsg.js');
$(document).ready(function(){
    $('article.boxLogin').mouseover(function(){
        $(this).css('opacity','1');
        $(this).css('-moz-opacity','1');
        $(this).css('-ms-filter','alpha(opacity=100)');
        $(this).css('filter','alpha(opacity=100)');
    });
    
    $('article.boxLogin').mouseout(function(){
        $('article.boxLogin').each(function(){
            if(!$('form input',this).is(':focus')) {
                $(this).css('borderColor','#FFF');
                $(this).css('opacity','0.5');
                $(this).css('-moz-opacity','0.5');
                $(this).css('-ms-filter','alpha(opacity=50)');
                $(this).css('filter','alpha(opacity=50)');
            } else
                $(this).css('borderColor','#4F79D2');
        });
    });
    
    $('article.boxLogin form input').focusin(function(){
        $('article.boxLogin').trigger('mouseout');
        $(this).closest('article.boxLogin').css('opacity','1');
        $(this).closest('article.boxLogin').css('-moz-opacity','1');
        $(this).closest('article.boxLogin').css('-ms-filter','alpha(opacity=100)');
        $(this).closest('article.boxLogin').css('filter','alpha(opacity=100)');
    });
    
    $('a.solicite').click(function(){
        $.showMsg({
            msg: 'Solicite seu cadastro junto ao Departamento de Informática da unidade.',
            titulo: 'Mensagem'
        });
    });
});