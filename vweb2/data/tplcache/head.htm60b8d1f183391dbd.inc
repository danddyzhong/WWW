<?php
$z[0]=Array("global","",145,171);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("field","(@me=='')? @me='current-menu-parent a':@me='';",393,489);
$z[1][4]['name']="typeid";
$z[1][4]['runphp']="yes";
$z[2]=Array("global","",511,537);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("channelartlist","\r\n      <li class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu {dede:field.currentstyle/}\"><a  id=\"[field:global.autoindex/]\"  href=\"{dede:field name='typeurl'/}\" >{dede:field name='typename'/}</a>\r\n        <ul {dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field} >\r\n              {dede:channel type='son'}>\r\n          <li class=\"menu-item menu-item-type-taxonomy menu-item-object-category\"><a href=\"[field:typeurl/]\">[field:typename/]</a> </li>\r\n        </ul>\r\n      </li>\r\n      ",566,1409);
$z[3][4]['typeid']="12,18,14,15";
$z[3][4]['currentstyle']="current-menu-parent a";

?>