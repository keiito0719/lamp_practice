
<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>購入履歴</title>
    </head>

    <body>
    <h1>購入履歴</h1>

    <!-- メッセージ・エラーメッセージ -->
    <?php include VIEW_PATH. 'templates/messages.php'; ?>

    <!-- 購入履歴 -->
    <?php if(!empty($histories)){ ?>
    <table>
        <thead>
        <tr>
            <th>注文番号</th>
            <th>購入日時</th>
            <th>合計金額</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($histories as $history){ ?>
        <tr>
            <td><?php print($history['order_id']); ?></td>
            <td><?php print($history['created']); ?></td>
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
    <?php }else{ ?>
    <p>購入履歴がありません。</p>
    <?php } ?>
    </body>
</html>