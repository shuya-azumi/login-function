<?php
// ============================================================
// delete.php … 削除処理(DBから1件DELETEする / ログイン必須)
// ============================================================
// 詳細(detail.php)の「削除」ボタンからPOSTされてくる。
// idを条件に1件だけ削除する「処理専用ページ」。終わったら一覧に戻す。
//
// 削除は <a href> のGETではなく <form method="POST"> で送る。
// GETだと、リンクを踏んだり先読みされたりするだけで消えてしまうため。
//
// 【超重要】DELETEも必ず WHERE id = :id を付ける。
// 付け忘れると全件が消える。
session_start();
require_once('funcs.php');
loginCheck(); // 会員専用

// 1. 対象のIDを取得(POSTで受け取る)
$id = $_POST['id'];

// 2. DB接続
$pdo = db_conn();

// 3. SQL作成・実行(DELETE。WHEREで対象を1件に絞る)
$stmt = $pdo->prepare('DELETE FROM gs_jinzai_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

// 4. 実行後の処理
if ($status === false) {
    sql_error($stmt);
} else {
    // 削除後は一覧ページへ
    redirect('index.php');
}
