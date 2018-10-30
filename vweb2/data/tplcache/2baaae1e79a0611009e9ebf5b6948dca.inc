<div class="xl3 xm3">
      <div class="cat-box">
        <h3 class="cat-title"> <a href="{dede:field name='typelink'/}" title="{dede:field name='typename'/}">&nbsp;&nbsp;&nbsp;&nbsp;{dede:field name='typename'/}</a></h3>
        <div class="clear"></div>
        <div class="cat-site">
          {dede:arclist row='1' titlelen='80' limit='1,1' orderby='click'}
        <h2 class="entry-title"><a href="[field:arcurl/]" rel="bookmark" title="[field:title/]">[field:title/]</a></h2>
          <figure class="thumbnail"> <a href="[field:arcurl/]"><img src="[field:picname/]"  alt="[field:title/]" /></a> </figure>
          <div class="cat-main">[field:description function="cn_substr(@me,220)"/]...</div>
        {/dede:arclist}
  
          <div class="clear"></div>
          <ul class="cat-list">
          {dede:arclist row='1' titlelen='80' limit='2,3' orderby='click'}
          <span class="list-date">[field:pubdate function='strftime("%m-%d",@me)']</span>
          <li class="list-title"><a href="[field:arcurl/]" rel="bookmark" title="[field:title/]">[field:title/]</a></li>
          {/dede:arclist}
          </ul>
        </div>
      </div>
    </div>