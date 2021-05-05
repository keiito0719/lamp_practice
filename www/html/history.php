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
$now_date=date('Y-m-d H:i:s');
$order_id = get_post('order_id');

include_once VIEW_PATH. 'history_view.php';