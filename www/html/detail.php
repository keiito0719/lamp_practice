<?php
require_once '../conf/const.php';
require_once MODEL_PATH. 'function.php';
require_once MODEL_PATH. 'user.php';
require_once MODEL_PATH. 'item.php';
require_once MODEL_PATH. 'cart.php';
require_once MODEL_PATH. 'history.php';

session_start();

if(is_logined() === false){
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();
$user = get_login_user($db);
$histories = get_history($db, $user['user_id']);

$order_id = get_post('order_id');
$details = get_detail($db, $order_id);
include_once VIEW_PATH. 'detail_view.php';