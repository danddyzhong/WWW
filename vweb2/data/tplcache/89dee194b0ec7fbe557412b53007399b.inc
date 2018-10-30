<div><a target="_blank" href="[field:arcurl/]"><img src="[field:id runphp=yes]  
    global $dsql;
    $id = @me;
    $sql='select slider_img from dede_archives where id='.$id;
    $row=$dsql->getone($sql);
    @me=$row['slider_img'];
 [/field:id]"></a></div>