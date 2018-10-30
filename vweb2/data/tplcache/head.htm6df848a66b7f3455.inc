<?php
$z[0]=Array("global","",92,118);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("global","",130,162);
$z[1][4]['name']="cfg_templets_skin";
$z[2]=Array("global","",182,208);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("field","(@me=='')? @me='current-menu-item':@me='';",279,371);
$z[3][4]['name']="typeid";
$z[3][4]['runphp']="yes";
$z[4]=Array("channelartlist","\r\n        <li  class='{dede:field.currentstyle/}'>\r\n          <a href=\"{dede:field name='typeurl'/}\">{dede:field name='typename'/}</a> \r\n          <ul class='{dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'sub-menu':'display:none';\r\n{/dede:field}' >\r\n          {dede:channel type='son'}\r\n           <li><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n           {/dede:channel}\r\n          </ul>\r\n        </li>\r\n      ",425,1104);
$z[4][4]['typeid']="top";
$z[4][4]['currentstyle']="current-menu-item";

?>