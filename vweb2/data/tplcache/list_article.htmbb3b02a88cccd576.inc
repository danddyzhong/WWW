<?php
$z[0]=Array("field","",254,273);
$z[0][4]['name']="title";
$z[1]=Array("global","",276,302);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("global","",343,370);
$z[2][4]['name']="cfg_keywords";
$z[3]=Array("field","",408,466);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("global","",499,531);
$z[4][4]['name']="cfg_templets_skin";
$z[5]=Array("global","",587,619);
$z[5][4]['name']="cfg_templets_skin";
$z[6]=Array("global","",779,811);
$z[6][4]['name']="cfg_templets_skin";
$z[7]=Array("global","",889,921);
$z[7][4]['name']="cfg_templets_skin";
$z[8]=Array("global","",998,1030);
$z[8][4]['name']="cfg_templets_skin";
$z[9]=Array("global","",1140,1172);
$z[9][4]['name']="cfg_templets_skin";
$z[10]=Array("global","",1238,1270);
$z[10][4]['name']="cfg_templets_skin";
$z[11]=Array("global","",1360,1392);
$z[11][4]['name']="cfg_templets_skin";
$z[12]=Array("include","",2111,2146);
$z[12][4]['filename']="head.htm";
$z[13]=Array("field","",2237,2266);
$z[13][4]['name']="typename";
$z[14]=Array("field","",2286,2344);
$z[14][4]['name']="description";
$z[14][4]['function']="html2text(@me)";
$z[15]=Array("field","",2403,2432);
$z[15][4]['name']="position";
$z[16]=Array("list","      \r\n        <div class=\"m_Grid2\">\r\n        	<div class=\"m_T2\">\r\n\r\n            	<p class=\"p4\"><a href=\"[field:arcurl/]\"><b>[field:title/]</b></a></p>\r\n                <p class=\"p5\">\r\n                	<span class=\"c4\">[field:typelink/]</span>\r\n                    <span class=\"c5\">[field:pubdate function=strftime('%Y.%m.%d',@me)/]</span>\r\n                    <span class=\"c6\">[field:click/]次浏览</span>\r\n                </p>\r\n            </div>\r\n            <div class=\"m_Box1\">\r\n            	<a href=\"[field:arcurl/]\"><img src=\"[field:litpic/]\" alt=\"[field:title/]\" height=\"100\" width=\"150\" /></a>\r\n		[field:description/]...\r\n            </div>\r\n            <div class=\"d1\">\r\n            	<span class=\"c7\">作者：[field:writer /]</span>\r\n                <span class=\"c8\">标签：[field:id function=GetTags(@me)/]</span>\r\n				<div class=\"c9\"><a title=\"[field:title function='htmlspecialchars(@me)'/]\" href=\"[field:arcurl/]\">阅读全文</a></div>\r\n            </div>\r\n            </div>",2457,3523);
$z[16][4]['pagesize']="10";
$z[16][4]['titlelen']="42";
$z[16][4]['orderby']="sortrank";
$z[17]=Array("pagelist","",3569,3642);
$z[17][4]['listitem']="index,end,pre,next,pageno,option";
$z[17][4]['listsize']="4";
$z[18]=Array("global","",3979,4011);
$z[18][4]['name']="cfg_templets_skin";
$z[19]=Array("global","",4140,4172);
$z[19][4]['name']="cfg_templets_skin";
$z[20]=Array("global","",4590,4622);
$z[20][4]['name']="cfg_templets_skin";
$z[21]=Array("global","",4716,4748);
$z[21][4]['name']="cfg_templets_skin";
$z[22]=Array("arclist","\r\n<a title=\"[field:title function='htmlspecialchars(@me)'/]\" href=\"[field:arcurl /]\">[field:title /]</a>\r\n",4883,5069);
$z[22][4]['orderby']="click";
$z[22][4]['titlelen']="40";
$z[22][4]['row']="9";
$z[22][4]['subday']="90";
$z[23]=Array("arclist","\r\n       		<a href=\"[field:arcurl/]\"><img src=\"[field:litpic/]\"  alt=\"[field:title /]\" width=\"300\" height=\"200\" /></a>	\r\n",5241,5442);
$z[23][4]['orderby']="rand";
$z[23][4]['titlelen']="40";
$z[23][4]['row']="3";
$z[23][4]['type']="image.";
$z[24]=Array("arclist","\r\n<li><a title=\"[field:title function='htmlspecialchars(@me)'/]\" href=\"[field:arcurl /]\">[field:title /]</a></li>\r\n",5654,5838);
$z[24][4]['orderby']="pubdate";
$z[24][4]['titlelen']="40";
$z[24][4]['row']="8";
$z[25]=Array("global","",6130,6162);
$z[25][4]['name']="cfg_templets_skin";
$z[26]=Array("global","",6312,6344);
$z[26][4]['name']="cfg_templets_skin";
$z[27]=Array("global","",6476,6508);
$z[27][4]['name']="cfg_templets_skin";
$z[28]=Array("include","",6668,6705);
$z[28][4]['filename']="footer.htm";

?>