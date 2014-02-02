(function($){
    $.slideShow= function(selector, selectorMenu, settings){
        var config= {
            'delay': 2000,
            'fadeSpeed': 500,
            'directionSlide': 'bottom2top',
            'directionMenu': 'top2bottom'
        };
        if (settings){
            $.extend(config, settings);
        }

        var delay= config.delay<500?500:config.delay;
        var fadeSpeed= config.fadeSpeed<100?100:config.fadeSpeed;

        var obj= $(selector);
        var article= obj.children('li').children('article');
        var count= article.length;

        var objMenu= $(selectorMenu);

        if (count){
            
            objMenu.parent('ul').children('li').children('figure').children('img').click(function() {
                clickSlideMenu(this, selector, selectorMenu);
            });
            
            article= article.eq(0);
            var height= parseInt(article.css('height').replace('px',''));
            var width= parseInt(article.css('width').replace('px',''));

            var mheight= parseInt($(objMenu).prev('li').css('height').replace('px',''));
            var mwidth= parseInt($(objMenu).prev('li').css('width').replace('px',''));

            switch(config.directionSlide){
                case 'top2bottom':
                    obj.css({
                    top: -(height*(count-1))+'px'
                    });
                break;
                case 'bottom2top':
                    obj.css({
                    top:'0px'
                });
                break;
                case 'right2left':
                    obj.css({
                    left:'0px'
                });
                break;
                case 'left2right':
                    obj.css({
                    left: -(width*(count-1))+'px'
                    });
                break;
            }

            switch(config.directionMenu){
                case 'top2bottom':
                    objMenu.css({
                    top:'0px'
                });
                break;
                case 'bottom2top':
                    objMenu.css({
                    top: ((mheight)*(count-1))+'px'
                    });
                break;
                case 'right2left':
                    objMenu.css({
                    left: ((mwidth+1)*(count-1))+'px'
                    });
                break;
                case 'left2right':
                    objMenu.css({
                    left:'0px'
                });
                break;
            }

            obj.css({
                visibility:'visible'
            });
            objMenu.css({
                visibility:'visible'
            });

            setTimeout(function(){
                moveSlide();
            }, delay);

            //==== Rolling do Slide ====================================================/
            function moveSlide(){
                if(document.hasFocus()) {
                    switch(config.directionSlide){
                        case 'bottom2top':
                            var pos= parseInt(obj.css('top').replace('px',''));
                            var newpos= (pos - height);
                            if (newpos <= -(count * height)) {
                                newpos= 0;
                                obj.animate({
                                    top:newpos+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos-10+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos+30+'px'
                                    },fadeSpeed)));
                            } else
                                obj.animate({
                                    top:newpos+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos+10+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos-30+'px'
                                    },fadeSpeed)));
                            break;
                        case 'top2bottom':
                            var pos= parseInt(obj.css('top').replace('px',''));
                            var newpos= (pos + height);
                            if (newpos > 0) {
                                newpos= -(height*(count-1));
                                obj.animate({
                                    top:newpos+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos+10+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos-30+'px'
                                    },fadeSpeed)));
                            } else
                                obj.animate({
                                    top:newpos+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos-10+'px'
                                    },'fast',null,obj.animate({
                                    top:newpos+30+'px'
                                    },fadeSpeed)));
                            break;
                        case 'right2left':
                            var pos= parseInt(obj.css('left').replace('px',''));
                            var newpos= (pos - width);
                            if (newpos <= -(count * width)) {
                                newpos= 0;
                                obj.animate({
                                    left:newpos+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos-10+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos+30+'px'
                                    },fadeSpeed)));
                            } else
                                obj.animate({
                                    left:newpos+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos+10+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos-30+'px'
                                    },fadeSpeed)));
                            break;
                        case 'left2right':
                            var pos= parseInt(obj.css('left').replace('px',''));
                            var newpos= (pos +width);
                            if (newpos > 0) {
                                newpos= -(width*(count-1));
                                obj.animate({
                                    left:newpos+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos+10+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos-30+'px'
                                    },fadeSpeed)));
                            } else
                                obj.animate({
                                    left:newpos+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos-10+'px'
                                    },'fast',null,obj.animate({
                                    left:newpos+30+'px'
                                    },fadeSpeed)));
                            break;
                    }

                    //==== Rolling do Menu =====================================================/
                    switch(config.directionMenu){
                        case 'bottom2top':
                            var pos= parseInt(objMenu.css('top').replace('px',''));
                            var newpos= (pos - mheight);
                            if (newpos < 0) {
                                newpos= (mheight)*(count-1);
                                objMenu.animate({
                                    top:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos-3+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos+10+'px'
                                    },fadeSpeed)));
                            } else
                                objMenu.animate({
                                    top:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos+3+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos-10+'px'
                                    },fadeSpeed)));
                            break;
                        case 'top2bottom':
                            var pos= parseInt(objMenu.css('top').replace('px',''));
                            var newpos= (pos + (mheight+1));
                            if (newpos >= count * mheight) {
                                newpos= 0;
                                objMenu.animate({
                                    top:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos+3+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos-10+'px'
                                    },fadeSpeed)));
                            } else
                                objMenu.animate({
                                    top:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos-3+'px'
                                    },'fast',null,objMenu.animate({
                                    top:newpos+10+'px'
                                    },fadeSpeed)));
                            break;
                        case 'right2left':
                            var pos= parseInt(objMenu.css('left').replace('px',''));
                            var newpos= (pos - mwidth-1);
                            if (newpos < 0) {
                                newpos= (mwidth+1)*(count-1);
                                objMenu.animate({
                                    left:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos-3+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos+10+'px'
                                    },fadeSpeed)));
                            } else
                                objMenu.animate({
                                    left:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos+3+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos-10+'px'
                                    },fadeSpeed)));
                            break;
                        case 'left2right':
                            var pos= parseInt(objMenu.css('left').replace('px',''));
                            var newpos= (pos + (mwidth+1));
                            if (newpos >= count * mwidth) {
                                newpos= 0;
                                objMenu.animate({
                                    left:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos+3+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos-10+'px'
                                    },fadeSpeed)));
                            } else
                                objMenu.animate({
                                    left:newpos+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos-3+'px'
                                    },'fast',null,objMenu.animate({
                                    left:newpos+10+'px'
                                    },fadeSpeed)));
                            break;
                    }
                    
                    objMenu.parent('ul').children('li').css('marginLeft','0px');

                    setTimeout(function(){
                        setTimeout(function(){
                            moveSlide();
                        }, delay);
                    }, 50+fadeSpeed);
                } else
                    setTimeout(function(){
                        setTimeout(function(){
                            moveSlide();
                        }, delay);
                    }, 50+fadeSpeed);
            }

        }
        return this;
    };
})(jQuery);

function clickSlideMenu(sel,slide,seletor) {
    $(seletor).offset({
        top: $(sel).offset().top
        });
    var objSel= $('#slideSS'+$(sel).attr('id').replace('menuSS',''));
    var selPos= objSel.offset().top;
    var slidePos= parseInt($(slide).css('top').replace('px','').replace('-',''));
    var boxPos= 8+$(slide).parent('div').offset().top;
    var pos= slidePos+(selPos-boxPos);
    pos= (pos<0)?pos*-1:pos;
    $(slide).css('top',-pos);
}