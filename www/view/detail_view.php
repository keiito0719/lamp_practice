<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <title>購入明細</title>
  </head>

  <body>
    <h1>購入明細</h1>

    <!-- メッセージ・エラーメッセージ -->
    <?php include VIEW_PATH. 'templates/messages.php'; ?>

    <!-- 購入明細 -->
    <table>
      <thead>
        <tr>
          <th>注文番号</th>
          <th>購入日時</th>
          <th>合計金額</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($histories as $history){ ?>
        <tr>
          <td><?php print($history['order_id']); ?></td>
          <td><?php print($history['create_date']); ?></td>
          <td><?php print($history['total']); ?></td>
          <td>
            <form method="post" action="detail.php">
              <input type="submit" value="購入明細表示">
              <input type="hidden" name="order_id" value="<?php print($history['order_id']); ?>">
            </form>
          </td>
        </tr>
      <?php } ?>
      </tbody>
    </table>

    <!-- 購入明細 -->
    <table>
      <thead>
        <tr>
          <th>商品名</th>
          <th>価格</th>
          <th>購入数</th>
          <th>小計</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($details as $detail){ ?>
        <tr>
          <td><?php print($detail['name']); ?></td>
          <td><?php print($detail['price']); ?></td>
          <td><?php print($detail['amount']); ?></td>
          <td><?php print($detail['subtotal']); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </body>
</html>