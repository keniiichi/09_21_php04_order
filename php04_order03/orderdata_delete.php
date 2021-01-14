<?php
// var_dump($_POST);
// exit();

session_start();
include("functions.php");
check_session_id();

//idをgetで受け取る
$purchase_order_id = $_GET['purchase_order_id'];

//呼び出し
$pdo = connect_to_db();

// idを指定して更新するSQLを作成 -> 実行の処理
$sql = 'DELETE FROM order_table WHERE purchase_order_id=:purchase_order_id';


$stmt = $pdo->prepare($sql);
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
    header("Location:orderdata_read.php");
    exit();
}