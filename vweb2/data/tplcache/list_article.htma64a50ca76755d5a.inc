<?php
$z[0]=Array("field","",254,273);
$z[0][4]['name']="title";
$z[1]=Array("global","",274,300);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","",341,370);
$z[2][4]['name']="keywords";
$z[3]=Array("field","",410,468);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("global","",532,560);
$z[4][4]['name']="cfg_mobileurl";
$z[5]=Array("field","",574,590);
$z[5][4]['name']="id";
$z[6]=Array("global","",1059,1087);
$z[6][4]['name']="cfg_mobileurl";
$z[7]=Array("field","",1101,1117);
$z[7][4]['name']="id";
$z[8]=Array("global","",1224,1249);
$z[8][4]['name']="cfg_cmsurl";
$z[9]=Array("global","",1325,1350);
$z[9][4]['name']="cfg_cmsurl";
$z[10]=Array("global","",1424,1449);
$z[10][4]['name']="cfg_cmsurl";
$z[11]=Array("global","",1511,1536);
$z[11][4]['name']="cfg_cmsurl";
$z[12]=Array("global","",1622,1647);
$z[12][4]['name']="cfg_cmsurl";
$z[13]=Array("include","",1723,1758);
$z[13][4]['filename']="head.htm";
$z[14]=Array("field","",1801,1830);
$z[14][4]['name']="position";
$z[15]=Array("field","",1942,1965);
$z[15][4]['name']="typename";
$z[16]=Array("list","\r\n                <li>\r\n                    <a href=\"[field:arcurl/]\"><img src=\"[field:picname/]\" alt=\"[field:fulltitle/]\" /></a>\r\n                    <h3><a href=\"[field:arcurl/]\">[field:fulltitle/]</a></h3>\r\n                    <p>[field:description function=\"cn_substr(@me,180)\"/]...</p>\r\n                    <span>[field:pubdate function='strftime(\"%Y-%m-%d %H:%M:%S\",\"@me\")'/]</span>\r\n                </li>\r\n                ",2023,2488);
$z[16][4]['pagesize']="9";
$z[17]=Array("pagelist","",2606,2677);
$z[17][4]['listitem']="info,index,end,pre,next,pageno";
$z[17][4]['listsize']="4";
$z[18]=Array("channel","\r\n                  <li><a href='[field:typeurl/]'>[field:typename/]</a></li>\r\n                  ",2901,3149);
$z[18][4]['type']="son";
$z[18][4]['currentstyle']="<li><a href='~typelink~' class='on'>~typename~</a></li>";
$z[19]=Array("global","",3265,3290);
$z[19][4]['name']="cfg_cmsurl";
$z[20]=Array("arclist","\r\n                <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                ",3480,3617);
$z[20][4]['row']="10";
$z[20][4]['titlelen']="50";
$z[21]=Array("global","",3690,3715);
$z[21][4]['name']="cfg_cmsurl";
$z[22]=Array("arclist","\r\n                <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n                ",3901,4054);
$z[22][4]['row']="10";
$z[22][4]['titlelen']="50";
$z[22][4]['orderby']="click";
$z[23]=Array("include","",4142,4179);
$z[23][4]['filename']="footer.htm";

?>