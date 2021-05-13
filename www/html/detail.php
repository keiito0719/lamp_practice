<?php
require_once '../conf/const.php';
require_once MODEL_PATH. 'functions.php';
require_once MODEL_PATH. 'user.php';
require_once MODEL_PATH. 'item.php';
require_once MODEL_PATH. 'cart.php';


session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);

// $histories = get_history($db, $user['user_id']);
// 1つの関数で作るか
// オーダーIDをヒストリーの取得に繋げる

$order_id = get_post('order_id');

if(is_admin($user) === true){
  $histories=head_admin_detail($db,$order_id);
  $details=get_admin_detail($db,$order_id);  
  var_dump($details,$order_id);
}else{
  $histories=head_general_detail($db,$order_id,$user_id['user_id']);
  $details=get_general_detail($db,$order_id,$user_id['user_id']);
  var_dump($histories,$details);
}

include_once VIEW_PATH. 'detail_view.php';

// viewページのif文は必要なし。controller側で切り分けを行う。
// detailに関しても関数を4つ用意し、if文にて2つの関数を選ぶ仕組みを作る。
// 関数ネーム4つを考える必要あり。