<div class="main2">
	<div class="t_2">
    	<span>
        	{dede:channel type='son'}<a href='[field:typeurl/]'>[field:typename/]</a>|{/dede:channel}
           	<a href="{dede:field name='typeurl'/}">更多>></a> 
        </span>
    	<h3><a href="{dede:field name='typeurl'/}">{dede:field name='typename'/}</a></h3>
    </div>
    <div class="g_box3 fl">
        <ul class="b_box2">
        	{dede:arclist limit='0,2' titlelen=50 orderby='pubdate'}
        	<li>
            	<a href="[field:arcurl/]">[field:title/]</a>
                [field:description function="cn_substr(@me,70)"/]...
            </li>
        	{/dede:arclist}
        </ul>
        <ul class="b_box3">
        	{dede:arclist limit='2,6' titlelen=50 orderby='pubdate'}
			<li><a href="[field:arcurl/]">[field:title/]</a></li>
			{/dede:arclist}
        </ul>
    </div>
    <div class="g_box4 fl">
    	{dede:arclist row=1 titlelen=50 flag='a'}
        <h3><a href="[field:arcurl/]">[field:title/]</a></h3>
		<p>[field:description function="cn_substr(@me,130)"/]……</p>
        {/dede:arclist}
        <ul class="b_box8">
        	{dede:arclist row=3 titlelen=100 flag='c'}
			<li>
                <a href="[field:arcurl/]"><img src="[field:picname/]" alt="[field:fulltitle/]" /></a>
                <h4><em>【推荐】</em><a href="[field:arcurl/]">[field:fulltitle/]</a></h4>
                <p>[field:description function="cn_substr(@me,100)"/]...</p>
            </li>
			{/dede:arclist}
        </ul>
    </div>
    <div class="g_box3 fl">
    	<div class="t_3">热门文章</div>
        <ul class="b_box4">
        	{dede:arclist row=10 titlelen=100 orderby='click'}
			<li><a href="[field:arcurl/]">[field:title/]</a></li>
			{/dede:arclist}
        </ul>
    </div>
    <div class="clear"></div>
</div>