<li class=""><a href="{dede:field name='typeurl'/}" class='{dede:field.currentstyle/}'>{dede:field name='typename'/}</a>

                  <ul class='{dede:field name=typeid runphp="yes"}
global $dsql;
$sql = "SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 ";
$row = $dsql->GetOne($sql);
@me=is_array($row)?'sub-menu':'display:none';
{/dede:field}'>
                    {dede:channel type='son'}
                    <li><a href="[field:typeurl/]">[field:typename/]</a></li>
                    {/dede:channel} 
                  </ul>
                </li>