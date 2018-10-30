<?php
$z[0]=Array("field","",13,41);
$z[0][4]['name']="typeurl";
$z[1]=Array("field","",43,72);
$z[1][4]['name']="typename";
$z[2]=Array("field","\r\n  global \$dsql;\r\n  \$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n  \$row = \$dsql->GetOne(\$sql);\r\n  @me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n  ",92,370);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";
$z[3]=Array("channel","\r\n  <li class=\"menu-item \"><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n  ",376,500);
$z[3][4]['type']="son";

?>