<?php
$z[0]=Array("global","",108,134);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",171,197);
$z[1][4]['name']="cfg_webname";
$z[2]=Array("field","(@me=='')? @me='current':@me='';",1114,1196);
$z[2][4]['name']="typeid";
$z[2][4]['runphp']="yes";
$z[3]=Array("channelartlist","\r\n          <li class=\"common {dede:field.currentstyle/}\"><a href=\"{dede:field name='typeurl'/}\" >{dede:field name='typename'/}</a>\r\n            <ul {dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-nav\"':'style=\"display:none\"';\r\n{/dede:field}>\r\n            {dede:channel type='son'}\r\n              <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n            {/dede:channel}  \r\n            </ul>\r\n          </li>\r\n          ",1239,1935);
$z[3][4]['typeid']="12,18,14,15";
$z[3][4]['currentstyle']="current";
$z[4]=Array("global","",2159,2184);
$z[4][4]['name']="cfg_cmsurl";
$z[5]=Array("hotwords","",2533,2557);
$z[5][4]['num']="8";

?>