<?php
$z[0]=Array("global","",117,149);
$z[0][4]['name']="cfg_templets_skin";
$z[1]=Array("channelartlist","\r\n  <li><a href=\"{dede:field name='typeurl'/}\">{dede:field name='typename'/}</a>\r\n  	<ul class='{dede:field name=typeid runphp=\"yes\"}\r\n  global \$dsql;\r\n  \$sql = \"SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 \";\r\n  \$row = \$dsql->GetOne(\$sql);\r\n  @me=is_array(\$row)?'class=\"sub-menu\"':'style=\"display:none\"';\r\n  {/dede:field}'>\r\n  {dede:channel type='son'}\r\n  <li class=\"menu-item \"><a href=\"[field:typeurl/]\">[field:typename/]</a></li>\r\n  {/dede:channel} \r\n  </ul>\r\n  </li>\r\n",1076,1699);
$z[1][4]['typeid']="12,18,14,15";
$z[1][4]['currentstyle']="current-menu-item";

?>