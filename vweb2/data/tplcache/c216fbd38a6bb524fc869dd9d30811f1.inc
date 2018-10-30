<li>[field:array runphp='yes']@me = (empty(@me['litpic']) ? "" : "<a href='{@me['arcurl']}'><img src='{@me['litpic']}'/></a>"); [/field:array]
     [[field:typelink/]] <a href="[field:arcurl/]" class="title">[field:title/]</a> <span class="info"> <small>日期：</small>[field:pubdate function="GetDateTimeMK(@me)"/] 点击：[field:click/]</span>
     <p class="intro"> [field:description/]... </p>
    </li>