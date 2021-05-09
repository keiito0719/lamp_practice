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

$histories = get_history($db, $user['user_id']);

// $admin_histories=get_admin_history($db,$order_id);

// 1つの関数で作るか
// オーダーIDをヒストリーの取得に繋げる

// $histories_detail=get_history_detail($db,$order_id);

// $histories_detail = get_history_detail($db,$order_id);

$order_id = get_post('order_id');

$details = get_detail($db,$order_id);

$admin_details=get_admin_detail($db,$user_id,$order_id);

include_once VIEW_PATH. 'detail_view.php';