<?php
// 送信確認
// var_dump($_POST);
// exit();

session_start();
include("functions.php");
check_session_id();

//各値をpostで受け取る
$purchase_order_id = $_POST["purchase_order_id"];
$purchase_order_date = $_POST['purchase_order_date'];
$order_target = $_POST['order_target'];
$product_name = $_POST['product_name'];
$total_amount_including_tax = $_POST['total_amount_including_tax'];
$desired_delivery_date = $_POST['desired_delivery_date'];
$order_responsible = $_POST['order_responsible'];
$order_status = $_POST['order_status']; 

//呼び出し
$pdo = connect_to_db();

//idを指定して更新するSQL作成（UPDATE文）
$sql = "UPDATE order_table SET purchase_order_date=:purchase_order_date, order_target=:order_target, product_name=:product_name, total_amount_including_tax=:total_amount_including_tax, desired_delivery_date=:desired_delivery_date, order_responsible=:order_responsible, order_status=:order_status, updated_at=sysdate() WHERE purchase_order_id=:purchase_order_id";


// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':purchase_order_date', $purchase_order_date, PDO::PARAM_STR);
$stmt->bindValue(':order_target', $order_target, PDO::PARAM_STR);
$stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
$stmt->bindValue(':total_amount_including_tax', $total_amount_including_tax, PDO::PARAM_STR);
$stmt->bindValue(':desired_delivery_date', $desired_delivery_date, PDO::PARAM_STR);
$stmt->bindValue(':order_responsible', $order_responsible, PDO::PARAM_STR);
$stmt->bindValue(':order_status', $order_status, PDO::PARAM_STR);
$stmt->bindValue(':purchase_order_id', $purchase_order_id, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
  // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
  $error = $stmt->errorInfo();
  echo json_encode(["error_msg" => "{$error[2]}"]);
  exit();
} else {
     // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
  header("Location:orderdata_input.php");
  exit();
}
