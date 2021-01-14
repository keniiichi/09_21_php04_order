<?php
session_start();
include("functions.php");
check_session_id();

//DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM order_table';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
  // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  // fetchAll()関数でSQLで取得したレコードを配列で取得できる
  $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
  $output = "";
  // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
  // `.=`は後ろに文字列を追加する，の意味
  foreach ($result as $record) {
    $output .= "<tr>";
    $output .= "<td>{$record["purchase_order_date"]}</td>";
    $output .= "<td>{$record["order_target"]}</td>";
    $output .= "<td>{$record["product_name"]}</td>";
    $output .= "<td>{$record["total_amount_including_tax"]}</td>";
    $output .= "<td>{$record["desired_delivery_date"]}</td>";
    $output .= "<td>{$record["order_responsible"]}</td>";
    $output .= "<td>{$record["order_status"]}</td>";
    // edit deleteリンクを追加
    $output .= "<td>
    <a href='orderdata_edit.php?purchase_order_id={$record["purchase_order_id"]}'>発注を編集する</a>
    </td>";
    $output .= "<td>
    <a href='orderdata_delete.php?purchase_order_id={$record["purchase_order_id"]}'>発注キャンセル</a>
    </td>";
    $output .= "</tr>";
  }
  // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
  // 今回は以降foreachしないので影響なし
  unset($record);
}
?>

<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap CSS-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

  <title>発注一覧（一覧画面）</title>
</head>

<body>
  <fieldset>
    <legend class="p-3 mb-2 bg-info text-white">発注一覧（一覧画面）</legend>
    <a href="orderdata_input.php">発注フォーム（入力画面）</a>
    <table>
      <thead>
        <tr>
          <th>発注日</th>
          <th>発注先</th>
          <th>商品名</th>
          <th>合計発注額</th>
          <th>希望納期</th>
          <th>発注担当</th>
          <th>ステータス</th>
        </tr>
      </thead>
      <tbody>
        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
        <?= $output ?>
      </tbody>
    </table>
  </fieldset>

  <!-- bootstrap Javascript-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>