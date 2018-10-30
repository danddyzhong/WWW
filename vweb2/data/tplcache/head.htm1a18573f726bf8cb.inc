<?php
$z[0]=Array("global","",111,137);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",240,265);
$z[1][4]['name']="cfg_cmsurl";
$z[2]=Array("global","",686,712);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("field","(@me=='')? @me='current':@me='';",1636,1718);
$z[3][4]['name']="typeid";
$z[3][4]['runphp']="yes";
$z[4]=Array("channelartlist","\r\n          <li class=\"common {dede:field.currentstyle/}\"><a href=\"{dede:field name='typeurl'/}\" >{dede:field name='typename'/}</a>\r\n            <ul {dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-nav\"':'style=\"display:none\"';\r\n{/dede:field}>\r\n            {dede:channel type='son'}\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n            {/dede:channel}  \r\n            </ul>\r\n          </li>\r\n          ",1761,2457);
$z[4][4]['typeid']="12,18,14,15";
$z[4][4]['currentstyle']="current";

?>