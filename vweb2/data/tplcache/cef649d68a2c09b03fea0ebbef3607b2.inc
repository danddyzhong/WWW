[field:global runphp='yes' name=autoindex]
            $a="<li class='right'>";
            $b="<li>";
            if ((@me%2)==0 && @me!=30) @me=$a;
            else  @me=$b;
            [/field:global]
        
          <div class="thumbnail"> <a href="[field:arcurl/]" title="[field:title/]"><img src="[field:picname/]" alt="[field:title/]"/></a> </div>
          <h4><a href="[field:arcurl/]" title="[field:title/]">[field:title/]</a></h4>
          <p> [field:description function="cn_substr(@me,320)"/]...</p>
        </li>