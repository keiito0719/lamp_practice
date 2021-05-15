<?php
require_once '../conf/const.php';
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'user.php';
require_once MODEL_PATH . 'item.php';
require_once MODEL_PATH . 'cart.php';


session_start();

if (is_logined() === false) {
  redirect_to(LOGIN_URL);
}

$db = get_db_connect();

$user = get_login_user($db);
// 引数で切り替える　OR 2パターンの変数作成※条件分岐
// 追加箇所

//管理者用 
if (is_admin($user) === true) {
  $histories = get_admin_history($db);
} else {
  $histories = get_general_history($db, $user['user_id']);
}
include_once VIEW_PATH . 'history_view.php';
