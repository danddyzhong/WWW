<?php
$z[0]=Array("field","",53,81);
$z[0][4]['name']="typeurl";
$z[1]=Array("field","",125,154);
$z[1][4]['name']="typename";
$z[2]=Array("field","\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n",174,442);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";
$z[3]=Array("channel"," >\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n              ",460,591);
$z[3][4]['type']="son";

?>