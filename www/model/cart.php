<?php 
require_once MODEL_PATH . 'functions.php';
require_once MODEL_PATH . 'db.php';

// カート内のuser_idを取得
function get_user_carts($db, $user_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE
      carts.user_id = ?
  ";
  // SQLの一部の場合「？」にしてあげる。？にユーザーIDセット
  return fetch_all_query($db, $sql,[$user_id]);
}

// カート内のuser_id,item_idから取得
function get_user_cart($db, $user_id, $item_id){
  $sql = "
    SELECT
      items.item_id,
      items.name,
      items.price,
      items.stock,
      items.status,
      items.image,
      carts.cart_id,
      carts.user_id,
      carts.amount
    FROM
      carts
    JOIN
      items
    ON
      carts.item_id = items.item_id
    WHERE　
      carts.user_id = ？
    AND
      items.item_id = ？
  ";
// 第三引数に代入。順番を合わせる（要素はプレースフォルダのじゅんばんに合わせる）[]で囲む
  return fetch_query($db, $sql,[$user_id,$item_id]);

}

// カートに追加したuser_id,item_idから取得（カートに追加※同じ商品があった場合は個数のみアップデート）
function add_cart($db, $user_id, $item_id ) {
  $cart = get_user_cart($db, $user_id, $item_id);
  if($cart === false){
    
    return insert_cart($db, $user_id, $item_id);
  }
  return update_cart_amount($db, $cart['cart_id'], $cart['amount'] + 1);
}
// 指摘箇所
// カート内のuser_id.item_id,amountを追加する
function insert_cart($db, $user_id, $item_id, $amount = 1){
  $sql = "
    INSERT INTO
      carts(
        item_id,
        user_id,
        amount
      )
    VALUES (?,?,?)
  ";

  return execute_query($db, $sql,[$item_id,$user_id,$amount]);
}
// 指摘箇所
// 数量変更
function update_cart_amount($db, $cart_id, $amount){
  $sql = "
    UPDATE
      carts
    SET
      amount = ?
    WHERE
      cart_id = ?
    LIMIT 1
  ";
  return execute_query($db, $sql,[$amount,$cart_id]);
}
// 指摘箇所
// 商品削除
function delete_cart($db, $cart_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      cart_id = ?
    LIMIT 1
  ";

  return execute_query($db, $sql,[$cart_id]);
}

// 商品購入
function purchase_carts($db, $carts){
  if(validate_cart_purchase($carts) === false){
    return false;
  }

  // 課題2コード入力箇所
  // トランザクション開始
  $db->beginTransaction();
  try{
  // 現在日時を取得
    $now_date=date('Y-m-d H:i:s');
    //購入履歴へ追加
    insert_history($db,['user_id']);
    //order_idをデータベースへ登録
    $order_id=$db->lastInsertId();
   
    // ＄carts繰り返し処理
    foreach($carts as $cart){
      insert_detail($db,$order_id,$cart['item_id'],$cart['price'],$cart['amount']);
      if(update_item_stock(
          $db, 
          $cart['item_id'], 
          $cart['stock'] - $cart['amount']
        ) === false){
        set_error($cart['name'] . 'の購入に失敗しました。');
      }
    }
    delete_user_carts($db, $carts[0]['user_id']);
    $db->commit();
  } catch (PDOException $e) {
    $db->rollback();
    throw $e;
  }
}

function insert_history($db,$user_id){
  $sql="
    INSERT INTO order_histories(
    user_id,
    values(?)
    ";
    return execute_query($db,$sql,array($user_id));
}

function insert_detail($db,$order_id,$item_id,$price,$amount){
  $sql="
    INSERT INTO 
     order_detail(
       order_id,
       item_id,
       price,
       amount
      )
    VALUES(?,?,?,?)
  ";
  return execute_query($db,$sql,array($order_id,$item_id,$price,$amount));
}

// 指摘箇所
function delete_user_carts($db, $user_id){
  $sql = "
    DELETE FROM
      carts
    WHERE
      user_id = ?
  ";

  execute_query($db, $sql,[$user_id]);
}


function sum_carts($carts){
  $total_price = 0;
  foreach($carts as $cart){
    $total_price += $cart['price'] * $cart['amount'];
  }
  return $total_price;
}

function validate_cart_purchase($carts){
  if(count($carts) === 0){
    set_error('カートに商品が入っていません。');
    return false;
  }
  foreach($carts as $cart){
    if(is_open($cart) === false){
      set_error($cart['name'] . 'は現在購入できません。');
    }
    if($cart['stock'] - $cart['amount'] < 0){
      set_error($cart['name'] . 'は在庫が足りません。購入可能数:' . $cart['stock']);
    }
  }
  if(has_error() === true){
    return false;
  }
  return true;
}