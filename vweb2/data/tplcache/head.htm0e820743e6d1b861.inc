<?php
$z[0]=Array("global","",315,341);
$z[0][4]['name']="cfg_webname";
$z[1]=Array("channelartlist","\r\n      <li id=\"menu-item-1106\" class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1106\"><a href=\"{dede:field name='typeurl'/}\">{dede:field name='typename'/}</a>\r\n        <ul class='{dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field}'>\r\n          {dede:channel type='son'}\r\n          <li id=\"menu-item-1147\" class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1147\"><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n          {/dede:channel}\r\n        </ul>\r\n      </li>\r\n      ",405,1272);
$z[1][4]['typeid']="12,18,14,15";
$z[1][4]['currentstyle']="current-menu-item";
$z[2]=Array("global","",1644,1670);
$z[2][4]['name']="cfg_webname";
$z[3]=Array("global","",1679,1705);
$z[3][4]['name']="cfg_webname";
$z[4]=Array("global","",1729,1761);
$z[4][4]['name']="cfg_templets_skin";
$z[5]=Array("global","",3684,3710);
$z[5][4]['name']="cfg_webname";
$z[6]=Array("channelartlist","\r\n          <li class=\"menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-1106\"><a href=\"{dede:field name='typeurl'/}\">{dede:field name='typename'/}</a>\r\n            <ul class='{dede:field name=typeid runphp=\"yes\"}\r\nglobal \$dsql;\r\n\$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n\$row = \$dsql->GetOne(\$sql);\r\n@me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n{/dede:field}'>\r\n              {dede:channel type='son'}\r\n              <li class=\"menu-item menu-item-type-taxonomy menu-item-object-category menu-item-1147\"><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n              {/dede:channel}\r\n            </ul>\r\n          </li>\r\n          ",3775,4634);
$z[6][4]['typeid']="12,18,14,15";
$z[6][4]['currentstyle']="current-menu-item";

?>