<?php
require_once '../include/common.inc.php';
require_once PPCHAT_ROOT.'./include/json.php';
$json=new JSON_obj;
$uid=$_SESSION['login_uid'];
$gid=$_SESSION['login_gid'];
$rid=(int)$rid;
if($gid<1)exit("<script>top.openWin(2,false,'/room/minilogin.php',370,340)</script>");
$ym= date('Ym',time());
$qdday="";
$d=$db->query("select * from {$tablepre}apps_qiandao_log where uid='$uid' and rid='$rid'  and FROM_UNIXTIME(atime,'%Y%m')='$ym'");
while($row=$db->fetch_row($d)){
	$qdday.=date('d,',$row['atime']);
}
if($qdday!="")$qdday=substr($qdday,0,-1);
?>
<!DOCTYPE html>
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <title>签到</title>
    <link rel="stylesheet" href="./css/qiandao_style.css">
</head>

<body id="signin">
    <div class="qiandao-warp" style="display:none">
        <div class="qiandap-box">
            <div class="qiandao-con clear">
                <div class="qiandao-left">
                    <div class="qiandao-left-top clear">
                        <div class="current-date"></div>
                        <div class="qiandao-history qiandao-tran qiandao-radius" id="js-just-qiandao"></div>
                        <div class="qiandao-history qiandao-tran qiandao-radius" id="js-qiandao-history" style="display: none;">我的签到</div>
                    </div>
                    <div class="qiandao-main" id="js-qiandao-main">
                        <ul class="qiandao-list" id="js-qiandao-list"> 
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 我的签到 layer start -->
    <div class="qiandao-layer qiandao-history-layer" style="display: none;">
        <div class="qiandao-layer-con qiandao-radius">
            <a href="javascript:;" class="close-qiandao-layer qiandao-sprits"></a>
            <ul class="qiandao-history-inf clear">
                <li id="persist">
                    <p>连续签到</p>
                    <h4></h4>
                </li>
                <li id="cur-month">
                    <p>本月签到</p>
                    <h4></h4>
                </li>
                <li id="total">
                    <p>总共签到数</p>
                    <h4></h4>
                </li>
                <li id="sum-reward">
                    <p>签到累计奖励</p>
                    <h4></h4>
                </li>
            </ul>
            <div class="qiandao-history-table">
                <table>
                    <thead>
                        <tr>
                            <th>签到日期</th>
                            <th>奖励</th>
                            <th>说明</th>
                        </tr>
                    </thead>
                </table>
                <div class="signin-records-container">
                    <table>
                        <tbody id="signin-records">
                        </tbody>
                    </table>
                </div>
                
            </div>
        </div>
        <div class="qiandao-layer-bg"></div>
    </div>
    <!-- 我的签到 layer end -->
    <!-- 签到 layer start -->
    <div class="qiandao-layer qiandao-active" style="display: none;">
        <div class="qiandao-layer-con qiandao-radius">
            <a href="javascript:;" class="close-qiandao-layer qiandao-sprits"></a>
            <div class="yiqiandao clear">
                <div class="yiqiandao-icon qiandao-sprits"></div>
                <span class="persisit-signin-tip"></span>
            </div>
            <div class="qiandao-jiangli qiandao-sprits">
                <span class="qiandao-jiangli-num"></span>
            </div>
          
        </div>
        <div class="qiandao-layer-bg"></div>
    </div>
    <button style="display:none" id="ShowSigninRes">签到</button>
    <!-- 签到 layer end -->
    <script src="./js/jquery-1.10.2.min.js">
</script>
    <script src="./js/qiandao_js.js">
</script>
    <script src="/room/m/script/layer.js">
</script>
<script>

    var rid = '<?=$rid?>';
    var isMobile = '';
    if (!isMobile) {
        $('.qiandao-warp').show();
    }
    $(function() {
        if (isMobile) {
            $('#ShowSigninRes').click();
            $('#signin').addClass('ismobile');
        }
    })
    var dateArray =[<?=$qdday?>];
</script>


</body></html>