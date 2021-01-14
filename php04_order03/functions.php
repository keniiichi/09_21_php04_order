<?php

//関数の定義 DB接続
function connect_to_db()
{
    // DB接続の設定
    // DB名は自分で設定したもの`gsacf_x00_00`にする
    $dbn = 'mysql:dbname=gsaf_d07_21;charset=utf8;port=3306;host=localhost';
    $user = 'root';
    $pwd = '';

    try {
        // ここでDB接続処理を実行する
        return new PDO($dbn, $user, $pwd);   // returneに変える
    } catch (PDOException $e) {
        // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
        echo json_encode(["db error" => "{$e->getMessage()}"]);
        exit();
    }
}
// ログイン状態のチェック関数→毎回id作成
function check_session_id()
{
    // 失敗時はログイン画面に戻

    if (
        !isset($_SESSION['session_id']) ||          // session_idがない
        $_SESSION['session_id'] != session_id()     // idが一致しない
    ) {
        header('Location: orderdata_login.php');    // ログイン画面へ移動
    } else {
        session_regenerate_id(true);               // セッションidの再生成
        $_SESSION['session_id'] = session_id();    // セッション変数上書き
    }
}
