
$(function(){
    
    function append_html(data){
        try{
			data = data.replace(/\+/g,'_')	    
		    var obj_data = eval('(' + data + ')');
	     	       c_class = obj_data['code'];
                    
                    Last        = obj_data['last'];
                    Swing       = obj_data['swing'];
                    SwingRange  = obj_data['swingRange'];
                    
                    LastClose   = obj_data['lastClose'];
                    
                    Last_float  = parseFloat(Last);
                    
                    last_html = ''
                    swing_html = ''
                    swingrange_html = ''
                    
                    if(parseFloat(Last) > parseFloat(LastClose)){
                        last_html = '<span style="color:red">'+Last+'</span>'
                        swing_class = 'red'
                        swingrange_class = 'red'
                        Swing       = '+'+Swing
                        SwingRange  = '+'+SwingRange
                    }else if(parseFloat(Last) < parseFloat(LastClose)){
                        last_html = '<span style="color:green">'+Last+'</span>'
                        swing_class = 'green'
                        swingrange_class = 'green'
                        //Swing       = '-'+Swing
                        //SwingRange  = '-'+SwingRange
                    }else{
                        last_html = '<span>'+Last+'</span>'
                        swing_class = 'gray'
                        swingrange_class = ''
                    }
                    
                    $('.'+c_class +'> .td2').html(last_html)
                    $('.'+c_class +'> .td3 > span > .data1').html(Swing)
                    $('.'+c_class +'> .td3 > span > .data2').html(SwingRange)
                    $('.'+c_class +'> .td3 > span').removeClass('red')
                    $('.'+c_class +'> .td3 > span').removeClass('green')
                    $('.'+c_class +'> .td3 > span').removeClass('gray')
                    $('.'+c_class +'> .td3 > span').addClass(swing_class)
                    
                    
		        

		}catch(e){
			//alert(e.message()+'分隔数据出错');	
		}
    }
    
    
    function firstAppendHtml(data){
        try{
			data = data.replace(/\+/g,'_')	    
		    var obj_data = eval('(' + data + ')');

            c_class = obj_data['code'];
            code    = obj_data['code'];
   
            Last        = obj_data['last'];
            Swing       = obj_data['swing'];
            SwingRange  = obj_data['swingRange'];
            
            LastClose   = obj_data['lastClose'];
            
            Last_float  = parseFloat(Last);
            
            last_html = ''
            swing_html = ''
            swingrange_html = ''
            
            if(parseFloat(Last) > parseFloat(LastClose)){
                last_html = '<span style="color:red">'+Last+'</span>'
                swing_class = 'red'
                swingrange_class = 'red'
                Swing       = '+'+Swing
                SwingRange  = '+'+SwingRange
            }else if(parseFloat(Last) < parseFloat(LastClose)){
                last_html = '<span style="color:green">'+Last+'</span>'
                swing_class = 'green'
                swingrange_class = 'green'
                //Swing       = '-'+Swing
                //SwingRange  = '-'+SwingRange
            }else{
                last_html = '<span>'+Last+'</span>'
                swing_class = 'gray'
                swingrange_class = ''
            }
            
            $('.'+c_class +'> .td2').html(last_html)
            $('.'+c_class +'> .td3 > span > .data1').html(Swing)
            $('.'+c_class +'> .td3 > span > .data2').html(SwingRange)
            $('.'+c_class +'> .td3 > span').removeClass('red')
            $('.'+c_class +'> .td3 > span').removeClass('green')
            $('.'+c_class +'> .td3 > span').removeClass('gray')
            $('.'+c_class +'> .td3 > span').addClass(swing_class)


		}catch(e){
			//alert(e.message()+'分隔数据出错');	
		}
    }
    
    //console.log('test',serverIP);
    function load_lastdata(configFlag){
        $.ajaxSettings.async = false;
        $.get("http://www.kuaixun360.com/html/hq/exp/get_hqinfo_data.php",{configFlag:configFlag},function(json){
            json_array = new Array();
            json_array = json.split('______');
	    //console.log(json_array);
            console.log(json_array);
            for(i = 0;i<json_array.length;i++){
  		if(json_array[i] != 'undefined'){
	                firstAppendHtml(json_array[i])
		}
            }
        })
    }
    
    //load_lastdata(configFlag);
	var iosocket = io.connect('http://'+serverIP,{multiplex:false});
     	     iosocket.on('connect', function () {
        });
        iosocket.emit('login',codeStr)
        iosocket.on('t_hqinfo',function(data){
             append_html(data)
        })
})



/**

 *    debug - broadcasting packet
 * 实时行情: {"StockList":{"XAU":{"Index":1,"IsMain":true,"Decimals":0,"DetailList"
 * :{"Name":"现货黄金","Jys":"WGJS","Last":"1280.83","Volume":"0.00","Open":"1277.7
 * 5","LastClose":"1277.40","High":"1281.83","Low":"1276.20","TotalVolume":"0.00","
 * Buy":"1280.83","Sell":"1281.28","Swing":3.43,"SwingRange":"0.27%"}}}} - from cli
 * ent YRftFsBQtHBqzkgGdEZp
 *    debug - broadcasting packet
 * 实时行情: {"StockList":{"XAG":{"Index":2,"IsMain":true,"Decimals":0,"DetailList"
 * :{"Name":"现货白银","Jys":"WGJS","Last":"19.52","Volume":"0.00","Open":"19.41","
 * LastClose":"19.41","High":"19.58","Low":"19.39","TotalVolume":"0.00","Buy":"19.5
 * 2","Sell":"19.57","Swing":0.11,"SwingRange":"0.57%"}}}} - from client YRftFsBQtH
 * BqzkgGdEZp
 *    debug - broadcasting packet
 * 实时行情: {"StockList":{"XAU":{"Index":1,"IsMain":true,"Decimals":0,"DetailList"
 * :{"Name":"现货黄金","Jys":"WGJS","Last":"1280.84","Volume":"0.00","Open":"1277.7
 * 5","LastClose":"1277.40","High":"1281.83","Low":"1276.20","TotalVolume":"0.00","
 * Buy":"1280.84","Sell":"1281.29","Swing":3.44,"SwingRange":"0.27%"}}}} - from cli
 * ent YRftFsBQtHBqzkgGdEZp

 */
