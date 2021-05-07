// ユーザ毎の購入明細
function get_detail($db, $order_id){
    $sql = "
      SELECT
        sample_details.price,
        sample_details.amount,
        sample_details.created,
        SUM(sample_details.price * sample_details.amount) AS subtotal,
        sample_items.name
      FROM
        sample_details
      JOIN
        sample_items
      ON
        sample_details.item_id = sample_items.item_id
      WHERE
        order_id = ?
      GROUP BY
        sample_details.price, sample_details.amount, sample_details.created, sample_items.name
    ";
    return fetch_all_query($db, $sql, array($order_id));
}