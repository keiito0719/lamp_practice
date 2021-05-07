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
// 引数で切り替える　OR 2パターンの変数作成※条件分岐
// コントローラの中で判断
// // function get_login_user($db){
//   $login_user_id = get_session('user_id');
// admin.phpより引用
// if(is_admin($user) === false){
//   redirect_to(LOGIN_URL);
// }
//   return get_user($db, $login_user_id);がユーザー切り替えの変数
// 追加箇所
  // $admin_histories=admin_history($db, $order_id['order_id']);
  // include_once VIEW_PATH. 'admin_history_view.php';


// if(is_admin($user) === true){
//   include_once VIEW_PATH. 'admin_history_view.php';
// }

$histories = get_history($db, $user['user_id']);

include_once VIEW_PATH. 'history_view.php';


// cart.phpにて管理者用テーブルの作成
//history.phpにてadminのif文作成→その後、admin_history_viewへログインの流れにて作成中だが、エラー発生(adminのみ)
