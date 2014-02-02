$(document).ready(function() {
    $.slideShow('#destaque', '#slideSeletor', {
        delay: ($('#destaque').attr('qtdslides') > 1) ? 8000 : 99999999999,
        fadeSpeed: 500,
        directionSlide: 'bottom2top',
        directionMenu: 'bottom2top'
    });
    
    $.marquee('ul#boxParceiros', {
        delay: 5000,
        fadeSpeed: 500,
        minLi: 8,
        directionMarquee: 'right2left'
    });
    
    $('img.lazy').lazyload({
        effect: 'fadeIn'
    });
});