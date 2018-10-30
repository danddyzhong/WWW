<div class="item">
										<a href='[field:arcurl/]'>
											<img src="[field:id runphp=yes]  
    global $dsql;
    $id = @me;
    $sql='select slider_img from dede_archives where id='.$id;
    $row=$dsql->getone($sql);
    @me=$row['slider_img'];
 [/field:id]" alt="[field:title/]">
											<div class="carousel-caption">
												<h3>[field:title function='cn_substr(@me,50)'/]</h3>
												<p>[field:description function='cn_substr(@me,90)'/]..</p>
											</div>
										</a>
									</div>