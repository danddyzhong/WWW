(function(){var f=!0,h=null,k=!1,aa=function(a,b,c){return a.call.apply(a.bind,arguments)},ba=function(a,b,c){if(!a)throw Error();if(2<arguments.length){var e=Array.prototype.slice.call(arguments,2);return function(){var c=Array.prototype.slice.call(arguments);Array.prototype.unshift.apply(c,e);return a.apply(b,c)}}return function(){return a.apply(b,arguments)}},l=function(a,b,c){l=Function.prototype.bind&&-1!=Function.prototype.bind.toString().indexOf("native code")?aa:ba;return l.apply(h,arguments)};var m=(new Date).getTime();var p=function(a){a=parseFloat(a);return isNaN(a)||1<a||0>a?0:a},ca=/^([\w-]+\.)*([\w-]{2,})(\:[0-9]+)?$/,da=function(a,b){if(!a)return b;var c=a.match(ca);return c?c[0]:b};var ea=p("0.15"),fa=p("0.001"),ga=p("0.5"),ha=p("0.005");var r=function(){return"r20130411"},ka=/^true$/.test("false")?f:k,la=/^true$/.test("false")?f:k;var ma=function(){return da("","pagead2.googlesyndication.com")};var na=/&/g,oa=/</g,pa=/>/g,qa=/\"/g,t={"\x00":"\\0","\b":"\\b","\f":"\\f","\n":"\\n","\r":"\\r","\t":"\\t","\x0B":"\\x0B",'"':'\\"',"\\":"\\\\"},v={"'":"\\'"};var w=window,ra,sa=h,x=document.getElementsByTagName("script");x&&x.length&&(sa=x[x.length-1].parentNode);ra=sa;ma();var ta=function(a){var b=y,c;for(c in b)Object.prototype.hasOwnProperty.call(b,c)&&a.call(h,b[c],c,b)},z=function(a){return!!a&&"function"==typeof a&&!!a.call},ua=function(a,b){if(!(2>arguments.length))for(var c=1,e=arguments.length;c<e;++c)a.push(arguments[c])};function va(a,b){a.addEventListener?a.addEventListener("load",b,k):a.attachEvent&&a.attachEvent("onload",b)}
var wa=function(a,b){if(!(1E-4>Math.random())){var c=Math.random();if(c<b)return a[Math.floor(c/b*a.length)]}return h},xa=function(a){try{return!!a.location.href||""===a.location.href}catch(b){return k}};var ya=h,za=function(){if(!ya){for(var a=window,b=a,c=0;a!=a.parent;)if(a=a.parent,c++,xa(a))b=a;else break;ya=b}return ya};var A,B=function(a){this.c=[];this.b=a||window;this.a=0;this.d=h},Aa=function(a,b){this.l=a;this.i=b};B.prototype.n=function(a,b){0==this.a&&0==this.c.length&&(!b||b==window)?(this.a=2,this.f(new Aa(a,window))):this.g(a,b)};B.prototype.g=function(a,b){this.c.push(new Aa(a,b||this.b));Ba(this)};B.prototype.o=function(a){this.a=1;a&&(this.d=this.b.setTimeout(l(this.e,this),a))};B.prototype.e=function(){1==this.a&&(this.d!=h&&(this.b.clearTimeout(this.d),this.d=h),this.a=0);Ba(this)};B.prototype.p=function(){return f};
B.prototype.nq=B.prototype.n;B.prototype.nqa=B.prototype.g;B.prototype.al=B.prototype.o;B.prototype.rl=B.prototype.e;B.prototype.sz=B.prototype.p;var Ba=function(a){a.b.setTimeout(l(a.m,a),0)};B.prototype.m=function(){if(0==this.a&&this.c.length){var a=this.c.shift();this.a=2;a.i.setTimeout(l(this.f,this,a),0);Ba(this)}};B.prototype.f=function(a){this.a=0;a.l()};
var Ca=function(a){try{return a.sz()}catch(b){return k}},Da=function(a){return!!a&&("object"==typeof a||"function"==typeof a)&&Ca(a)&&z(a.nq)&&z(a.nqa)&&z(a.al)&&z(a.rl)},Ea=function(){if(A&&Ca(A))return A;var a=za(),b=a.google_jobrunner;return Da(b)?A=b:a.google_jobrunner=A=new B(a)},Fa=function(a,b){Ea().nq(a,b)},Ga=function(a,b){Ea().nqa(a,b)};var Ha=/MSIE [2-7]|PlayStation|Gecko\/20090226/i,Ia=/Android|Opera/;var Ja=function(a,b,c){c||(c=la?"https":"http");return[c,"://",a,b].join("")};var Ka=function(){},Ma=function(a,b,c){switch(typeof b){case "string":La(b,c);break;case "number":c.push(isFinite(b)&&!isNaN(b)?b:"null");break;case "boolean":c.push(b);break;case "undefined":c.push("null");break;case "object":if(b==h){c.push("null");break}if(b instanceof Array){var e=b.length;c.push("[");for(var d="",g=0;g<e;g++)c.push(d),Ma(a,b[g],c),d=",";c.push("]");break}c.push("{");e="";for(d in b)b.hasOwnProperty(d)&&(g=b[d],"function"!=typeof g&&(c.push(e),La(d,c),c.push(":"),Ma(a,g,c),e=
","));c.push("}");break;case "function":break;default:throw Error("Unknown type: "+typeof b);}},Na={'"':'\\"',"\\":"\\\\","/":"\\/","\b":"\\b","\f":"\\f","\n":"\\n","\r":"\\r","\t":"\\t","\x0B":"\\u000b"},Oa=/\uffff/.test("\uffff")?/[\\\"\x00-\x1f\x7f-\uffff]/g:/[\\\"\x00-\x1f\x7f-\xff]/g,La=function(a,b){b.push('"');b.push(a.replace(Oa,function(a){if(a in Na)return Na[a];var b=a.charCodeAt(0),d="\\u";16>b?d+="000":256>b?d+="00":4096>b&&(d+="0");return Na[a]=d+b.toString(16)}));b.push('"')};var C="google_ad_block google_ad_channel google_ad_client google_ad_format google_ad_height google_ad_host google_ad_host_channel google_ad_host_tier_id google_ad_output google_ad_override google_ad_region google_ad_section google_ad_slot google_ad_type google_ad_width google_adtest google_allow_expandable_ads google_alternate_ad_url google_alternate_color google_analytics_domain_name google_analytics_uacct google_bid google_city google_color_bg google_color_border google_color_line google_color_link google_color_text google_color_url google_container_id google_contents google_country google_cpm google_ctr_threshold google_cust_age google_cust_ch google_cust_gender google_cust_id google_cust_interests google_cust_job google_cust_l google_cust_lh google_cust_u_url google_disable_video_autoplay google_ed google_eids google_enable_ose google_encoding google_font_face google_font_size google_frame_id google_gl google_hints google_image_size google_kw google_kw_type google_lact google_language google_loeid google_max_num_ads google_max_radlink_len google_mtl google_num_radlinks google_num_radlinks_per_unit google_num_slots_to_rotate google_only_ads_with_video google_only_pyv_ads google_only_userchoice_ads google_override_format google_page_url google_previous_watch google_previous_searches google_referrer_url google_region google_reuse_colors google_rl_dest_url google_rl_filtering google_rl_mode google_rt google_safe google_sc_id google_scs google_sui google_skip google_tag_info google_targeting google_tdsma google_tfs google_tl google_ui_features google_ui_version google_video_doc_id google_video_product_type google_with_pyv_ads google_yt_pt google_yt_up".split(" ");var Pa=/\.((google(|groups|mail|images|print))|gmail)\./,Qa=function(a){var b=Pa.test(a.location.host);return!(!a.postMessage||!a.localStorage||!a.JSON||b)};var Sa=function(a){this.b=a;a.google_iframe_oncopy||(a.google_iframe_oncopy={handlers:{}});this.j=a.google_iframe_oncopy},Ta;var E="var i=this.id,s=window.google_iframe_oncopy,H=s&&s.handlers,h=H&&H[i],w=this.contentWindow,d;try{d=w.document}catch(e){}if(h&&d&&(!d.body||!d.body.firstChild)){if(h.call){setTimeout(h,0)}else if(h.match){w.location.replace(h)}}";
/[&<>\"]/.test(E)&&(-1!=E.indexOf("&")&&(E=E.replace(na,"&amp;")),-1!=E.indexOf("<")&&(E=E.replace(oa,"&lt;")),-1!=E.indexOf(">")&&(E=E.replace(pa,"&gt;")),-1!=E.indexOf('"')&&(E=E.replace(qa,"&quot;")));Ta=E;Sa.prototype.set=function(a,b){this.j.handlers[a]=b;this.b.addEventListener&&!/MSIE/.test(navigator.userAgent)&&this.b.addEventListener("load",l(this.k,this,a),k)};Sa.prototype.k=function(a){a=this.b.document.getElementById(a);var b=a.contentWindow.document;if(a.onload&&b&&(!b.body||!b.body.firstChild))a.onload()};function Ua(){var a=F,b=F.document,c=a.google_ad_width,e=a.google_ad_height;if(a.top==a)return k;var d=b.documentElement;if(c&&e){var g=1,n=1;a.innerHeight?(g=a.innerWidth,n=a.innerHeight):d&&d.clientHeight?(g=d.clientWidth,n=d.clientHeight):b.body&&(g=b.body.clientWidth,n=b.body.clientHeight);if(n>2*e||g>2*c)return k}return f};var Va=function(){var a="script";return["<",a,' src="',Ja(ma(),["/pagead/js/",r(),"/r20130206/show_ads_impl.js"].join(""),""),'"></',a,">"].join("")},Wa=function(a,b,c,e){return function(){var d=k;e&&Ea().al(3E4);try{if(xa(a.document.getElementById(b).contentWindow)){var g=a.document.getElementById(b).contentWindow,n=g.document;if(!n.body||!n.body.firstChild)n.open(),
g.google_async_iframe_close=f,n.write(c)}else{var R=a.document.getElementById(b).contentWindow,ia;g=c;g=String(g);if(g.quote)ia=g.quote();else{for(var n=['"'],S=0;S<g.length;S++){var T=g.charAt(S),Ra=T.charCodeAt(0),Lb=n,Mb=S+1,ja;if(!(ja=t[T])){var D;if(31<Ra&&127>Ra)D=T;else{var s=T;if(s in v)D=v[s];else if(s in t)D=v[s]=t[s];else{var q=s,u=s.charCodeAt(0);if(31<u&&127>u)q=s;else{if(256>u){if(q="\\x",16>u||256<u)q+="0"}else q="\\u",4096>u&&(q+="0");q+=u.toString(16).toUpperCase()}D=v[s]=q}}ja=D}Lb[Mb]=
ja}n.push('"');ia=n.join("")}R.location.replace("javascript:"+ia)}d=f}catch(Xb){R=za().google_jobrunner,Da(R)&&R.rl()}d&&(new Sa(a)).set(b,Wa(a,b,c,k))}},Xa=function(){var a=["<iframe"];ta(function(b,c){a.push(" "+c+'="'+(b==h?"":b)+'"')});a.push("></iframe>");return a.join("")},Ya=function(a,b){var c=F.google_ad_height,e=b?'"':"",d=e+"0"+e;a.width=e+F.google_ad_width+e;a.height=e+c+e;a.frameborder=d;a.marginwidth=d;a.marginheight=d;a.vspace=d;a.hspace=d;a.allowtransparency=e+"true"+e;a.scrolling=
e+"no"+e},Za=Math.floor(1E6*Math.random()),$a=function(a){for(var b=a.data.split("\n"),c={},e=0;e<b.length;e++){var d=b[e].indexOf("=");-1!=d&&(c[b[e].substr(0,d)]=b[e].substr(d+1))}b=c[3];if(c[1]==Za&&(window.google_top_js_status=4,a.source==top&&0==b.indexOf(a.origin)&&(window.google_top_values=c,window.google_top_js_status=5),window.google_top_js_callbacks)){for(a=0;a<window.google_top_js_callbacks.length;a++)window.google_top_js_callbacks[a]();window.google_top_js_callbacks.length=0}};window.google_loader_used=f;(function(a){"google_onload_fired"in a||(a.google_onload_fired=k,va(a,function(){a.google_onload_fired=f}))})(window);
if(!window.google_top_experiment&&(window.google_top_experiment=wa(["jp_c","jp_zl","jp_wfpmr"],ea),"jp_zl"===window.google_top_experiment||"jp_wfpmr"===window.google_top_experiment)){var ab=window,bb=2;try{ab.top.document==ab.document?bb=0:xa(ab.top)&&(bb=1)}catch(cb){}if(2!==bb)window.google_top_js_status=0;else if(top.postMessage){var db;try{db=top.frames.google_top_static_frame?f:k}catch(eb){db=k}if(db){var G=window;G.addEventListener?G.addEventListener("message",$a,k):G.attachEvent&&G.attachEvent("onmessage",
$a);window.google_top_js_status=3;var fb={"0":"google_loc_request",1:Za},gb=[],hb;for(hb in fb)gb.push(hb+"="+fb[hb]);top.postMessage(gb.join("\n"),"*")}else window.google_top_js_status=2}else window.google_top_js_status=1}var ib;
if(window.google_enable_async===k)ib=0;else{var jb;var kb=navigator.userAgent;Ha.test(kb)?jb=k:(void 0===window.google_async_for_oa_experiment&&Ia.test(navigator.userAgent)&&(window.google_async_for_oa_experiment=wa(["C","E"],ha)),jb=Ia.test(kb)?"E"===window.google_async_for_oa_experiment:f);ib=jb&&!window.google_container_id&&(!window.google_ad_output||"html"==window.google_ad_output)}
if(ib){var lb=window;lb.google_unique_id?++lb.google_unique_id:lb.google_unique_id=1;var F=window,H={};Ya(H,f);H.onload='"'+Ta+'"';for(var I,mb=F,nb=mb.document,J=H.id,ob=0;!J||nb.getElementById(J);)J="aswift_"+ob++;H.id=J;H.name=J;var pb=mb.google_ad_width,qb=mb.google_ad_height,K=["<iframe"],L;for(L in H)H.hasOwnProperty(L)&&ua(K,L+"="+H[L]);K.push('style="left:0;position:absolute;top:0;"');K.push("></iframe>");var rb="border:none;height:"+qb+"px;margin:0;padding:0;position:relative;visibility:visible;width:"+
pb+"px";nb.write(['<ins style="display:inline-table;',rb,'"><ins id="',H.id+"_anchor",'" style="display:block;',rb,'">',K.join(" "),"</ins></ins>"].join(""));I=H.id;var sb,M=F;M.google_page_url&&(M.google_page_url=String(M.google_page_url));for(var tb=[],ub=0,vb=C.length;ub<vb;ub++){var wb=C[ub];if(M[wb]!=h){var xb;try{var yb=[];Ma(new Ka,M[wb],yb);xb=yb.join("")}catch(zb){}xb&&ua(tb,wb,"=",xb,";")}}sb=tb.join("");var N=F,Ab=N.google_ad_output,O=N.google_ad_format;if(!O&&("html"==Ab||Ab==h))O=N.google_ad_width+
"x"+N.google_ad_height;O=O&&(!N.google_ad_slot||N.google_override_format)?O.toLowerCase():"";N.google_ad_format=O;var P,Bb=F.google_async_container_id?F.document.getElementById(F.google_async_container_id):ra,Cb=[w.google_ad_slot,w.google_ad_format,w.google_ad_type,w.google_ad_width,w.google_ad_height];if(Bb){var Q;if(Bb){for(var Db=[],Eb=0,U=Bb;U&&25>Eb;U=U.parentNode,++Eb)Db.push(9!=U.nodeType&&U.id||"");Q=Db.join()}else Q="";Q&&Cb.push(Q)}var Fb=0;if(Cb){var Gb=Cb.join(":"),Hb=Gb.length;if(0==
Hb)Fb=0;else{for(var V=305419896,Ib=0;Ib<Hb;Ib++)V^=(V<<5)+(V>>2)+Gb.charCodeAt(Ib)&4294967295;Fb=0<V?V:4294967296+V}}P=Fb.toString();a:{var W=F,X=W.google_async_slots;X||(X=W.google_async_slots={});var Jb=W.google_unique_id,Y=String("number"==typeof Jb?Jb:0);if(Y in X&&(Y+="b",Y in X))break a;X[Y]={sent:k,w:W.google_ad_width||"",h:W.google_ad_height||"",adk:P,type:W.google_ad_type||"",slot:W.google_ad_slot||"",fmt:W.google_ad_format||"",cli:W.google_ad_client||"",saw:[]}}var Z,$=F;if(Qa($)&&void 0===
$.google_ad_handling_experiment){var Kb=ka&&"dev"!=r()?ga:fa,Nb=ka&&"dev"!=r()?["XN","PC"]:["X","XN","PC"];/MSIE/.test(navigator.userAgent)&&(Nb=["IX","IC"]);$.google_ad_handling_experiment=wa(Nb,Kb)}Z=$.google_ad_handling_experiment?String($.google_ad_handling_experiment):h;var Ob="";if(Qa(F)&&1==F.google_unique_id&&"XN"!=Z){var Pb;Pb="zrt_ads_frame"+F.google_unique_id;var Qb=encodeURIComponent(F.google_page_url||Ua()?F.document.referrer:F.document.URL),Rb=h;if("PC"==Z||"IC"==Z)Rb="K-"+(Qb+"/"+P+
"/"+F.google_unique_id);var y={};Ya(y,k);y.style="display:none";var Sb=Rb;y.id=Pb;y.name=Pb;y.src=Ja(da("","googleads.g.doubleclick.net"),["/pagead/html/",r(),"/r20130206/zrt_lookup.html",Sb?"#"+encodeURIComponent(Sb):""].join(""));Ob=Xa()}for(var Tb=F,Ub=0,Vb=C.length;Ub<Vb;Ub++)Tb[C[Ub]]=h;var Wb=(new Date).getTime(),Yb=F.google_top_experiment,Zb=F.google_async_for_oa_experiment,$b=["<!doctype html><html><body>",
Ob,"<script>",sb,"google_show_ads_impl=true;google_unique_id=",F.google_unique_id,';google_async_iframe_id="',I,'";google_ad_unit_key="',P,'";google_start_time=',m,";",Yb?'google_top_experiment="'+Yb+'";':"",Z?'google_ad_handling_experiment="'+Z+'";':"",Zb?'google_async_for_oa_experiment="'+Zb+'";':"","google_bpp=",Wb>m?Wb-m:1,";\x3c/script>",Va(),"</body></html>"].join("");(F.document.getElementById(I)?Fa:Ga)(Wa(F,I,$b,f))}else window.google_start_time=m,document.write(Va());})();

