<?php
// ============================================================
// entry.php … 求職者の登録フォーム(ログイン不要 = 公開ページ)
// ============================================================
// 求職者が自分のプロフィールを入力する画面。
// このページ自体はDBに触らない「表示するだけ」のページで、
// 入力内容はフォームの送信先(action)である confirm.php に渡す。
// これはDay1〜2で学んだ「form → 処理するphp」の型そのもの。
//
// ※ h() を使いたいので funcs.php だけ読み込んでおく(DB接続はしない)
require_once('funcs.php');

// 「確認画面から修正で戻ってきた」場合に、前の入力値を復元するための準備。
// confirm.php の「修正する」ボタンは戻り先に値をGETで渡してくる想定。
$name       = isset($_GET['name'])       ? $_GET['name']       : '';
$job        = isset($_GET['job'])        ? $_GET['job']        : '';
$skill      = isset($_GET['skill'])      ? $_GET['skill']      : '';
$experience = isset($_GET['experience']) ? $_GET['experience'] : '';
$profile    = isset($_GET['profile'])    ? $_GET['profile']    : '';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>求職者登録 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    header { background: #333; color: #fff; padding: 16px 24px; }
    header a { color: #fff; }
    main { max-width: 600px; margin: 32px auto; padding: 24px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    h1 { font-size: 22px; margin-bottom: 4px; }
    .lead { color: #666; font-size: 14px; margin-bottom: 20px; }
    label { display: block; margin-bottom: 16px; font-size: 14px; color: #333; }
    input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    textarea { min-height: 100px; }
    .submit { padding: 10px 20px; background: #2a7; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    .back { display: inline-block; margin-top: 16px; font-size: 13px; }
</style>
</head>
<body>
    <header><a href="index.php">← 人材紹介トップ</a></header>
    <main>
        <h1>求職者 無料登録</h1>
        <p class="lead">あなたのプロフィールを登録すると、企業担当者があなたのスキルを閲覧できるようになります。</p>

        <!-- 送信先は confirm.php。まずは確認画面に内容を渡す -->
        <form method="POST" action="confirm.php">
            <label>
                お名前
                <input type="text" name="name" value="<?= h($name) ?>" placeholder="例：山田 太郎" required>
            </label>
            <label>
                希望職種
                <input type="text" name="job" value="<?= h($job) ?>" placeholder="例：フロントエンドエンジニア" required>
            </label>
            <label>
                スキル
                <input type="text" name="skill" value="<?= h($skill) ?>" placeholder="例：HTML / CSS / JavaScript / React" required>
            </label>
            <label>
                経験年数
                <input type="number" name="experience" value="<?= h($experience) ?>" min="0" placeholder="例：5" required>
            </label>
            <label>
                自己PR・詳細プロフィール
                <textarea name="profile" placeholder="これまでの経験やアピールポイントをご記入ください"><?= h($profile) ?></textarea>
            </label>
            <button type="submit" class="submit">確認画面へ</button>
        </form>
    </main>
</body>
</html>
