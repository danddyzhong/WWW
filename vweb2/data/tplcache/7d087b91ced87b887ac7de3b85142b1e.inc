<li class="menu-item {dede:field.currentstyle/}"><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a>
            <ul {dede:field name=typeid runphp="yes"}
global $dsql;
$sql = "SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 ";
$row = $dsql->GetOne($sql);
@me=is_array($row)?'class="menu-item"':'style="display:none"';
{/dede:field} >
              {dede:channel type='son'}
              <li><a href="[field:typeurl/]">[field:typename/]</a></li>
            {/dede:channel} 
            </ul>
          </li>