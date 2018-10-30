// 星星评价效果开始
function starGrade(starElem, inputElem){
  var starElem = document.getElementById(starElem);
  var inputElem = document.getElementById(inputElem);
  var starItem = starElem.getElementsByTagName("dd");
  var input = inputElem.getElementsByTagName("input");
  
  //alert(input[0].value)
  // 注册星星滑过点击事件
  for(var i=0; i<starItem.length; i++){
    (function(i){
      var star = starItem[i].getElementsByTagName("span");
      for(var j=0; j<star.length; j++){
        (function(j){
          star[j].onmouseover = function(){ show(star, j) };
          star[j].onmouseout = function(){ hide(star, i) };
          star[j].onclick = function(){ lock(i, j) };
        })(j);
      }
    })(i);
    
    // 设置星星的初始值
    hide(starItem[i].getElementsByTagName("span"), i);
  }
  // 滑过操作
  function show(o, k){
  // o 单个项目的星星节点数组
  // k 是第几个星星
    for(var i=0; i<o.length; i++){
      o[i].className = "";
      if(i<=k)o[i].className = "show";
    }
  };
  // 离开操作
  function hide(o, x){
  // o 单个项目的星星节点数组
  // x 第几组投票
    for(var i=0; i<o.length; i++){
      o[i].className = "";
      if(i<input[x].value)o[i].className = "show";
    };
  }
  // 点击操作
  function lock(x, k){
  // x 第机组投票
  // k 是第几个星星
    input[x].value = k+1;
  }
}


// 这段JS只是为了查看提交的值，与星星效果无关 可以删除
function lookvalue(){
  var inputElem = document.getElementById("gradeInput");
  var input = inputElem.getElementsByTagName("input");
  var str = "价格："+input[0].value;
  str += "\n服务："+input[1].value;
  str += "\n专业："+input[2].value;
  str += "\n性价比："+input[3].value;
  alert(str);
  
  return false;
}