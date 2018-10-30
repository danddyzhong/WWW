<?php
$z[0]=Array("global","",110,136);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("field","(@me=='')? @me='current':@me='';",1050,1132);
$z[1][4]['name']="typeid";
$z[1][4]['runphp']="yes";
$z[2]=Array("channelartlist","\r\n          <li class=\"common {dede:field.currentstyle/}\"><a href=\"{dede:field name='typeurl'/}\" >{dede:field name='typename'/}</a>\r\n            <ul {dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-nav\"':'style=\"display:none\"';\r\n{/dede:field}>\r\n            {dede:channel type='son'}\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n            {/dede:channel}  \r\n            </ul>\r\n          </li>\r\n          ",1175,1871);
$z[2][4]['typeid']="12,18,14,15";
$z[2][4]['currentstyle']="current";
$z[3]=Array("global","",2095,2120);
$z[3][4]['name']="cfg_cmsurl";

?>