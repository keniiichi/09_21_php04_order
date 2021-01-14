<?php
// セッション開始＆ログイン情報の受け取り

// var_dump($_POST);
// exit();


session_start();
include('functions.php');       //セッションの開始
$pdo = connect_to_db();          //DB接続
$username = $_POST['username']; // データ受け取り→変数に入れる
$password = $_POST['password'];

// DBにデータがあるかどうか検索
$sql = 'SELECT * FROM users_table
WHERE username=:username
AND password=:password
AND is_deleted=0';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':username', $username, PDO::PARAM_STR);   //数字ならSTR が int
$stmt->bindValue(':password', $password, PDO::PARAM_STR);
$status = $stmt->execute();

if ($status == false) {
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "($error[2]})"]);
    exit();
}

//DBデータ有無で条件分岐

$val = $stmt->fetch(PDO::FETCH_ASSOC);    //該当レコードだけ取得 
if (!$val) {                               //該当ページがない時はログインページへのリンクを取得 
    echo "<p>ログイン情報に誤りがあります</p>";
    echo '<a href="orderdata_login.php">ログインページへ</a>';
    exit();

//DBにデータがあればセッションに変数を格納    
} else {
    $_SESSION = array();                        //セッションの変数を空にする
    $_SESSION["session_id"] = session_id();
    $_SESSION["is_admin"] = $val["is_admin"];
    $_SESSION["username"] = $val["username"];
    header("Location:orderdata_read.php");      //一覧ページに移動
    exit();
}

// session変数には必要な値を保存する（今回は管理者フラグとユーザ名）
// 自分がが使いたい値を保存するようにする
