<?php
$z[0]=Array("global","",403,435);
$z[0][4]['name']="cfg_templets_skin";
$z[1]=Array("global","",560,586);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("global","",599,625);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("global","",669,699);
$z[3][4]['name']="cfg_description";
$z[4]=Array("global","",736,763);
$z[4][4]['name']="cfg_keywords";
$z[5]=Array("global","",805,837);
$z[5][4]['name']="cfg_templets_skin";
$z[6]=Array("global","",904,936);
$z[6][4]['name']="cfg_templets_skin";
$z[7]=Array("global","",1003,1035);
$z[7][4]['name']="cfg_templets_skin";
$z[8]=Array("global","",1100,1132);
$z[8][4]['name']="cfg_templets_skin";
$z[9]=Array("include","",1202,1237);
$z[9][4]['filename']="head.htm";
$z[10]=Array("arclist","\r\n        <li> <a href=\"[field:arcurl/]\" rel=\"bookmark\"> <img src=\"[field:id runphp=yes]  \r\n    global \$dsql;\r\n    \$id = @me;\r\n    \$sql='select slider_img from #@__archives where id='.\$id;\r\n    \$row=\$dsql->getone(\$sql);\r\n    @me=\$row['slider_img'];\r\n [/field:id]\" alt=\"[field:title/]\" /></a> </li>\r\n        ",1489,1856);
$z[10][4]['titlelen']="80";
$z[10][4]['flag']="f";
$z[10][4]['row']="5";
$z[11]=Array("arclist","\r\n      <div class=\"xl4 xm4\">\r\n          <div class=\"picture-h\">\r\n            <figure class=\"picture-h-img\"> <a href=\"[field:arcurl/]\"> <img src=\"[field:picname/]\" alt=\"[field:title/]\" /></a> </figure>\r\n            <h3 class=\"picture-h-title\"> <a href=\"[field:arcurl/]\" rel=\"bookmark\" title=\"[field:title/]\">[field:title/]</a></h3>\r\n          </div>\r\n        </div>\r\n      ",1957,2399);
$z[11][4]['titlelen']="80";
$z[11][4]['orderby']="pubdate";
$z[11][4]['row']="28";
$z[12]=Array("arclist","\r\n         <li>\r\n            <figure class=\"thumbnail\"> <a href=\"[field:arcurl/]\"><img src=\"[field:picname/]\" alt=\"[field:title/]\" /></a> </figure>\r\n            <div class=\"hot-title\"><a href=\"[field:arcurl/]\" rel=\"bookmark\">[field:title/]</a></div>\r\n          </li>\r\n          ",2726,3064);
$z[12][4]['titlelen']="80";
$z[12][4]['flag']="a";
$z[12][4]['row']="5";
$z[13]=Array("arclist","\r\n        <li><span class='li-icon li-icon-1'>1</span><a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:title/]</a></li>\r\n        ",3601,3803);
$z[13][4]['titlelen']="80";
$z[13][4]['orderby']="click";
$z[13][4]['row']="8";
$z[14]=Array("channelartlist","\r\n  <div class=\"xl3 xm3\">\r\n      <div class=\"cat-box\">\r\n        <h3 class=\"cat-title\"> <a href=\"{dede:field name='typelink'/}\" title=\"{dede:field name='typename'/}\">&nbsp;&nbsp;&nbsp;&nbsp;{dede:field name='typename'/}</a></h3>\r\n        <div class=\"clear\"></div>\r\n        <div class=\"cat-site\">\r\n          {dede:arclist row='1' titlelen='80' limit='1,1' orderby='click'}\r\n        <h2 class=\"entry-title\"><a href=\"[field:arcurl/]\" rel=\"bookmark\" title=\"[field:title/]\">[field:title/]</a></h2>\r\n          <figure class=\"thumbnail\"> <a href=\"[field:arcurl/]\"><img src=\"[field:picname/]\"  alt=\"[field:title/]\" /></a> </figure>\r\n          <div class=\"cat-main\">[field:description function=\"cn_substr(@me,220)\"/]...</div>\r\n        {/dede:arclist}\r\n  \r\n          <div class=\"clear\"></div>\r\n          <ul class=\"cat-list\">\r\n          {dede:arclist row='1' titlelen='80' limit='2,3' orderby='click'}\r\n          <span class=\"list-date\">[field:pubdate function='strftime(\"%m-%d\",@me)'/]</span>\r\n          <li class=\"list-title\"><a href=\"[field:arcurl/]\" rel=\"bookmark\" title=\"[field:title/]\">[field:title/]</a></li>\r\n          {/dede:arclist}\r\n          </ul>\r\n        </div>\r\n      </div>\r\n    </div>\r\n",4019,5268);
$z[14][4]['typeid']="top";
$z[15]=Array("include","",5423,5458);
$z[15][4]['filename']="foot.htm";

?>