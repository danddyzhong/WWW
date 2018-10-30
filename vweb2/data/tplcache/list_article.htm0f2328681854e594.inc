<?php
$z[0]=Array("field","",430,449);
$z[0][4]['name']="title";
$z[1]=Array("global","",450,476);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","",517,546);
$z[2][4]['name']="keywords";
$z[3]=Array("field","",586,644);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("type","[field:typelink/]",761,818);
$z[4][4]['typeid']="0";
$z[4][4]['row']="1";
$z[5]=Array("include","",1653,1688);
$z[5][4]['filename']="head.htm";
$z[6]=Array("field","",1859,1879);
$z[6][4]['name']="title";
$z[7]=Array("field","",1930,1988);
$z[7][4]['name']="description";
$z[7][4]['function']="html2text(@me)";
$z[8]=Array("list","\r\n      <article class=\"excerpt\"> <a class=\"focus\" href=\"[field:arcurl/]\"><img src=\"[field:litpic/]\" alt=\"[field:title/]\"/></a>\r\n        <header><a href=\"[field:typeurl/]\" class=\"cat\" title=\"[field:typename/]\">[field:typename/]</a>\r\n          <h2><a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:title/]</a></h2>\r\n        </header>\r\n        <p class=\"meta\">\r\n          <time>[field:pubdate function=\"MyDate('Y-m-d',@me)\"/]</time>\r\n        </p>\r\n        <p class=\"note pc\"> <a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:description function='cn_substr(@me,250)'/]...</a></p>\r\n      </article>\r\n      ",2019,2672);
$z[8][4]['pagesize']="10";
$z[9]=Array("pagelist","",2730,2801);
$z[9][4]['listitem']="info,index,end,pre,next,pageno";
$z[9][4]['listsize']="1";
$z[10]=Array("tag","\r\n          <li><a href=\"[field:link/]\" title=\"[field:tag /]\">[field:tag /]</a></li>\r\n          ",2892,3029);
$z[10][4]['row']="50";
$z[10][4]['getall']="0";
$z[11]=Array("sql"," \r\n          \r\n          [field:content  function='cn_substr(html2text(@me),300)'/]...\r\n          \r\n          ",3242,3424);
$z[11][4]['sql']="Select content from dede_arctype where id=48";
$z[12]=Array("arclist","\r\n          <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n          ",3603,3729);
$z[12][4]['titlelen']="60";
$z[12][4]['row']="10";
$z[13]=Array("include","",3794,3831);
$z[13][4]['filename']="footer.htm";

?>