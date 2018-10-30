<?php
$z[0]=Array("field","",30,60);
$z[0][4]['name']="sortrand";
$z[1]=Array("arclist","\r\n              <li class=\"first-posts\"><a href=\"[field:arcurl/]\"class=\"post-thumbnail\"title=\"[field:title/]\"rel=\"bookmark\"><img src=\"[field:picname/]\"alt=\"[field:title/]\"style=\"height:120px; width:180px\"/></a>\r\n                <h3><a href=\"[field:arcurl/]\"title=\"[field:title/]\"rel=\"bookmark\">[field:title/]</a></h3>\r\n                <p class=\"summary\"> [field:description function=\"cn_substr(@me,220)\"/]...</p>\r\n              </li>\r\n              ",352,865);
$z[1][4]['titlelen']="80";
$z[1][4]['row']="1";
$z[1][4]['limit']="0,1";
$z[2]=Array("arclist","\r\n              <li class=\"other-news\"><span>[field:pubdate function='strftime(\"%m-%d\",@me)'/]</span><a href=\"[field:arcurl/]\"title=\"[field:title/]\"><i class=\"icon-angle-right\"></i>[field:title/]</a></li>\r\n               ",925,1211);
$z[2][4]['titlelen']="80";
$z[2][4]['row']="5";
$z[2][4]['limit']="2,7";

?>