$.getScript('/js/plugins/jquery.viewImage.js');
$(document).ready(function(){
    $('ul.albumView li img').click(function(){
        $.viewImage({
            img: $(this).attr('data-src'),
            titulo: $(this).attr('title'),
            width: $(this).attr('data-width'),
            height: $(this).attr('data-height')
        });
        return false;
    });
    
    $('img.lazy').lazyload({
        effect : 'fadeIn'
    });
});