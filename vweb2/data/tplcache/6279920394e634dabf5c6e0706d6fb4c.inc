<li> <a href="[field:arcurl/]" rel="bookmark"> <img src="[field:id runphp=yes]  
    global $dsql;
    $id = @me;
    $sql='select slider_img from #@__archives where id='.$id;
    $row=$dsql->getone($sql);
    @me=$row['slider_img'];
 [/field:id]" alt="[field:title/]" /></a> </li>