<?php
// ============================================================
// confirm.php … 登録内容の確認画面(ログイン不要 = 公開ページ)
// ============================================================
// entry.php から POST されてきた内容を「この内容で登録しますか？」と
// 見せる画面。まだDBには保存しない。
// ・「この内容で登録する」→ insert.php にPOSTして本当に保存する
// ・「修正する」→ entry.php に戻る(入力値を付けて戻す)
//
// このページも表示が主目的なので、h() のために funcs.php だけ読み込む。
require_once('funcs.php');

// 1. POSTデータ取得(entry.phpのinputのname属性と対応)
$name       = isset($_POST['name'])       ? $_POST['name']       : '';
$job        = isset($_POST['job'])        ? $_POST['job']        : '';
$skill      = isset($_POST['skill'])      ? $_POST['skill']      : '';
$experience = isset($_POST['experience']) ? $_POST['experience'] : '';
$profile    = isset($_POST['profile'])    ? $_POST['profile']    : '';

// 2. かんたんな入力チェック(バリデーション)
// 必須項目が空、または経験年数が数字でない場合は entry.php に戻す。
// 入力済みの値はGETに載せて戻すので、やり直し時に消えない。
$errors = [];
if ($name === '')  { $errors[] = 'お名前'; }
if ($job === '')   { $errors[] = '希望職種'; }
if ($skill === '') { $errors[] = 'スキル'; }
if ($experience === '' || !ctype_digit((string)$experience)) { $errors[] = '経験年数(数字)'; }

if (!empty($errors)) {
    // 入力値を引き継いで登録フォームへ戻す
    $params = http_build_query([
        'name'       => $name,
        'job'        => $job,
        'skill'      => $skill,
        'experience' => $experience,
        'profile'    => $profile,
    ]);
    redirect('entry.php?' . $params);
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>登録内容の確認 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    header { background: #333; color: #fff; padding: 16px 24px; }
    header a { color: #fff; }
    main { max-width: 600px; margin: 32px auto; padding: 24px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    h1 { font-size: 22px; margin-bottom: 20px; }
    dl { margin: 0 0 24px; }
    dt { color: #999; font-size: 13px; margin-top: 12px; }
    dd { margin: 0; font-size: 15px; }
    .actions { display: flex; gap: 12px; align-items: center; }
    .submit { padding: 10px 20px; background: #2a7; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    .edit { padding: 10px 20px; background: #eee; color: #333; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
</style>
</head>
<body>
    <header><span>登録内容の確認</span></header>
    <main>
        <h1>この内容で登録しますか？</h1>
        <dl>
            <dt>お名前</dt>          <dd><?= h($name) ?></dd>
            <dt>希望職種</dt>        <dd><?= h($job) ?></dd>
            <dt>スキル</dt>          <dd><?= h($skill) ?></dd>
            <dt>経験年数</dt>        <dd><?= h($experience) ?>年</dd>
            <dt>自己PR</dt>          <dd><?= nl2br(h($profile)) ?></dd>
        </dl>

        <div class="actions">
            <!-- 本当に登録する。hiddenで全項目を insert.php にPOSTで渡す -->
            <form method="POST" action="insert.php">
                <input type="hidden" name="name"       value="<?= h($name) ?>">
                <input type="hidden" name="job"        value="<?= h($job) ?>">
                <input type="hidden" name="skill"      value="<?= h($skill) ?>">
                <input type="hidden" name="experience" value="<?= h($experience) ?>">
                <input type="hidden" name="profile"    value="<?= h($profile) ?>">
                <button type="submit" class="submit">この内容で登録する</button>
            </form>

            <!-- 修正する。入力値を付けて entry.php に戻す -->
            <form method="GET" action="entry.php">
                <input type="hidden" name="name"       value="<?= h($name) ?>">
                <input type="hidden" name="job"        value="<?= h($job) ?>">
                <input type="hidden" name="skill"      value="<?= h($skill) ?>">
                <input type="hidden" name="experience" value="<?= h($experience) ?>">
                <input type="hidden" name="profile"    value="<?= h($profile) ?>">
                <button type="submit" class="edit">修正する</button>
            </form>
        </div>
    </main>
</body>
</html>
