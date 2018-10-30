<section class="span6 column2 [field:typeid/] ">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-list"></i></span>
            <h2><a href="[field:typelink/]">[field:typename/]</a></h2>
          </div>
          <div class="widget-content">
            <ul>
               {dede:arclist titlelen='80'  row='1' limit='0,1'}
              <li class="first-posts"><a href="[field:arcurl/]"class="post-thumbnail"title="[field:title/]"rel="bookmark"><img src="[field:picname/]"alt="[field:title/]"style="height:120px; width:180px"/></a>
                <h3><a href="[field:arcurl/]"title="[field:title/]"rel="bookmark">[field:title/]</a></h3>
                <p class="summary"> [field:description function="cn_substr(@me,220)"/]...</p>
              </li>
              {/dede:arclist}

              <div class="clear"> </div>
              {dede:arclist titlelen='80'  row='5' limit='2,7' }
              <li class="other-news"><span>[field:pubdate function='strftime("%m-%d",@me)'/]</span><a href="[field:arcurl/]"title="[field:title/]"><i class="icon-angle-right"></i>[field:title/]</a></li>
               {/dede:arclist}
            </ul>
            <div class="clear"> </div>
          </div>
        </div>
      </section>