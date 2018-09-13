
var giMoBaseUrl = "./face/";
var giMoCellWidth = 24;
var giMoCellHeight = 24;
var giMoRowNum = 4;
var giMoColNum = 9;
var giMoCurTab = 0;
var giMoCurPage = 0;
var giMoShowWidth = 75;
var giMoShowHeight = 75;

/*
gvMoData数据结构: 表情组列
|
|---组名
|
|---存放子目录(注: 保持目录不变请填"", 要加入目录最后一定要加上"/")
|
|---表情数据列
      |
	  |---表情文件名
	  |
	  |---表情提示
*/

var gvMoData;

var giMoTabs;
var gbMoNeedHidden = false;
//表情数据库
var PicData=[
 [
	 ["默认"]
	,["pic/"]
	,[
	["s0.gif","美女"],["s1.gif","帅哥"],["s2.gif","勾引"],["s3.gif","肿么了"],["s4.gif","神马"],["s5.gif","愁人"],["s6.gif","给力"],["0.gif",""],["1.gif",""],["2.gif",""],["3.gif",""],["4.gif",""],["5.gif",""],["6.gif",""],["7.gif",""],["8.gif",""],["9.gif",""],["10.gif",""],["11.gif",""],["12.gif",""],["13.gif",""],["14.gif",""],["15.gif",""],["16.gif",""],["17.gif",""],["18.gif",""],["19.gif",""],["20.gif",""],["21.gif",""],["22.gif",""],["23.gif",""],["24.gif",""],["25.gif",""],["26.gif",""],["27.gif",""],["28.gif",""],["29.gif",""],["30.gif",""],["31.gif",""],["32.gif",""],["33.gif",""],["34.gif",""],["35.gif",""],["36.gif",""],["37.gif",""],["38.gif",""],["39.gif",""],["40.gif",""],["41.gif",""],["42.gif",""],["43.gif",""],["44.gif",""],["45.gif",""],["46.gif",""],["47.gif",""],["48.gif",""],["49.gif",""],["50.gif",""],["51.gif",""],["52.gif",""],["53.gif",""],["54.gif",""],["55.gif",""],["56.gif",""],["57.gif",""],["58.gif",""],["59.gif",""],["60.gif",""],["61.gif",""],["62.gif",""],["63.gif",""],["64.gif",""],["65.gif",""],["66.gif",""],["67.gif",""],["68.gif",""],["69.gif",""],["70.gif",""],["71.gif",""],["72.gif",""],["73.gif",""],["74.gif",""],["75.gif",""],["76.gif",""],["77.gif",""],["78.gif",""],["79.gif",""],["80.gif",""],["81.gif",""],["82.gif",""],["83.gif",""],["84.gif",""],["85.gif",""],["86.gif",""],["87.gif",""],["88.gif",""],["89.gif",""],["90.gif",""],["91.gif",""],["92.gif",""],["93.gif",""],["94.gif",""],["95.gif",""],["96.gif",""],["97.gif",""],["98.gif",""],["99.gif",""],["100.gif",""],["101.gif",""],["102.gif",""],["103.gif",""],["104.gif",""]
	 ]
 ]
,[
	 ["小猴子"]
	,["pic/hz/"]
	,[
		[ "100.gif",""],[ "101.gif",""],[ "102.gif",""],[ "103.gif",""],[ "104.gif",""],[ "105.gif",""],[ "106.gif",""],[ "107.gif",""],[ "108.gif",""],[ "109.gif",""],[ "110.gif",""],[ "111.gif",""],[ "112.gif",""],[ "113.gif",""],[ "114.gif",""],[ "115.gif",""],[ "116.gif",""],[ "117.gif",""],[ "118.gif",""],[ "119.gif",""],["120.gif",""],[ "121.gif",""],[ "122.gif",""],[ "123.gif",""],[ "124.gif",""],[ "125.gif",""],[ "126.gif",""],[ "127.gif",""],[ "128.gif",""],[ "129.gif",""],[ "130.gif",""],[ "131.gif",""],[ "132.gif",""],[ "133.gif",""],[ "134.gif",""],[ "135.gif",""],[ "136.gif",""],[ "137.gif",""],[ "138.gif",""],[ "139.gif",""],[ "140.gif",""],[ "141.gif",""]
	 ]
 ]
];

function Gel(id, obj) {
	obj = (obj == null ? document : obj);
	return obj.getElementById(id);
}

function moCalcCurPages() {
	var iDLen = gvMoData[giMoCurTab][2].length;
	var iPLen = giMoRowNum * giMoColNum;
	var fv = iDLen / iPLen;
	if (iDLen % iPLen == 0) {
		return fv == 0 ? 1 : parseInt(fv);
	}
	else {
		return Math.round(fv + 0.5);
	}
}

function moJustifyImg(oImg, iWidth, iHeight, bPos) {
	var oNewImg = new Image();
	oNewImg.src = oImg.src;
	
	var w = oNewImg.width;
	var h = oNewImg.height;
	var wb = w / iWidth;
	var hb = h / iHeight;

	if (wb > 1 || hb > 1) {
		//等比例缩少
		if (wb > hb) {
			oImg.width = iWidth;
			oImg.height = h * iHeight / w;
		}
		else {
			oImg.width = w * iWidth / h;
			oImg.height = iHeight;
		}
		h = oImg.height;
	}
	else {
		oImg.width = w;
		oImg.height = h;
	}

	if (bPos) {
		oImg.style.top = ((iHeight - h) / 2) + "px";
	}

	return;
}

function moHidePanel() {
	try{
		if (gbMoNeedHidden)
		{
			Gel("moShowPanel").style.display = "none";
		}
	}catch(e){}
}

function moShow(sUrl, iOffset) {
	var obj = Gel("moShowPanel");
	if (sUrl == null || sUrl == "") {
		gbMoNeedHidden = true;
		//采用时间来延时消失以判断是否需要消失,通过此来消除不必要的闪烁
		setTimeout("moHidePanel()", 200);
	}
	else {
		gbMoNeedHidden = false;
		var div = Gel("moDivContainer");
		obj.style.top = parseInt(div.offsetTop) + "px";
		if (iOffset < giMoColNum / 2) {
			obj.style.left = (parseInt(div.offsetLeft) + parseInt(div.offsetWidth) - giMoShowWidth) + "px";
		}
		else {
			obj.style.left = div.offsetLeft + "px";
		}
		obj.innerHTML = "<img src='" + sUrl + "' width=" + giMoShowWidth + " height=" + giMoShowHeight + " onload='moJustifyImg(this, " + giMoShowWidth + "," + giMoShowHeight + ", true);this.style.zIndex = 1;' style='position:relative;'></img>";
		obj.style.display = "";
	}
}

function moOver(obj, iOffset) {
	obj.style.border='1px solid #000080';
	obj.style.background='#ffeec2';
	moShow(obj.childNodes[0].childNodes[0].src, iOffset);
}

function moOut(obj) {
	obj.style.border='1px solid #F6F6F6';
	obj.style.background='#F6F6F6';
	moShow();
}

function moGetPageText() {
	return (giMoCurPage + 1) + "/" + moCalcCurPages();
}

function moRefreshData() {
	Gel("moTabContainer").innerHTML = moTab();
	Gel("moDivContainer").innerHTML = moTable();
	Gel("moPageText").innerHTML = moGetPageText();
}

function moChangeTab(iTab) {
	if (iTab >= giMoTabs && iTab != giMoCurTab) {
		return;
	}
	giMoCurPage = 0;
	giMoCurTab = iTab;
	moRefreshData();
}

function moNextPage() {
	if (giMoCurPage + 1 >= moCalcCurPages()) {
		return ;
	}
	giMoCurPage += 1;
	moRefreshData();
}

function moPrevPage() {
	if (giMoCurPage <= 0) {
		return ;
	}
	giMoCurPage -= 1;
	moRefreshData();
}

function moCell(iCurTab, iCurPage, iNum, iOffset) {
	iNum = iCurPage * giMoRowNum * giMoColNum + iNum;
	var data = gvMoData[iCurTab][2];
	if (iNum >= data.length) {
		return "";
	}
	var sSrc = gvMoData[iCurTab][1] + data[iNum][0];
	return "<img data='" + sSrc + "' src='"+ giMoBaseUrl + sSrc + "' title='" + data[iNum][1] + "' width=" + giMoCellWidth + " height=" + giMoCellHeight + " onload='moJustifyImg(this, " + giMoCellWidth + "," + giMoCellHeight + ", true);' style='position:relative;'></img>";
}

function moTable() {
	var pdivh = "<div style='width:" + giMoCellWidth + "px;height:" + giMoCellHeight + "px;'>";
	var code = "<table cellpadding=0 cellspacing=1 bgcolor=#DFE6F6>";
	for (var i = 0; i < giMoRowNum; i++) {
		code += "<tr>";
		for (var j = 0; j < giMoColNum; j++) {
			var cell = moCell(giMoCurTab, giMoCurPage, i * giMoColNum + j, j);
			code += "<td align=center valign=middle width=" + (giMoCellWidth+2) + "px height=" + (giMoCellHeight+2) + "px style='background:#f6f6f6;padding:1px;border:1px solid #F6F6F6;' " + (cell != "" ? "onmouseover='moOver(this, " + j + ");' onmouseout='moOut(this);'>" + pdivh + cell : ">" + pdivh) + "</div></td>";
		}
		code += "</tr>";
	}
	return code + "</table>";
}

function moTab() {
	var code = "";
	for (var i = 0; i < giMoTabs; i++) {
		code += "<span style='color:" + (giMoCurTab == i ? "#000;border:1px solid #DFE6F6;font-weight:bold;border-bottom:1px solid #f6f6f6;border-top:2px solid #FFC83C" : "#000" ) + ";padding:3px 7px 2px 7px;cursor:pointer;' onclick='moChangeTab(" + i + ")'>" + gvMoData[i][0] + "</span>";
	}
	return code;
}

function moBtnMouse(obj, down) {
	var s = obj.style;
	s.position = "relative";
	s.top = down ? "1px" : "0px";
	s.left = down ? "1px" : "0px";
}

function moCube() {
	giMoCurTab = 0;
	giMoCurPage = 0;
	gvMoData=null;
	gvMoData = PicData;
	giMoTabs = gvMoData.length;
	return "<div style='padding:10px 5px 0 5px;' onclick='SelectIMG()'><div id='moTabContainer' style='font:normal 12px Verdana;color:#000;padding:2px 6px'>" + moTab() + "</div><div id='moDivContainer'>" + moTable() + "</div><div align=right style='font-size:12px;padding:5px 0 5px 0;color:#000;'><span style='margin:0 10px 0 0;color:#000;font:normal 12px Verdana;' id='moPageText'>" + moGetPageText() + "</span><span style='cursor:pointer;margin:0 2px 0 2px;font-weight:bold;background:#eff7ff;border:1px solid #8ba8c8;color:#000;padding:2px 8px 0 8px' onclick='moPrevPage();' onmousedown='moBtnMouse(this,1);' onmouseup='moBtnMouse(this,0);' title='上一页'>&lt;</span><span style='cursor:pointer;margin:0 2px 0 2px;font-weight:bold;background:#eff7ff;border:1px solid #8ba8c8;color:#000;padding:2px 8px 0 8px' onclick='moNextPage();' onmousedown='moBtnMouse(this,1);' onmouseup='moBtnMouse(this,0);' title='下一页'>&gt;</span></div><div id='moShowPanel' style='background:#fff;position:absolute;left:0;top:0;border:1px solid #004B97;width:" + giMoShowWidth + "px;height:" + giMoShowHeight + "px;text-align:center;display:none'></div></div>";
}

function SelectIMG(){
var e=getEvent();
var isIE=document.all;
if(isIE) var el = e.srcElement;
else var el = e.target; 
var t=el;	
if( t.tagName == "TD")	{
t = el.getElementsByTagName("IMG")[0];
}
if (t.tagName == "IMG" && t.attributes["data"] != null)
{
	InsertIMG('face/'+t.attributes["data"].nodeValue);
	getId('Smileys').style.display='none';
}
}
