<?php 
$card_num = 54;//牌数
function wash_card($card_num){
	$cards = $tmp = array();
	for($i = 0;$i < $card_num;$i++){
		$tmp[$i] = $i;
	}

	for($i = 0;$i < $card_num;$i++){
		$index = rand(0,$card_num-$i-1);
		$cards[$i] = $tmp[$index];
		unset($tmp[$index]);
		$tmp = array_values($tmp);
	}
	return $cards;
}
// 测试：
print_r(wash_card($card_num));
?>