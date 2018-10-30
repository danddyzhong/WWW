<li class="menu-item menu-item-type-taxonomy menu-item-object-category menu-item-has-children menu {dede:field.currentstyle/}"><a  id="[field:global.autoindex/]"  href="{dede:field name='typeurl'/}" >{dede:field name='typename'/}</a>
        <ul {dede:field name=typeid runphp="yes"}
global $dsql;
$sql = "SELECT id From `#@__arctype` WHERE reid='@me' And ishidden<>1 order by sortrank asc limit 0, 100 ";
$row = $dsql->GetOne($sql);
@me=is_array($row)?'class="sub-menu"':'style="display:none"';
{/dede:field} >
              {dede:channel type='son'}>
          <li class="menu-item menu-item-type-taxonomy menu-item-object-category"><a href="[field:typeurl/]">[field:typename/]</a> </li>
        </ul>
      </li>