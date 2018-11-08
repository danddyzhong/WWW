/* 
 * @authors miued (www.miued.com)
 * @date    2015-10-16 20:34:58
 * @version 1.24
 */

jQuery(document).ready(function($) {
         img_height();
	$(window).resize(function(){
	  hdp_hei();
            // weintopleft();
             img_height();
	});

var myLazyLoad =new LazyLoad({
        elements_selector:'.lazy',
        threshold : 200,
        effect : "fadeIn"
       
    });
function getImgHeight(element){
    jQuery('img.thumb').each(function (i){
       var hei = jQuery(this).height()-28+'px';
       jQuery(this).parents('li').find('.jidi').css({
            top:hei
         });
    });
}

function logElementEvent(eventName, element) {
            console.log(new Date().getTime(), eventName, element.getAttribute('data-original'));
        }
        function logEvent(eventName, elementsLeft) {
            console.log(new Date().getTime(), eventName, elementsLeft + " images left");
        }

$('.caidan').on('click', function() { //移动端菜单显示

        var navlist = $('.navlistb');
        //var navheight=$('.nav').height();
        //console.log(lihei);
        if (navlist.css("height") == '0px') {
             $(this).addClass('xxc');
            navlist.css({
                height: 'auto'
            });
            //navlist.animate({height:navheight});
        } else {
              $(this).removeClass('xxc');
            navlist.css({
                height: '0px'
            });
        }

    })

//首页幻灯片高度计算
hdp_hei();
function hdp_hei(){
	isImgLoad(function(){
    // 加载完成
	    // var hei=$('#hdphome .slides li img').height();
        var hei=$('.flex-viewport').height();
		$('#hdphome').css('height','auto');
	});
}

var t_img; // 定时器
var isLoad = true; // 控制变量
// 判断图片加载状况，加载完成后回调
isImgLoad(function(){
    // 加载完成
    var hei=$('#hdphome .slides li img').height();
	$('#hdphome').height(hei);
	//	alert(hei);
});

// 判断图片加载的函数
function isImgLoad(callback){
    // 注意我的图片类名都是cover，因为我只需要处理cover。其它图片可以不管。
    // 查找所有封面图，迭代处理
    $('.coveimg').each(function(){
        // 找到为0就将isLoad设为false，并退出each
        if(this.height === 0){
            isLoad = false;
            return false;
        }else if(this.height < 200){
        	isLoad = false;
            return false;
        };
    });
    // 为true，没有发现为0的。加载完毕
    if(isLoad){
        clearTimeout(t_img); // 清除定时器
        // 回调函数
        callback();
    // 为false，因为找到了没有加载完成的图，将调用定时器递归
    }else{
        isLoad = true;
        t_img = setTimeout(function(){
            isImgLoad(callback); // 递归扫描
        },200); // 我这里设置的是500毫秒就扫描一次，可以自己调整
    }
}

$(".dwonBT").click(function(event) {
	//var top=$('#dwonBT').offset();
		event.preventDefault();
	$('html,body').animate({scrollTop:$('#dwonBT').offset().top-100},600);
});
$(".zaixianbf").click(function(event) {
    //var top=$('#dwonBT').offset();
        event.preventDefault();
    $('html,body').animate({scrollTop:$('.mi_paly_box').offset().top-50},600);
});

//下载链接地址JS管理
$('.download-link').on('click', function(event) {
     event.preventDefault();
     var ver   =  $(this).attr('ver');
     var doid = $(this).attr('dataid');
//     var link=um.wp_url+'/'+um.endpoint+'/'+doid+'/?version='+ver;
//     var ajaxlink =um.ajax_url+'?action=downloads_link&doid='+doid+'&ver='+ver;
     ajaxlink(doid,ver);
//    alert(link);
//     console.log(ajaxlink);
//     window.location.href=ajaxlink;
    /* Act on the event */
});
function ajaxlink(doid,ver){
        var AjaxURL=um.ajax_url;
        $.ajax({
	        type: 'POST',
//	        url: um.ajax_url,
	        url: 'http://'+window.location.host+"/ajaxget.php",
	        dataType: 'html',
	        data: {
	            'action' : 'downloads_link',
	            'doid' : doid,
	            'ver' : ver,
	            'hosturl':um.ajax_url,
	        },
	        beforeSend: function() {
	        },
	        success: function (result) {
	            window.location.href='http://'+window.location.host+result;
	        },
	        error: function(data) {
	            var txt='数据获取失败，请重试。'
	           
	         }

        });
};

//筛选功能提交
$('.sub_mi').each(function(index, el) {
    var val=$(this).val();
    if(val==0||val=='0'){
        $(this).parent('.beautiful-taxonomy-filters-tax').children('a').eq(0).addClass('selected-att');
    }
});

$('.beautiful-taxonomy-filters-tax a').on('click', function(event) {
    event.preventDefault(); 
    var idform=$("#beautiful-taxonomy-filters-form");
    if($(this).hasClass('selected-att')){
         idform.submit();
    }else{
         var slug=$(this).attr('slug');
             if(slug==''||slug==undefined){
                $(this).parent('.beautiful-taxonomy-filters-tax').find('input').val('0');
                 idform.submit();
             }else{
                 $(this).parent('.beautiful-taxonomy-filters-tax').find('input').val(slug);
                  idform.submit();
             }

    }
           
  });
  //筛选功能提交 end 
  
  //缩图比例，针对外链接图
function img_height(){
   $bi=270/380;
   $li=jQuery('.thumb').parent('a').parent('li').width();
   $imh=$li / $bi;
    jQuery('.thumb').parent('a').height($imh);
}



//***分享功能JS**//
 var _listImgData = {
        contxt  :   '',
        url     :  um.wp_url,
        title   :   '',
        pic     :   ''
    };
var _shareData={
    sina_name:um.sina_name,
    sina_key:um.sina_key,
    twitter_login:um.twitter_login
}
    function shareSina() {
        var title= '【'+ _listImgData.title +'】 '+ _listImgData.contxt +' - 更多电影下载 猛戳: '+_listImgData.url +' (分享来自 '+_shareData.sina_name+')';
        var pic = _listImgData.pic;
        var weibo_url = 'http://service.weibo.com/share/share.php?title='+ encodeURIComponent( title ) +'&source=bookmark&appkey='+_shareData.sina_key+'&pic='+encodeURIComponent( pic );
        window.open( weibo_url, "_blank", "height=495, width=600, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no" );
    };
    
    function shareQQ() {
        var title='【'+ _listImgData.title +'】 - 更多电影下载 ';
        var pic = _listImgData.pic;
        var teng_rul=  'http://connect.qq.com/widget/shareqq/index.html?url='+ _listImgData.url +'&title='+ encodeURIComponent( title )+'source=shareqq&desc='+ _listImgData.contxt;
        window.open( teng_rul, "_blank", "height=495, width=700, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no" );
    };
    function sharetwitter() {
        var title= '['+ _listImgData.title +'] ';
        var pic = _listImgData.pic;
        var pid = 655;
        var teng_rul=  'https://twitter.com/intent/tweet?text='+encodeURIComponent( title )+'- '+_listImgData.contxt+'&url='+_listImgData.url +'/&via='+_shareData.twitter_login;
        window.open( teng_rul, "_blank", "height=495, width=610, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no" );
    };
    function shareFacebook() {
        var title= '['+ _listImgData.title +'] - Movie Downloads ';
        var pic = _listImgData.pic;
        var pid = 655;
        var teng_rul= 'https://www.facebook.com/sharer.php?u='+ _listImgData.url;
    //var teng_rul='https://www.facebook.com/sharer/share?app_id=253430175040030&display=popup&href='+ _listImgData.url+'&redirect_uri='+ _listImgData.url;
            window.open( teng_rul, "_blank", "height=495, width=610, top=0, left=0, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, status=no" );
    };

    function contxt(){
        var contxt=$('.yp_context').html();
        var reg = new RegExp("<[^<]*>", "gi"); 
         var regkong=contxt.replace(reg, "");
         var contxtbox=regkong.replace(/[\s+]?/g,"");
         var contsub=contxtbox.substring(0,90);
        _listImgData.url = location.href;
        _listImgData.contxt =contsub;
        _listImgData.title = $('.moviedteail_tt h1').text().trim();
        _listImgData.pic = $('.dyimg img').attr('src');
    }

    $("#share-sina").click(function() {
        contxt();
        shareSina();
    });
    
    $("#share-qq").click(function() {
       contxt();
        shareQQ();
    });
    $("#share-twitter").click(function() {
       contxt();
        sharetwitter();
    });
     $("#share-facebook").click(function() {
        contxt();
        shareFacebook();
    });
    // 微信二维码分享框
    //微信分享二维码
$('.wxopen').on('click',function(){
    $(this).addClass('curr');
    $('.weixin-box').show();
})
$('.wxclose').on('click',function(){
    $('.wxopen').removeClass('curr');
    $('.weixin-box').hide();
})

//******分享JS结束***//

$('.weixingz').on('click',function(){
    if(jQuery('.weixinimg_bg').is(":hidden")){
        jQuery('.weixinimg_bg').fadeIn('200');
        jQuery('.weixinimg').fadeIn('200');
        weintopleft(jQuery('.weixinimg'));
    }
});
$('.weixinimg_bg').on('click',function(){
        jQuery('.weixinimg_bg').fadeOut('200');
        jQuery('.weixinimg').fadeOut('200');
         jQuery('.zshangimg').fadeOut('200');
        jQuery('.zshangimg .wx').hide();
         jQuery('.zshangimg .zfb').hide();
});
function weintopleft(el){
    var left=($(window).width()-el.width())/2;
    el.css({
        left:left
    });
}


$('.zshang .wx').on('click',function(){
    if(jQuery('.weixinimg_bg').is(":hidden")){
        jQuery('.weixinimg_bg').fadeIn('200');
        jQuery('.zshangimg').fadeIn('200');
        jQuery('.zshangimg .wx').show();
        weintopleft(jQuery('.zshangimg'));
    }
});
$('.zshang .zfb').on('click',function(){
    if(jQuery('.weixinimg_bg').is(":hidden")){
        jQuery('.weixinimg_bg').fadeIn('200');
        jQuery('.zshangimg').fadeIn('200');
        jQuery('.zshangimg .zfb').show();
        weintopleft(jQuery('.zshangimg'));
    }
});



////////////////////////////////textarea框字数-1///////////////////////////////////
    function exeTextKeyUp(t) {
        var max = parseInt(t.attr('maxlength'));
        if (t.length > 0) {
            if (t.val().length > max) {
                t.val(t.val().substr(0, t.attr('maxlength')));
            }
            if (t.parent().find(".cf30.abc").length > 0) {
                t.parent().find(".cf30.abc").html(max - t.val().length);
            } else if (t.parent().parent().find(".cf30.abc").length > 0) {
                t.parent().parent().find(".cf30.abc").html(max - t.val().length);
            }
        } else {

        }
    }
$('textarea[maxlength]').on('keyup', function() {
        exeTextKeyUp($(this));
    });
    $('textarea[maxlength]').on('blur', function() {
        exeTextKeyUp($(this));
    });

    $('input[maxlength]').on('keyup', function() {
        exeTextKeyUp($(this));
    });
    $('input[maxlength]').on('blur', function() {
        exeTextKeyUp($(this));
    });

    $.each($('textarea[maxlength]'), function(i, n) {
        exeTextKeyUp($(this));
    });
    $.each($('input[maxlength]'), function(i, n) {
        exeTextKeyUp($(this));
    });

$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body');
    $(document).on('click', '#commentnavi a', function(e) {
        e.preventDefault();
        $.ajax({
            type: "GET",
            url: $(this).attr('href'),
            beforeSend: function() {
                // 请将下方的“#comments_content”改为你的评论区块顶部任意ID/CLASS！
                $body.animate({
                    scrollTop: $('#qbpltxt').offset().top - 65
                }, 1500);

                $('#loading-comments').slideDown();
                // 请将下方的“.navigation”改为你的导航栏ID/CLASS！
                $('#commentnavi').remove();
                // 请将下方的“.commentlist”改为你的整体评论内容之ID/CLASS！
                $('.commentlist').fadeOut(800);

            },
            dataType: "html",
            success: function(out) {
                // 请将下方的“.commentlist”改为你的整体评论内容之ID/CLASS！
                result = $(out).find('.commentlist');
                // 请将下方的“.navigation”改为你的导航栏ID/CLASS！
                belownav = $(out).find('#commentnavi');
                $('#loading-comments').slideUp(550);
                //console.log(result);
                $('#loading-comments').after(result.fadeIn(800));
                result.after(belownav);
            }


        });

    });


//返回顶部
$(window).scroll(function() {
		if ($(this).scrollTop() >= 30) {
			if (!$(".to-top").hasClass("topbtnfadein"))
				$(".to-top").removeClass("topbtnfadeout topbtnhide").addClass("topbtnfadein topbtnshow").removeClass("topbtnfadein");
			//$(".to-top").stop().animate({bottom: 30, opacity: 100});
		} else {
			if (!$(".to-top").hasClass("topbtnfadeout"))
				$(".to-top").removeClass("topbtnfadein topbtnshow").addClass("topbtnfadeout topbtnhide").removeClass("topbtnfadeout");
		}
	})
$(".to-top").click(function() {
		$("body, html").stop().animate({
			scrollTop: 0
		});
	});


});//主结束

