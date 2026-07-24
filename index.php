<?php
// ============================================================
// index.php … 人材一覧ページ(ログイン不要 = 公開ページ)
// ============================================================
// このページ自体はloginCheck()を呼ばない。
// 「見るだけなら誰でもOK、詳細を見るには要ログイン」という
// 設計にしたいので、一覧ページはあえてログイン必須にしない。

// ログイン状態によって画面表示(ログイン/ログアウトリンク)を
// 切り替えたいので、SESSIONの中身を「見るだけ」のためにstartする。
session_start();

require_once('funcs.php');

// 1〜4. DB接続・SQL作成・実行・実行後の処理(お馴染みの4ブロック)
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM gs_jinzai_table ORDER BY id DESC');
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
}

// 一覧表示用のHTMLを組み立てる
$view = '';
while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<div class="card">';
    // detail.phpにidをGETで渡す(URLパラメータ)
    $view .= '<a href="detail.php?id=' . $result['id'] . '">';
    $view .= '<strong>' . h($result['name']) . '</strong>';
    $view .= '<span class="job">' . h($result['job']) . '</span>';
    $view .= '</a>';
    $view .= '<p class="skill">' . h($result['skill']) . '</p>';
    $view .= '<p class="exp">経験年数：' . h($result['experience']) . '年</p>';
    $view .= '</div>';
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>人材一覧 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    header { background: #333; color: #fff; padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; }
    header a { color: #fff; }
    main { max-width: 720px; margin: 32px auto; padding: 0 16px; }
    h1 { font-size: 22px; }
    .card { background: #fff; padding: 16px; margin-bottom: 12px; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    .card a { text-decoration: none; color: #222; display: flex; justify-content: space-between; }
    .job { color: #666; font-size: 14px; }
    .skill { color: #444; font-size: 14px; margin: 8px 0 4px; }
    .exp { color: #999; font-size: 12px; margin: 0; }
</style>
</head>
<body>
    <header>
        <span>人材紹介サイト</span>
        <?php if (isset($_SESSION['chk_ssid'])): ?>
            <!-- ログイン済みの場合の表示 -->
            <span>
                ログイン中
                <?php if (isset($_SESSION['kanri_flg']) && $_SESSION['kanri_flg'] == 1): ?>
                    (管理者)
                <?php endif; ?>
                | <a href="logout.php">ログアウト</a>
            </span>
        <?php else: ?>
            <!-- 未ログインの場合の表示 -->
            <a href="login.php">ログイン</a>
        <?php endif; ?>
    </header>
    <main>
        <h1>人材一覧</h1>
        <p style="color:#666; font-size:13px;">詳細情報の閲覧にはログインが必要です。</p>
        <?php if (empty($view)): ?>
            <p>まだ登録された人材がいません。</p>
        <?php else: ?>
            <?= $view ?>
        <?php endif; ?>
    </main>
</body>
</html>
