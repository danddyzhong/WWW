<?php
function litimgurls($imgid=0)
{
    global $lit_imglist,$dsql;
    //获取附加表
    $row = $dsql->GetOne("SELECT c.addtable FROM #@__archives AS a LEFT JOIN #@__channeltype AS c 
                                                            ON a.channel=c.id where a.id='$imgid'");
    $addtable = trim($row['addtable']);
    
    //获取图片附加表imgurls字段内容进行处理
    $row = $dsql->GetOne("Select imgurls From `$addtable` where aid='$imgid'");
    
    //调用inc_channel_unit.php中ChannelUnit类
    $ChannelUnit = new ChannelUnit(2,$imgid);
    
    //调用ChannelUnit类中GetlitImgLinks方法处理缩略图
    $lit_imglist = $ChannelUnit->GetlitImgLinks($row['imgurls']);
    
    //返回结果
    return $lit_imglist;
}
function huan_body($content){
	global $cfg_basehost;
	$content = preg_replace("@ [\s]{0,}alt[\s]{0,}=[\"'\s]{0,}[\s\S]{0,}[\"'\s] @isU"," ",$content);
     $content = str_replace('$', '$$', $content);
      // 过滤掉样式表和脚本
     $content = preg_replace("/<style .*?<\/style>/is", "", $content);
     $content = preg_replace("/<script .*?<\/script>/is", "", $content);
     // 首先将各种可以引起换行的标签（如<br />、<p> 之类）替换成换行符"\n"
     $content = preg_replace("/<div .*?>/is", "", $content);
     $content = preg_replace("/target=\"_blank\"/is", "", $content);
     $content = preg_replace("/<p .*?>/is", "<p>", $content);
	 $content = preg_replace("/<span .*?>/is", "<span>", $content);
	 $content = preg_replace('/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i',"<mip-img data-carousel=\"carousel\" class=\"mip-element mip-img\" src=\"$cfg_basehost$1\"></mip-img>", $content);
     $content = preg_replace("(src=\"/uploads/allimg/)", "src=\"$cfg_basehost/uploads/allimg/", $content);
	 $content = preg_replace("(<a href=\"/)", "<a href=\"$cfg_mip/", $content);
    //  $content = preg_replace('/<img(.+?)>/i',"<mip-img data-carousel=\"carousel\" class=\"mip-element mip-img\"$1$3></mip-img>",$content); 
     $content = preg_replace('/<a(.+?)>/i',"<a\$1$3 target=_blank>",$content); 
     $content = preg_replace("/<\/?div>/i", "\n", $content);
     $content = preg_replace("/<\/?blockquote>/i", "\n", $content);
     $content = preg_replace("/<\/?li>/i", "\n", $content);
     // 将"&nbsp;"替换为空格
     $content = preg_replace("/\&nbsp\;/i", " ", $content);
     $content = preg_replace("/\&nbsp/i", " ", $content);
     $content = preg_replace("/\ /i", " ", $content);
     $content = preg_replace("/\ \;/i", " ", $content);
	 return $content;
}