<?php
// ============================================================
// insert.php … 登録処理(DBに1件INSERTする / ログイン不要)
// ============================================================
// confirm.php の「この内容で登録する」からPOSTされてくる。
// ここで初めてDBに書き込む。画面(HTML)は持たず、処理が終わったら
// thanks.php にリダイレクトする「処理専用ページ」。
//
// Day2で学んだDB操作の4ブロック(接続→SQL作成→実行→実行後)で書く。
require_once('funcs.php');

// 0. 直接アクセス対策
// このページは confirm.php からPOSTされて来る前提。ブラウザで直接開くなど
// 必要な項目が送られていない場合は、登録フォームに戻す。
if (!isset($_POST['name'], $_POST['job'], $_POST['skill'], $_POST['experience'], $_POST['profile'])) {
    redirect('entry.php');
}

// 1. POSTデータ取得
$name       = $_POST['name'];
$job        = $_POST['job'];
$skill      = $_POST['skill'];
$experience = $_POST['experience'];
$profile    = $_POST['profile'];

// 2. DB接続(funcs.phpのdb_conn()を呼ぶだけ)
$pdo = db_conn();

// 3. SQL作成・実行
// プレースホルダ(:name など)を使うのがSQLインジェクション対策の基本。
// 値を直接文字列に連結せず、bindValueで安全に埋め込む。
$stmt = $pdo->prepare(
    'INSERT INTO gs_jinzai_table (name, job, skill, experience, profile, indate)
     VALUES (:name, :job, :skill, :experience, :profile, sysdate())'
);
$stmt->bindValue(':name',       $name,       PDO::PARAM_STR);
$stmt->bindValue(':job',        $job,        PDO::PARAM_STR);
$stmt->bindValue(':skill',      $skill,      PDO::PARAM_STR);
$stmt->bindValue(':experience', $experience, PDO::PARAM_INT); // 数値はINT
$stmt->bindValue(':profile',    $profile,    PDO::PARAM_STR);
$status = $stmt->execute();

// 4. 実行後の処理
if ($status === false) {
    // 失敗時はfuncs.phpの共通エラー表示に任せる
    sql_error($stmt);
} else {
    // 成功したら「登録ありがとう」画面へ
    redirect('thanks.php');
}
