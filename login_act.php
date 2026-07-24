<?php
// ============================================================
// login_act.php … login.phpのフォームから送られてきたID/PWを
// 照合し、正しければログイン状態(SESSION)を作る処理
// ============================================================

// セッションを使うので、必ずファイルの先頭でstart
session_start();

// funcs.phpの道具箱を読み込む(db_conn, redirect, sql_errorを使うため)
require_once('funcs.php');

// 1. POSTデータ取得
$lid = $_POST['lid'];
$lpw = $_POST['lpw'];

// 2. DB接続(funcs.phpのdb_conn()を呼ぶだけでよい)
$pdo = db_conn();

// 3. SQL作成・実行
// パスワードはハッシュ化されているのでWHERE句で直接比較できない。
// まずはlidだけで対象ユーザーを1件検索する。
$stmt = $pdo->prepare('SELECT * FROM gs_user_table WHERE lid = :lid');
$stmt->bindValue(':lid', $lid, PDO::PARAM_STR);
$status = $stmt->execute();

// 4. 実行後の処理
if ($status === false) {
    sql_error($stmt);
}

// lidに一致するユーザーが1件だけ取得できる(存在しなければfalse)
$val = $stmt->fetch();


// 5. パスワード照合 + ログイン成功時の処理
// password_verify(生のパスワード, ハッシュ値) で一致すればtrue
if ($val && password_verify($lpw, $val['lpw'])) {

    // セキュリティのため、ログイン成功のタイミングでセッションIDを更新する
    session_regenerate_id(true);

    // 「ログイン済み」の目印を保存する
    $_SESSION['chk_ssid'] = session_id();

    // 権限で処理を分けたい場合に備えて、権限フラグも保存しておく
    $_SESSION['kanri_flg'] = $val['kanri_flg'];

    // ログイン成功 → 一覧ページへ
    redirect('index.php');

} else {

    // ログイン失敗 → ログイン画面に戻す
    redirect('login.php');

}
