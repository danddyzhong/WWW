<?php
$z[0]=Array("field","",406,425);
$z[0][4]['name']="title";
$z[1]=Array("global","",426,452);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","",493,522);
$z[2][4]['name']="keywords";
$z[3]=Array("field","",562,620);
$z[3][4]['name']="description";
$z[3][4]['function']="html2text(@me)";
$z[4]=Array("include","",1211,1246);
$z[4][4]['filename']="head.htm";
$z[5]=Array("field","",1326,1348);
$z[5][4]['name']="position";
$z[6]=Array("arclist","<h2><span>置顶推荐</span> <a href=\"[field:arcurl/]\" title=\"[field:title/]\">[field:title/]</a></h2>",1470,1632);
$z[6][4]['row']="5";
$z[6][4]['titlelen']="60";
$z[6][4]['flag']="c";
$z[7]=Array("list","\r\n    <article class=\"post cate1 auth1\">\r\n      <div class=\"thumb\"> <a href=\"[field:arcurl/]\" title=\"[field:title/]\" target=\"_blank\"> <img alt=\"[field:title/]\" src=\"[field:litpic/]\"/> </a> </div>\r\n      <span class=\"post-cat\"><a href=\"[field:typeurl/]\" title=\"[field:typename/]\" target=\"_blank\">[field:typename/]</a></span>\r\n      <h2><a href=\"[field:arcurl/]\" title=\"[field:title/]\" target=\"_blank\">[field:title/]</a></h2>\r\n      <div class=\"entry loop-entry\">\r\n        <p>[field:description function='cn_substr(@me,250)'/]...</p>\r\n      </div>\r\n      <div class=\"postmeta\"> <span><i class=\"icon-calendar\"></i> 日期：[field:pubdate function='strftime(\"%Y-%m-%d\",@me)'/]</span> <span><i class=\"icon-fire\"></i> 浏览：<script src=\"/plus/count.php?view=yes&aid=[field:id/]&mid=[field:mid/]\" type='text/javascript' language=\"javascript\"></script>次</span></div>\r\n    </article>\r\n    ",1656,2592);
$z[7][4]['pagesize']="8";
$z[7][4]['titlelen']="50";
$z[8]=Array("pagelist","",2641,2707);
$z[8][4]['listitem']="index,end,pre,next,pageno";
$z[8][4]['listsize']="3";
$z[9]=Array("include","",2747,2783);
$z[9][4]['filename']="right.htm";
$z[10]=Array("include","",2793,2828);
$z[10][4]['filename']="foot.htm";

?>