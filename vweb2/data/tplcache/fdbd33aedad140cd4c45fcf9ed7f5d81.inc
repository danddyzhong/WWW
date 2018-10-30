<div data-am-widget="list_news" class="am-list-news am-list-news-default">
			<!--列表标题-->
			<div class="am-list-news-hd am-cf">
				<!--带更多链接-->
				<a href="list.php?tid={dede:field name='id'/}">
					 <h2>{dede:field name='typename'/}</h2>
				</a>
			</div>
			<div class="am-list-news-bd">
				<ul class="am-list">{dede:arclist titlelen='60' row='8'}
					<li class="am-g"> <a href="view.php?aid=[field:id/]" class="am-list-item-hd">[field:title /]</a>
					</li>{/dede:arclist}</ul>
			</div>
			<!--更多在底部-->
			<div class="am-list-news-ft"> <a class="am-list-news-more am-btn am-btn-default" href="list.php?tid={dede:field name='id'/}">查看更多 &raquo;</a>
			</div>
		</div>