<?php
$z[0]=Array("field","",18,44);
$z[0][4]['name']="currentstyle";
$z[1]=Array("field","",55,83);
$z[1][4]['name']="typeurl";
$z[2]=Array("field","",86,115);
$z[2][4]['name']="typename";
$z[3]=Array("field","\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-nav\"':'style=\"display:none\"';\r\n",137,404);
$z[3][4]['name']="typeid";
$z[3][4]['runphp']="yes";
$z[4]=Array("channel","\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n            ",419,546);
$z[4][4]['type']="son";

?>