<?php
// ============================================================
// edit.php … 人材データの編集フォーム(ログイン必須 = 会員専用)
// ============================================================
// 企業担当者(ログイン済み)が、登録済みの人材情報を修正する画面。
// detail.php の「編集する」ボタンから ?id=3 の形でGETされてくる。
// 対象1件をSELECTして、その値をフォームの初期値に埋め込む。
// 入力後の送信先(action)は update.php。
//
// ※ detail.php と同じく、先頭で loginCheck() を通す。
session_start();
require_once('funcs.php');
loginCheck(); // 未ログインならここで止まる(会員専用ページの証)

// detail.phpのリンクから ?id=3 の形でGETされてくる
$id = $_GET['id'];

// 1〜4. DB接続・SQL作成・実行・実行後の処理
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM gs_jinzai_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
}

// 該当idを1件だけ取得(存在しなければfalse)
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>人材情報の編集 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    header { background: #333; color: #fff; padding: 16px 24px; }
    header a { color: #fff; }
    main { max-width: 600px; margin: 32px auto; padding: 24px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    h1 { font-size: 22px; margin-bottom: 20px; }
    label { display: block; margin-bottom: 16px; font-size: 14px; color: #333; }
    input[type="text"], input[type="number"], textarea { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
    textarea { min-height: 100px; }
    .submit { padding: 10px 20px; background: #06c; color: #fff; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
    .back { display: inline-block; margin-top: 16px; font-size: 13px; }
</style>
</head>
<body>
    <header><a href="detail.php?id=<?= h($id) ?>">← 詳細に戻る</a></header>
    <main>
        <h1>人材情報の編集</h1>
        <?php if ($result): ?>
            <!-- 送信先は update.php。初期値には取得済みの値を入れておく -->
            <form method="POST" action="update.php">
                <label>
                    お名前
                    <input type="text" name="name" value="<?= h($result['name']) ?>" required>
                </label>
                <label>
                    職種
                    <input type="text" name="job" value="<?= h($result['job']) ?>" required>
                </label>
                <label>
                    スキル
                    <input type="text" name="skill" value="<?= h($result['skill']) ?>" required>
                </label>
                <label>
                    経験年数
                    <input type="number" name="experience" value="<?= h($result['experience']) ?>" min="0" required>
                </label>
                <label>
                    プロフィール
                    <textarea name="profile"><?= h($result['profile']) ?></textarea>
                </label>

                <!-- どのレコードを更新するかを伝えるため、idを必ずhiddenで送る -->
                <input type="hidden" name="id" value="<?= h($result['id']) ?>">
                <button type="submit" class="submit">更新する</button>
            </form>
        <?php else: ?>
            <p>該当する人材データが見つかりませんでした。</p>
        <?php endif; ?>
    </main>
</body>
</html>
