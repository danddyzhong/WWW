<?php
$z[0]=Array("field","",115,143);
$z[0][4]['name']="typeurl";
$z[1]=Array("field","",145,174);
$z[1][4]['name']="typename";
$z[2]=Array("field","\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n",203,471);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";
$z[3]=Array("channel","\r\n              <li class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1147\"><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n              ",489,701);
$z[3][4]['type']="son";

?>