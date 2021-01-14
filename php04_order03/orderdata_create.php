<?php

// 送信確認
// var_dump($_POST);
// exit();

session_start();
include("functions.php");
check_session_id();


// 項目入力のチェック
// 値が存在しないor空で送信されてきた場合はNGにする
if (
  !isset($_POST['order_target']) || $_POST['order_target'] == '' ||
  !isset($_POST['product_name']) || $_POST['product_name'] == '' ||
  !isset($_POST['total_amount_including_tax']) || $_POST['total_amount_including_tax'] == '' ||
  !isset($_POST['desired_delivery_date']) || $_POST['desired_delivery_date'] == ''  ||
  !isset($_POST['order_responsible']) || $_POST['order_responsible'] == ''
) {
  // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
  echo json_encode(["error_msg" => "no input"]);
  exit();
}

// 受け取ったデータを変数に入れる
$purchase_order_date = $_POST['purchase_order_date'];
$order_target = $_POST['order_target'];
$product_name = $_POST['product_name'];
$total_amount_including_tax = $_POST['total_amount_including_tax'];
$desired_delivery_date = $_POST['desired_delivery_date'];
$order_responsible = $_POST['order_responsible'];
$order_status = $_POST['order_status'];


//呼び出し
$pdo = connect_to_db();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO
order_table(purchase_order_id, purchase_order_date, order_target, product_name, total_amount_including_tax, desired_delivery_date, order_responsible, order_status, created_at, updated_at)
VALUES(NULL, :purchase_order_date, :order_target, :product_name, :total_amount_including_tax, :desired_delivery_date, :order_responsible, :order_status, sysdate(), sysdate())';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':purchase_order_date', $purchase_order_date, PDO::PARAM_STR);
$stmt->bindValue(':order_target', $order_target, PDO::PARAM_STR);
$stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
$stmt->bindValue(':total_amount_including_tax', $total_amount_including_tax, PDO::PARAM_STR);
$stmt->bindValue(':desired_delivery_date', $desired_delivery_date, PDO::PARAM_STR);
$stmt->bindValue(':order_responsible', $order_responsible, PDO::PARAM_STR);
$stmt->bindValue(':order_status', $order_status, PDO::PARAM_STR);
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
