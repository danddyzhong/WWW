<?php
$z[0]=Array("field","",11,37);
$z[0][4]['name']="currentstyle";
$z[1]=Array("global","",46,70);
$z[1][4]['name']="itemindex";
$z[2]=Array("field","",78,106);
$z[2][4]['name']="typeurl";
$z[3]=Array("global","",143,167);
$z[3][4]['name']="itemindex";
$z[4]=Array("field","",173,202);
$z[4][4]['name']="typename";
$z[5]=Array("field","\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n",222,490);
$z[5][4]['name']="typeid";
$z[5][4]['runphp']="yes";
$z[6]=Array("channel"," >\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n              ",508,639);
$z[6][4]['type']="son";

?>