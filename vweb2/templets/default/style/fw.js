/*垂直导航,用上一种方法看到渐变瞬间*/
//jQuery("#nav").slide({ type:"menu", titCell:".nLi", targetCell:".sub",effect:"fade",delayTime:0,triggerTime:0,defaultPlay:false,returnDefault:true,easing:"swing"});
$("#nav .nLi").hover(function(){
    $("#nav .nLi").removeClass('on');
    $(this).addClass('on');
    $("#nav .nLi .sub").hide();
    $(this).children('.sub').show();
},function(){
    $("#nav .nLi").removeClass('on');
    $("#nav .nLi .sub").hide();
});


/*排行榜tab切换*/
jQuery(".like-lists-tab").slide({trigger:"click"});


/*banner切换*/
		$(function () {
                $('.slide_banner > li').each(function (index) {
                    $('.slide_btn').append('<li data-index="banner'+index+'"></li>');
                    $('.slide_btn > li').mouseenter(function () {
                        $('.slide_btn > li.on').removeClass('on');
                        $(this).addClass('on');

                        var id = $(this).attr('data-index');
                        $('.slide_banner > li.active').removeClass('active');
                        $('#'+id).parent().addClass('active');
                    });
                    $('.slide_btn > li:first').mouseenter();
                });
                setInterval('switch_slide()',5000);

                
            });
            function switch_slide() {
                if ($('.slide_btn > li.on').next().length > 0){
                    $('.slide_btn > li.on').next().mouseenter();
                }else {
                    $('.slide_btn > li:first').mouseenter();
                }
            }

/*二级导航hover*/

$('.fw-subnav li').click(function(){
	$(this).addClass('on').siblings().removeClass('on');
})


/*查字典小工具*/
$('.czd-tool li').mouseenter(function(){
    $(this).find('em').css("background","#18a97a");
})
$('.czd-tool li').mouseleave(function(){
    $(this).find('em').css("background","#d9d9d9");
})