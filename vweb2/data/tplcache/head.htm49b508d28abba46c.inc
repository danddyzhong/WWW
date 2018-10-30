<?php
$z[0]=Array("global","",204,230);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",244,270);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","(@me=='')? @me='current-menu-item':@me='';",1065,1157);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";
$z[3]=Array("global","",1195,1221);
$z[3][4]['name']="cfg_webname";
$z[4]=Array("channelartlist","\r\n        <li class=\"{dede:field.currentstyle/}\"><a id=\"{dede:global.itemindex/}\" href=\"{dede:field name='typeurl'/}\"> <i class=\"icon-fixed-width icon-00{dede:global.itemindex/}\"></i>{dede:field name='typename'/}</a>\r\n          <ul {dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field} >\r\n              {dede:channel type='son'} >\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n              {/dede:channel}\r\n          </ul>\r\n        </li>\r\n        ",1306,2095);
$z[4][4]['typeid']="12,18,14,15";
$z[4][4]['currentstyle']="current-menu-item";

?>