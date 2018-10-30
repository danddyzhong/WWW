<section class="graduate-sec2">
  <div class="gra-sec-tit">
    <h3>{dede:field name='typename'/}</h3>
    <a href="list.php?tid=[field:id/]" title="{dede:field name='typename'/}">更多</a> </div>
  <ul>
    {dede:arclist orderby ='pubdate' titlelen='38' row='8'}
    <li><a title="[field:title/]" href="view.php?aid=[field:id/]"><i></i>[field:title/]</a></li>
    {/dede:arclist}
  </ul>
</section>