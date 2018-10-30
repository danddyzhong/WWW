<?php
$z[0]=Array("field","",22,50);
$z[0][4]['name']="typeurl";
$z[1]=Array("field","",53,82);
$z[1][4]['name']="typename";
$z[2]=Array("field","\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n",100,368);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";

?>