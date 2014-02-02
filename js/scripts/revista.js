$.getScript('/js/plugins/jquery.viewImage.js');
$(document).ready(function(){
    var menu = $('#revistaMenu2').html();
    $('#revistaMenu2').remove();
    $('#revistaMenu').html(menu);
    
    $('#revista').booklet({
        width:  1000,
        height: 707,
        pagePadding: 0,
        pageNumbers: false,
        closed: true,
        autoCenter: true,
        covers: true,
        keyboard: true,
        arrows: true,
        arrowsHide: true

    });
    
    $('ol#revistaMenu li').click(function(){
        $('#revista').booklet("gotopage", $(this).attr('data-pag'));
    });
    
    $('img[title="Duplo clique para ampliar"]').dblclick(function(){
        $.viewImage({
            img: $(this).attr('data-src'),
            width: $(this).attr('data-width'),
            height: $(this).attr('data-height'),
            tipo: 'proporcional'
        });
        return false;
    });
    
    $('img.lazy').lazyload({
        effect : 'fadeIn'
    });

});