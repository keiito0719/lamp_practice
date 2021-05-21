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

if(isset($_GET['sort'])){
    if (isset($_GET['cost_up']) === true) {
        $items = get_open_items($db);
    }elseif(isset($_GET['cost_down']) === true){
        $items = get_open_items($db);
    }else{
        $items = get_open_items($db);
    }
    var_dump($_GET['sort']);
}


include_once VIEW_PATH . 'index_view.php';

?>

<!-- 予測 -->
<!-- sortボタンを押した時、データをhiddenにて送信 -->
<!-- index.php？sort.php?でデータを取得し、ユーザー定義関数からitem.phpでSELECTした情報を抜き出す -->
<!-- index_view.php?sort.phpに返す -->
<!-- SQLに直接SELECT文を投入するとソート機能は成立する -->

<!-- ORDER BY句はプリペアドメソッドを使えない為、switch文で条件分岐?  -->
<!-- そもそも条件分岐をするとデータ取得ができていない。-->
<!-- データ取得→SELECT文を返すまでができていない -->

<!-- // if($sorting){
//     var_dump($items);
//     switch($sorting){
//         case 'cost_up':
//             $items = $db->prepare(
//             "SELECT
//             item_id, 
//             name,
//             stock,
//             price,
//             image,
//             status
//           FROM
//             items
//           WHERE
//             item_id =?");
//         break;
//         case 'cost_down':
//             $items = get_open_items($db);
//         break;
//         default:
//             $items = get_open_items($db);
//         }
//     }             -->
