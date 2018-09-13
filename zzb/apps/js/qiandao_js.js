$(function() {
    var signFun = function() {

      
        var res = getData();
        
        var $dateBox = $("#js-qiandao-list"), // 签到日期列表ul
            $currentDate = $(".current-date"), // 签到最上面的日期
            $qiandaoBnt = $("#js-just-qiandao"), //点击签到按钮
            _html = '',
            _handle = false, //判断当天是否可以进行签到
            myDate = new Date();
            $.getJSON("/ajax.php?act=isqiandao&rid="+rid,function(re){
				if(re.code==0){
					_handle = true;
				}
				$("#js-just-qiandao").html(_handle?'点击签到':'已签到');
				
			});
		
        $currentDate.text(myDate.getFullYear() + '年' + parseInt(myDate.getMonth() + 1) + '月' + myDate.getDate() + '日');
        /*填充页面内容*/
        handleData(res, true);
        /*获取当月第一天的星期数*/
        var monthFirst = new Date(myDate.getFullYear(), parseInt(myDate.getMonth()), 1).getDay();

        /*获取当前月的天数*/
        var d = new Date(myDate.getFullYear(), parseInt(myDate.getMonth() + 1), 0);
        var totalDay = d.getDate();

        /*生成日历网格*/
        for (var i = 0; i < 42; i++) {
            _html += ' <li><div class="qiandao-icon"></div></li>'
        }
        $dateBox.html(_html);

        /*生成当月的日历且含已签到*/
        var $dateLi = $dateBox.find("li");
        var ableqd = $(".date" + myDate.getDate()).hasClass('qiandao');
        for (var i = 0; i < totalDay; i++) {
            $dateLi.eq(i + monthFirst).addClass("date" + parseInt(i + 1)); // 添加数字样式
            for (var j = 0; j < dateArray.length; j++) { 
             
                if (i == dateArray[j]) {
                    $dateLi.eq(i + monthFirst-1).addClass("qiandao"); // 给已经签到过的日期添加签到过的样式
                }
            }
        }

        if (!ableqd) {
            $(".date" + myDate.getDate()).addClass('able-qiandao'); // 给当天添加可以签到的样式
        }
      

        /*点击当天日历进行签到*/
        $dateBox.on("click", "li", function() { 
           
                if ($(this).hasClass('able-qiandao') && _handle) {
                    $(this).addClass('qiandao');
                    qiandaoFun();
                }
            }) 

        /*点击立即签到按钮进行签到*/
        $qiandaoBnt.on("click", function() { 
            if(_handle) {
	           qiandaoFun();	
            }
        });

        $('#ShowSigninRes').click(function() {
            if(_handle) {
               qiandaoFun();    
            } else {
                // parent.layer.closeAll();
                layer.open({content: '今日已签到！' ,skin: 'msg',time: 2});
                var timer = setTimeout(function(){
                    parent.layer.closeAll();
                    clearTimeout(timer);
                },2000)
            }
        }); 

        /*弹出签到成功的提示，保存数据到数据库中*/
        function qiandaoFun() {
            //$qiandaoBnt.addClass('actived'); // 把签到按钮上的“立即签到”改成“已签到”
            $qiandaoBnt.html('已签到'); 
            openLayer("qiandao-active", qianDao);
            _handle = false; //设置当天不能再进行签到
        }
        function qianDao() {
            $('.qiandao-notic').text('今日已领' + res.credit + '元，请明日继续签到');
            
            $.ajax({
	        url: "/ajax.php?act=qiandao",  
	        type: "GET",
	        dataType : "json",
            async : false,
	        data:{rid:rid},
	        success: function(res) {  
            if(res.code=='1'){
            var newData = {
            'credit': res.credit,
            'persist': res.persist,
            'curMonth': res.curMonth + 1,
            'total': res.total + 0.2,
            'sumReward': res.sumReward + 0.2,
			're':res.re
            };
                parent.window.$("#Msg").html("[<b>每日一签</b>] 连续签到 <font style='color:red'>" +newData.persist + '</font> 天,'+"今日签到获得<font style='color:red'>"+newData.credit + newData.re+" </font>");
                parent.window.$("#Send_bt").click();
                  handleData(newData, false);
            $('#signin-records').append('<tr><td>' + handleDate() + '</td><td>' + 5+ '</td><td>每日签到</td></tr>');
            $(".date" + myDate.getDate()).addClass('qiandao');
			}
	        }
	    });
           
            //todo save data to database
            // $.ajax({
            //     type : "POST",
            //     url : "",
            //     data: {},
            //     dataType : "json",
            //     async : false,
            //     success : function(data) {
            //         res = data;
            //     }
            // });
        }
    }();

    /*从数据库中得到数据*/
    function getData() {

        var _history = [{
            'date': '2016-1-6 14:23:45',
            'reward': 0.20,
            'intro': '连续签到19天奖励'
        }, {
            'date': '2016-1-7 14:23:45',
            'reward': 0.20,
            'intro': '分享奖励'
        }, {
            'date': '2016-1-8 14:23:45',
            'reward': 0.20,
            'intro': '连续签到19天奖励'
        }, {
            'date': '2016-1-9 14:23:45',
            'reward': 0.20,
            'intro': '分享奖励'
        }, {
            'date': '2016-1-10 14:23:45',
            'reward': 0.20,
            'intro': '连续签到19天奖励'
        }, {
            'date': '2016-1-11 14:23:45',
            'reward': 0.20,
            'intro': '分享奖励'
        }, {
            'date': '2016-1-12 14:23:45',
            'reward': 0.20,
            'intro': '连续签到19天奖励'
        }, {
            'date': '2016-1-13 14:23:45',
            'reward': 0.20,
            'intro': '分享奖励'
        }, {
            'date': '2016-1-14 14:23:45',
            'reward': 0.20,
            'intro': '连续签到19天奖励'
        }];
        return {
            'credit': 0.5,
            'persist': 2,
            'curMonth': 4,
            'total': 10,
            'sumReward': 20,
            '_history': _history
        };
    }

    /*处理数据*/
    function handleData(data, needDrawRecords) {
        $('.qiandao-history-inf #persist h4').text(data.persist);
        $('.qiandao-history-inf #cur-month h4').text(data.curMonth);
        $('.qiandao-history-inf #total h4').text(data.total);
        $('.qiandao-history-inf #sum-reward h4').text(data.sumReward);
        $('.persisit-signin-tip').text('您已连续签到' + data.persist + '天');
        $('.qiandao-jiangli-num').text(data.credit + data.re);

        /*绘制签到历史记录列表*/
        if (needDrawRecords) {
            var records = '';
            var history = data._history; 
            for (var i = 0; i < history.length; i++) {
                records += '<tr><td>' + history[i].date + '</td><td>' + history[i].reward + '</td><td>' + history[i].intro + '</td></tr>';
            }
            $('#signin-records').html(records);
        }
    }

    /*处理日期*/
    function handleDate() {
        var curDate = new Date(),
            year = curDate.getFullYear(),
            month = curDate.getMonth() + 1,
            day = curDate.getDate(),
            hour = curDate.getHours(),
            min = curDate.getMinutes(),
            sec = curDate.getSeconds();
            if (hour < 10) {
                hour = '0' + hour;
            }
            if (min < 10) {
                min = '0' + min;
            }
            if (sec < 10) {
                sec = '0' + sec;
            }

        return year + '-' + month + '-' + day + ' ' + hour + ':' + min + ':' + sec;
    }

    /*打开弹窗公用方法*/
    function openLayer(a, Fun) {
        $('.' + a).fadeIn(Fun)
    }

    /*关闭我的签到弹框*/
    var closeLayer = function() {
            $("body").on("click", ".close-qiandao-layer", function() {
                $(this).parents(".qiandao-layer").fadeOut();
                if (isMobile) {
                    parent.layer.closeAll();
                }
            })
        }()

    /*弹出我的签到弹框*/
    $("#js-qiandao-history").on("click", function() {
        openLayer("qiandao-history-layer", myFun);

        //打开弹窗返回函数
        function myFun() {
           //do nothing
        } 
    })
})
