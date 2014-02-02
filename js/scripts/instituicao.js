$.getScript('/js/plugins/facebookSocialPlugins.js');
$.getScript('/js/plugins/twitterButtons.js');
$.getScript('/js/plugins/jquery.viewImage.js');
$(document).ready(function(){
    $('img.imageInstituicao').click(function(){
        $.viewImage({
            img: $(this).attr('data-src'),
            titulo: 'Fatec Marília',
            width: $(this).attr('data-width'),
            height: $(this).attr('data-height')
        });
        return false;
    });
});