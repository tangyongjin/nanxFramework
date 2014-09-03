window.addEvent('domready', function () {
    
    $ES('.spotToogleDisplay').each(function (item, index) {
        item.addEvents({
            'mouseleave': function () {
                this.fade('out');
                $ES('.topbtn a')[index].set('class', oriClass[index]);
            },
            'mouseenter': function () {
                //$ES('.topbtn a')[index].set('class',oriClass[index]+'_over'); 
            }
        });
    });

    //头部“结账”按钮赋予点击跳转连接
    
    window.addEvent('load', function () {
        //slidergoods区域自适用高度
        if ($('slidergoods')) {
            slidergoodsTrueHight = $E('#slidergoods .GoodsList').getSize().y;
            $('slidergoods').setStyle('height', slidergoodsTrueHight + 15);
        }
    });
});


(function ($j) { $j.fn.hoverIntent = function (f, g) { var cfg = { sensitivity: 7, interval: 100, timeout: 0 }; cfg = $j.extend(cfg, g ? { over: f, out: g} : f); var cX, cY, pX, pY; var track = function (ev) { cX = ev.pageX; cY = ev.pageY; }; var compare = function (ev, ob) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); if ((Math.abs(pX - cX) + Math.abs(pY - cY)) < cfg.sensitivity) { $j(ob).unbind("mousemove", track); ob.hoverIntent_s = 1; return cfg.over.apply(ob, [ev]); } else { pX = cX; pY = cY; ob.hoverIntent_t = setTimeout(function () { compare(ev, ob); }, cfg.interval); } }; var delay = function (ev, ob) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); ob.hoverIntent_s = 0; return cfg.out.apply(ob, [ev]); }; var handleHover = function (e) { var p = (e.type == "mouseover" ? e.fromElement : e.toElement) || e.relatedTarget; while (p && p != this) { try { p = p.parentNode; } catch (e) { p = this; } } if (p == this) { return false; } var ev = jQuery.extend({}, e); var ob = this; if (ob.hoverIntent_t) { ob.hoverIntent_t = clearTimeout(ob.hoverIntent_t); } if (e.type == "mouseover") { pX = ev.pageX; pY = ev.pageY; $j(ob).bind("mousemove", track); if (ob.hoverIntent_s != 1) { ob.hoverIntent_t = setTimeout(function () { compare(ev, ob); }, cfg.interval); } } else { $j(ob).unbind("mousemove", track); if (ob.hoverIntent_s == 1) { ob.hoverIntent_t = setTimeout(function () { delay(ev, ob); }, cfg.timeout); } } }; return this.mouseover(handleHover).mouseout(handleHover); }; })(jQuery);
	
$j(document).ready(function () {
    //minicart
    if ($j("#minicount a:first").length) {
        $j.ajax({ url: "cart-view.html", type: "post", data: { mini: 1, isAjax: 1 }, success: function (msg) {
            if (parseInt($j("span", msg).eq(1).text().replace('￥', '')) != 0) {
                $j("#minicount a:first").html($j("span", msg).eq(0).text());
                $j("#miniprice a:first").html($j("span", msg).eq(1).text());
            }
        }
        });
    }
    lazyload();
    //pagefade
    $j('.jfade_image').jfade();
    $j('.portfolio').jfade({
        start_opacity: "1",
        high_opacity: "0.8",
        low_opacity: "0.8",
        timing: "500"
    });
    $j('.buttonxx').jfade({
        start_opacity: "1",
        high_opacity: "1",
        low_opacity: ".4",
        timing: "500"
    });
    $j('.text').jfade({
        start_opacity: "1",
        high_opacity: "1",
        low_opacity: ".5",
        timing: "500"
    });
    $j('.links').jfade({
        start_opacity: ".9",
        high_opacity: "1",
        low_opacity: ".2",
        timing: "500"
    });
    function megaHoverOver() {
        $j(this).find(".sub").stop().fadeTo('fast', 1).show();

        //Calculate width of all ul's
        (function ($j) {
            jQuery.fn.calcSubWidth = function () {
                rowWidth = 0;
                //Calculate row
                $j(this).find("ul").each(function () {
                    rowWidth += $j(this).width();
                });
            };
        })(jQuery);

        if ($j(this).find(".row").length > 0) { //If row exists...
            var biggestRow = 0;
            //Calculate each row
            $j(this).find(".row").each(function () {
                $j(this).calcSubWidth();
                //Find biggest row
                if (rowWidth > biggestRow) {
                    biggestRow = rowWidth;
                }
            });
            //Set width
            $j(this).find(".sub").css({ 'width': biggestRow });
            $j(this).find(".row:last").css({ 'margin': '0' });

        } else { //If row does not exist...

            $j(this).calcSubWidth();
            //Set Width
            $j(this).find(".sub").css({ 'width': rowWidth });

        }
    }

    function megaHoverOut() {
        $j(this).find(".sub").stop().fadeTo('fast', 0, function () {
            $j(this).hide();
        });
    }


    var config = {
        sensitivity: 2, // number = sensitivity threshold (must be 1 or higher)    
        interval: 0, // number = milliseconds for onMouseOver polling interval    
        over: megaHoverOver, // function = onMouseOver callback (REQUIRED)    
        timeout: 0, // number = milliseconds delay before onMouseOut    
        out: megaHoverOut // function = onMouseOut callback (REQUIRED)    
    };

    $j("ul#topnav li .sub").css({ 'opacity': '0' });
    $j("ul#topnav li").hoverIntent(config);
    void function () {
        var sharebtn = $$('.shareth a');
        if (sharebtn.length) {
            sharebtn.each(function (obj) {
                var sharename = obj.getParent('span').get('class');
                var url = window.location;
                var title = $E('title').get('text');
                var href = '';
                if (sharename == 'sinashare') {
                    href = 'http://v.t.sina.com.cn/share/share.php?';
                    href += 'appkey=3964647319';
                    href += '&url=' + url;
                    href += '&title=' + title;
                    if ($E('img[share=true]'))
                        href += '&pic=' + location.href.substring(0, location.href.lastIndexOf("/") + 1) + $E('img[share=true]').get('src');
                    obj.set('href', href);
                }
                if (sharename == 'tencentshare') {
                    href = 'http://v.t.qq.com/share/share.php?';
                    href += 'appkey=8f92289eab7f400d81c248047e98b4bf';
                    href += '&url=' + url;
                    href += '&title=' + title;
                    if ($E('img[share=true]'))
                        href += '&pic=' + location.href.substring(0, location.href.lastIndexOf("/") + 1) + $E('img[share=true]').get('src');
                    obj.set('href', href);
                }
                if (sharename == 'kaixinshare') {
                    href = 'http://www.kaixin001.com/repaste/share.php?';
                    href += 'rtitle=' + title;
                    href += '&rurl=' + url;
                    href += '&rcontent=' + title;
                    obj.set('href', href);
                }
                if (sharename == 'renrenshare') {
                    href = 'http://share.renren.com/share/buttonshare.do?link=';
                    href += url;
                    obj.set('href', href);
                }
                if (sharename == 'doubanshare') {
                    href = 'http://www.douban.com/recommend/?';
                    href += 'url=' + url;
                    href += '&title=' + title;
                    obj.set('href', href);
                }
            });
        }
    } ();
});

(function ($j) {
    $j.fn.jfade = function (settings) {

        var defaults = {
            start_opacity: "1",
            high_opacity: "1",
            low_opacity: ".1",
            timing: "500"
        };
        var settings = $j.extend(defaults, settings);
        settings.element = $j(this);

        //set opacity to start
        $j(settings.element).css("opacity", settings.start_opacity);
        //mouse over
        $j(settings.element).hover(

        //mouse in
		function () {
		    $j(this).stop().animate({ opacity: settings.high_opacity }, settings.timing); //100% opacity for hovered object
		    $j(this).siblings().stop().animate({ opacity: settings.low_opacity }, settings.timing); //dimmed opacity for other objects
		},

        //mouse out
		function () {
		    $j(this).stop().animate({ opacity: settings.start_opacity }, settings.timing); //return hovered object to start opacity
		    $j(this).siblings().stop().animate({ opacity: settings.start_opacity }, settings.timing); // return other objects to start opacity
		}
	);
        return this;
    }

})(jQuery);


function OnExit(field) {
    if (field.value == "")
    { field.value = field.defaultValue; }
}

//收藏
/* lazyload begin */

var lazyloadimgspan = null;
function lazyload(option) {
    var settings = {
        defHeight: 0
    };
    settings = $j.extend(settings, option || {});
    var defHeight = settings.defHeight;
    var pageTop = function () {
        return document.documentElement.clientHeight + Math.max(document.documentElement.scrollTop, document.body.scrollTop) - settings.defHeight;
    };
    var imgLoad = function () {
        $j("img[src2]").each(function () {
            if ($j(this).offset().top <= pageTop()) {
                var src2 = $j(this).attr("src2");
                if (src2) {
                    $j(this).attr("src", src2).removeAttr("src2");
                }
            }
        });
    };
    lazyloadimgspan = setTimeout(function () { imgLoad(); }, 1000);
    $j(window).bind("scroll resize", function () {
        if (lazyloadimgspan != null)
            clearTimeout(lazyloadimgspan);
        imgLoad();
    });
}
/* lazyload end */