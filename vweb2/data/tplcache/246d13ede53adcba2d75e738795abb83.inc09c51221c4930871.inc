<?php
$z[0]=Array("arcurl","",39,54);
$z[1]=Array("id","  \r\n    global \$dsql;\r\n    \$id = @me;\r\n    \$sql='select slider_img from dede_archives where id='.\$id;\r\n    \$row=\$dsql->getone(\$sql);\r\n    @me=\$row['slider_img'];\r\n ",79,275);
$z[1][4]['runphp']="yes";
$z[2]=Array("title","",282,296);
$z[3]=Array("title","",359,402);
$z[3][4]['function']="cn_substr(@me,50)";
$z[4]=Array("description","",424,473);
$z[4][4]['function']="cn_substr(@me,90)";

?>