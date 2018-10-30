<?php
$z[0]=Array("field","(@me=='')? @me='active':@me='';",207,288);
$z[0][4]['name']="typeid";
$z[0][4]['runphp']="yes";
$z[1]=Array("channelartlist","\r\n                <li class=\"\"><a href=\"{dede:field name='typeurl'/}\" class='{dede:field.currentstyle/}'>{dede:field name='typename'/}</a>\r\n\r\n                  <ul class='{dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field}'>\r\n                    {dede:channel type='son'}\r\n                    <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n                    {/dede:channel} \r\n                  </ul>\r\n                </li>\r\n                ",339,1097);
$z[1][4]['typeid']="12,18,14,15";
$z[1][4]['currentstyle']="active";
$z[2]=Array("global","",1467,1499);
$z[2][4]['name']="cfg_templets_skin";
$z[3]=Array("field","(@me=='')? @me='active':@me='';",1633,1714);
$z[3][4]['name']="typeid";
$z[3][4]['runphp']="yes";
$z[4]=Array("channelartlist","\r\n                <li class=\"{dede:field.currentstyle/}\"><a href=\"{dede:field name='typeurl'/}\">{dede:field name='typename'/}</a>\r\n\r\n                  <ul class='{dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field}'>\r\n                    {dede:channel type='son'}\r\n                    <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n                    {/dede:channel} \r\n                  </ul>\r\n                </li>\r\n                ",1776,2525);
$z[4][4]['typeid']="12,18,14,15";
$z[4][4]['currentstyle']="active";

?>