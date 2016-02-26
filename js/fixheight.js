/*fix browser*/

function resize()
{
    viewHigh=document.body.clientHeight;
    viewWidth=document.body.clientWidth;
    if (viewHigh<580){
        viewHigh=580;
    }
    height_header_footer= document.getElementById('border-top').clientHeight+document.getElementById('footer').clientHeight;
    var content_box_height=viewHigh - height_header_footer;
    if ( document.getElementById('accordion_holder') ){
         content_box_height=document.getElementById('accordion_holder').clientHeight;
            if(viewHigh>content_box_height){
                content_box_height=viewHigh - height_header_footer;
            }
            if(content_box_height<document.getElementById('accordion_holder').clientHeight)
            {
                content_box_height=document.getElementById('accordion_holder').clientHeight;
            }
    }


    document.getElementById('content-box').style.height=content_box_height+'px';
    var margin_left=(viewWidth-550)/2 -15;
    if (margin_left<0){
        margin_left=2;
    }
 
    if ( document.getElementById('login_main_form'))
    {
      $("#login_main_form").css({
        'margin-left': margin_left
       });
      $("#login_main_form").show();
    }

    if ( document.getElementById('img_logo_150')){
       fit_img('img_logo_150',"lock");
    }
}

        window.onload = function(){
             window.addEventListener("resize", function(){resize();}, true);
             resize();
}
