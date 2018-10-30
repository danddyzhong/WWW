<?php
$z[0]=Array("global","",430,456);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",500,530);
$z[1][4]['name']="cfg_description";
$z[2]=Array("global","",567,594);
$z[2][4]['name']="cfg_keywords";
$z[3]=Array("global","",683,710);
$z[3][4]['name']="cfg_basehost";
$z[4]=Array("include","",1628,1663);
$z[4][4]['filename']="head.htm";
$z[5]=Array("arclist","\r\n        <h2><span class=\"red\">【站长推荐】</span> <a href=\"[field:arcurl/]\" title=\"[field:title/]-{dede:global.cfg_webname/}\">[field:title/]</a></h2>\r\n        <p class=\"note\"> <a href=\"[field:arcurl/]\" title=\"点击阅读（[field:title/]）\">[field:description function='cn_substr(@me,200)'/]...</a></p>\r\n        ",1832,2215);
$z[5][4]['row']="1";
$z[5][4]['titlelen']="50";
$z[5][4]['flag']="h";
$z[6]=Array("arclist","\r\n            <li><a href=\"[field:arcurl/]\" title=\"[field:title/]-{dede:global.cfg_webname/}\">[field:title/]</a></li>\r\n            ",2279,2471);
$z[6][4]['row']="5";
$z[6][4]['titlelen']="46";
$z[6][4]['flag']="c";
$z[7]=Array("arclist","\r\n      <article class=\"excerpt\"> <a class=\"focus\" href=\"[field:arcurl/]\"><img src=\"[field:litpic/]\" alt=\"[field:title/]\"/></a>\r\n        <header><a href=\"[field:typeurl/]\" class=\"cat\" title=\"[field:typename/]\">[field:typename/]</a>\r\n          <h2><a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:title/]</a></h2>\r\n        </header>\r\n        <p class=\"meta\">\r\n          <time>[field:pubdate function=\"MyDate('Y-m-d',@me)\"/]</time>\r\n          <span class=\"pv\">阅读([field:click/])</span> </p>\r\n        <p class=\"note pc\"> <a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:description function='cn_substr(@me,200)'/]...</a></p>\r\n      </article>\r\n      ",2530,3245);
$z[7][4]['row']="10";
$z[7][4]['titlelen']="42";
$z[8]=Array("tag","\r\n          <li><a href=\"[field:link/]\" title=\"[field:tag /]\">[field:tag /]</a></li>\r\n          ",3307,3444);
$z[8][4]['row']="50";
$z[8][4]['getall']="0";
$z[9]=Array("sql"," \r\n          \r\n          [field:content  function='cn_substr(html2text(@me),300)'/]...\r\n          \r\n          ",3657,3839);
$z[9][4]['sql']="Select content from dede_arctype where id=48";
$z[10]=Array("arclist","\r\n          <li><a href=\"[field:arcurl/]\">[field:title/]</a></li>\r\n          ",4018,4144);
$z[10][4]['titlelen']="42";
$z[10][4]['row']="10";
$z[11]=Array("flinktype","\r\n          {dede:flink/}\r\n          \r\n          ",4306,4389);
$z[12]=Array("include","",4456,4493);
$z[12][4]['filename']="footer.htm";

?>