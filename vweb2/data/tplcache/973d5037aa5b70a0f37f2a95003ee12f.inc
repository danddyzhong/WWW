<li>
					<a href="view.php?aid=[field:id/]" title="[field:title /]">
						<div class="tit">
							<h6>[field:title /]</h6>
							<span class="date">[field:pubdate function="MyDate('Y-m-d',@me)"/]</span>
						</div>
						<p>[field:description function='cn_substr(@me,70)'/]...</p>
					</a>
					<div class="label">
						<div class="left">
							<a title="[field:typename/]" href="[field:global.cfg_mip/]listlb.php?tid=[field:typeid/]" class="three-label">[field:typename/]</a>
						</div>
					</div>
				</li>