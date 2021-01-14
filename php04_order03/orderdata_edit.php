<?php
// var_dump($_GET);
// exit();


// 関数ファイル読み込み
session_start();
include("functions.php");
check_session_id();

// 送信されたidをgetで受け取る
$purchase_order_id = $_GET['purchase_order_id'];

// DB接続&id名でテーブルから検索
$pdo = connect_to_db();
// データ取得SQL作成
$sql = 'SELECT * FROM order_table WHERE purchase_order_id=:purchase_order_id';
// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':purchase_order_id', $purchase_order_id, PDO::PARAM_INT);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
// 正常にSQLが実行された場合は指定のレコードを取得
// fetch()関数でSQLで取得したレコードを取得できる
  $record = $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- bootstrap CSS-->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">


  <title>発注管理（編集画面）</title>
</head>

<body>
  <form action="orderdata_update.php" method="POST">
    <fieldset>
      <legend class="p-3 mb-2 bg-info text-white">発注一覧（編集画面）</legend>

      <div class="d-flex justify-content-start">
        <div class="p-2 bd-highlight"><a href="orderdata_read.php">発注一覧</a></div>
        <div class="p-2 bd-highlight">見積書作成</div>
        <div class="p-2 bd-highlight">請求書作成</div>
        <div class="p-2 bd-highlight">分析レポート</div>
        <div class="p-2 bd-highlight">チャット</div>
      </div>

      <!-- <a href="orderdata_read.php">一覧画面</a> -->
      <!-- タグに初期値として設定 -->
      <div>
        発注日: <input type="date" name="purchase_order_date" value="<?= $record["purchase_order_date"] ?>">
      </div>
      <div>
        発注先: <input type="text" name="order_target" value="<?= $record["order_target"] ?>">
      </div>
      <div>
        商品名: <input type="text" name="product_name" value="<?= $record["product_name"] ?>">
      </div>
      <div>
        合計発注額: <input type="text" name="total_amount_including_tax" value="<?= $record["total_amount_including_tax"] ?>">
      </div>
      <div>
        希望納期: <input type="date" name="desired_delivery_date" value="<?= $record["desired_delivery_date"] ?>">
      </div>
      <div>
        発注担当: <input type="text" name="order_responsible" value="<?= $record["order_responsible"] ?>">
      </div>
      <div>
        ステータス: <input type="text" name="order_status" value="<?= $record["order_status"] ?>">
      </div>
      <!-- id を type="hidden"を使って見えないように送る -->
      <input type="hidden" name="purchase_order_id" value="<?= $record['purchase_order_id'] ?>">
      <div>
        <button>更新する</button>
      </div>

    </fieldset>
  </form>

  <!-- bootstrap Javascript-->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>

</body>

</html>