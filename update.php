<?php
// ============================================================
// update.php … 更新処理(DBを1件UPDATEする / ログイン必須)
// ============================================================
// edit.php のフォームからPOSTされてきた内容で、idを条件に1件だけ
// 上書きする「処理専用ページ」。画面は持たず、終わったら
// 詳細ページ(detail.php)へ戻す。
//
// 【超重要】UPDATEは必ず WHERE id = :id を付ける。
// これを忘れると全件が同じ値に書き換わる「WHERE忘れ事故」になる。
session_start();
require_once('funcs.php');
loginCheck(); // 会員専用

// 1. POSTデータ取得(edit.phpのinputと対応。idも受け取る)
$name       = $_POST['name'];
$job        = $_POST['job'];
$skill      = $_POST['skill'];
$experience = $_POST['experience'];
$profile    = $_POST['profile'];
$id         = $_POST['id'];

// 2. DB接続
$pdo = db_conn();

// 3. SQL作成・実行(UPDATE。SETで各カラムを更新し、WHEREで対象を1件に絞る)
$stmt = $pdo->prepare(
    'UPDATE gs_jinzai_table
        SET name = :name, job = :job, skill = :skill,
            experience = :experience, profile = :profile
      WHERE id = :id'
);
$stmt->bindValue(':name',       $name,       PDO::PARAM_STR);
$stmt->bindValue(':job',        $job,        PDO::PARAM_STR);
$stmt->bindValue(':skill',      $skill,      PDO::PARAM_STR);
$stmt->bindValue(':experience', $experience, PDO::PARAM_INT);
$stmt->bindValue(':profile',    $profile,    PDO::PARAM_STR);
$stmt->bindValue(':id',         $id,         PDO::PARAM_INT);
$status = $stmt->execute();

// 4. 実行後の処理
if ($status === false) {
    sql_error($stmt);
} else {
    // 更新した本人の詳細ページに戻す(結果をすぐ確認できる)
    redirect('detail.php?id=' . $id);
}
