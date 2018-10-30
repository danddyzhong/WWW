<?php
$z[0]=Array("global","",183,209);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",254,281);
$z[1][4]['name']="cfg_keywords";
$z[2]=Array("global","",325,355);
$z[2][4]['name']="cfg_description";
$z[3]=Array("global","",780,812);
$z[3][4]['name']="cfg_templets_skin";
$z[4]=Array("include","",1365,1400);
$z[4][4]['filename']="head.htm";
$z[5]=Array("arclist","\r\n<div class=\"feed_tegao long\" data-href=\"[field:typeurl/]\">\r\n    <h4>\r\n        <a href=\"[field:typeurl/]\"\r\n           target=\"_blank\">[field:title/]</a>\r\n    </h4>\r\n    <p class=\"picture\"><a href=\"[field:arcurl/]\" target=\"_blank\"><img src=\"[field:picname/]\" alt=\"[field:title/]\"/></a></p>\r\n    <p class=\"summary\">[field:description function='cn_substr(@me,220)'/]<a href=\"[field:arcurl/]\" class=\"more\" target=\"_blank\">[详情]</a></p>\r\n    <div class=\"infos\">\r\n        <span class=\"time\">[field:pubdate function='strftime(\"%m月%d日\",@me)'/]</span>\r\n    </div>\r\n</div>\r\n",1479,2107);
$z[5][4]['row']="10";
$z[5][4]['orderby']="pubdate";
$z[6]=Array("arclist","\r\n			<li>\r\n                    <span class=\"num top3\">[field:global.autoindex/]</span>\r\n                    <a href=\"[field:arcur/]\" title=\"[field:title/]\">[field:title/]</a>\r\n                    <span class=\"tm\">[field:pubdate function='strftime(\"%m-%d\",@me)'/]</span>\r\n                </li>\r\n",2627,2959);
$z[6][4]['row']="10";
$z[7]=Array("arclist","\r\n			<li>\r\n                    <span class=\"num top3\">[field:global.autoindex/]</span>\r\n                    <a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:title/]</a>\r\n                    <span class=\"tm\">[field:pubdate function='strftime(\"%m月%d日\",@me)'/]</span>\r\n                </li>\r\n            ",3252,3619);
$z[7][4]['row']="10";
$z[7][4]['orderby']="click";
$z[8]=Array("include","",3692,3727);
$z[8][4]['filename']="foot.htm";

?>