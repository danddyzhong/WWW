<?php
include "upload.php";
switch($_GET['act']){
	case "InsertImg":
		echo "
				<script>
				var info={'err':'".jsonString($err)."','msg':".$msg."}
				if(info.err==''){
					if(info.msg.url!=''){
						top.InsertImg(info.msg.info,info.msg.url);						
					}
				}
				</script>";
	break;	
}

?>