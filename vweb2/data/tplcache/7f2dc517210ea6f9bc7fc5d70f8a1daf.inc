<li> <a target="_blank" class="crop-image" href="[field:arcurl/]"> <img alt="[field:title/]" src="[field:picname/]" /> </a>
      <div class="works-mode"> <a target="_blank" href="[field:arcurl/]" class="works-mode-title"> [field:title/] </a>
        <div class="works-mode-type"> <span class="currentBgColor">[field:typename/]</span></div>
        <div class="works-mode-type font14">
          <div class="w260 fLeft">[field:pubdate runphp='yes'] $today = Floor(time()/(3600 * 24)); $senday= Floor(@me/(3600 * 24)); 
            $updays = $today-$senday; 
            if($updays==0) @me = "今日"; else @me = $updays."天前"; [/field:pubdate]上传</div>
          <div class="w100 fLeft omitContent">作者:[field:writer/]</div>
        </div>
      </div>
      <div class="works-read bRead"> <i class="r"></i> <span>[field:click/]人看过</span> </div>
    </li>