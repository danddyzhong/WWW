(function() {
	var btnId = '__gotop';
	var isIE = !!window.ActiveXObject && /msie (\d)/i.test(navigator.userAgent) ? RegExp['$1'] : false;
	
	function $() {
		return document.getElementById(arguments[0]);
	}
	
	function getScrollTop() {
	    return ('pageYOffset' in window) ? window.pageYOffset
	        : document.compatMode === "BackCompat"
	        && document.body.scrollTop
	        || document.documentElement.scrollTop ;
	}	
	
	function bindEvent(event, func) {
		if (window.addEventListener) {
			window.addEventListener(event, func, false);
		} else if (window.attachEvent) {
			window.attachEvent('on' + event, func);
		}		
	}
	
	bindEvent('load', 
		function() {
			var css = 'background-color:#FE597C;width:50px;height:50px;position:fixed;right:100px;bottom:10px; cursor:pointer;display:none;';
			
			if (isIE && isIE < 7) {
				css += '_position:absolute;_top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-30-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)))';
				var style = document.createStyleSheet();
				style.cssText = '*html{background-image:url(about:blank);background-attachment:fixed;}';
			}
			
			var html = '<div style="height: 0;width: 0;border:14px solid #FE597C;border-top: 0 none;border-bottom:14px solid #fff;position: relative;margin:12px 0 0 11px;"><div style="width:8px;height:7px;position:absolute;top:14px;left:-4px;background-color:#fff;overflow: hidden;"></div></div>';
			var el = document.createElement('DIV');
			el.id = btnId;
			el.style.cssText = css;
			el.innerHTML = html;
			document.body.appendChild(el);
			
			el.onclick = function() {
				(function() {
					var top = getScrollTop();
					
					if (top > 0) {
						window.scrollTo(0, top / 1.2)
						setTimeout(arguments.callee, 10);
					}
				})();							
			};
			
			el.onmouseover = function() {
				$(btnId).firstChild.style.borderBottom = '14px solid #FFFF79';
				$(btnId).firstChild.firstChild.style.backgroundColor = '#FFFF79';
			};
			
			el.onmouseout = function() {
				$(btnId).firstChild.style.borderBottom = '14px solid #fff';
				$(btnId).firstChild.firstChild.style.backgroundColor = '#fff';
			};
		}
	);
	
	bindEvent('scroll',
		function() {
			var top = getScrollTop(), display = 'none';
			
			if (top > 0) {
				display = 'block';
			}
			
			if ($(btnId)) $(btnId).style.display = display;			
		});
})();
