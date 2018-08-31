$(function(){
	$('.tin-tabs-nav .tin-tab:eq(0)').addClass('active').parent().next().children().eq(0).attr('style','display:block;').siblings().attr('style','display:none;');
	$('.tin-tabs-nav .tin-tab').bind({
		mouseover:function(){
			$(this).addClass('active').siblings().removeClass('active').parent().next().children().eq($(this).index()).attr('style',"display:block;").siblings().attr('style','display:none;');
		},
	});
	$(".fa-search").click(function(){
		$(".header-search-slide").slideToggle();
	})
	$("#back-to-top").hide();
	var w_height =$(window).height();
	$(window).scroll(function(){
		if($(window).scrollTop()>w_height){
			$("#back-to-top").fadeIn(500);
		}else{
			$("#back-to-top").fadeOut(500);
		}
	});
	$("#back-to-top").click(function(){
		$('body,html').animate({scrollTop:0},500);
		return false;
	})
	$(".toggle-menu").toggle(
		function(){
			$("#navmenu-mobile,#content-container,#navmenu-mobile-wraper").addClass('push');
		},
		function(){
			$("#navmenu-mobile,#content-container,#navmenu-mobile-wraper").removeClass('push');
		}
	)
})