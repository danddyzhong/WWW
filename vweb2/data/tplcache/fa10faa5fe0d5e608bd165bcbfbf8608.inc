<li><a target="_blank"href="[field:arcurl/]"title="[field:title/]"><img src="[field:id runphp=yes]  
        global $dsql;
        $id = @me;
        $sql='select slider_img from dede_archives where id='.$id;
        $row=$dsql->getone($sql);
        @me=$row['slider_img'];
     [/field:id]" title="[field:title/]" alt="[field:title/]" width="930"height="330"/></a>
                    <div class="bx-caption"> <span>[field:title/]</span> </div>
                  </li>