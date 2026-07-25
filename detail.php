<?php
// ============================================================
// detail.php … 人材詳細ページ(ログイン必須 = 会員専用ページ)
// ============================================================
// index.phpとの一番の違いは、ここで loginCheck() を呼ぶこと。
// これを通過できない(=未ログインの)人は、この先の処理に
// 一切進めず、その場でexitされる。

session_start();

require_once('funcs.php');

// ここが「会員専用ページ」であることの唯一の証。
// 未ログインならここで処理が止まり、'LOGIN ERROR'が表示される。
loginCheck();

// index.phpのリンクから ?id=3 のような形でGETされてくる
$id = $_GET['id'];

// 1〜4. DB接続・SQL作成・実行・実行後の処理
$pdo = db_conn();
$stmt = $pdo->prepare('SELECT * FROM gs_jinzai_table WHERE id = :id');
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$status = $stmt->execute();

if ($status === false) {
    sql_error($stmt);
}

// 該当idが1件だけ取得できる(存在しなければfalse)
$result = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>人材詳細 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    header { background: #333; color: #fff; padding: 16px 24px; }
    header a { color: #fff; }
    main { max-width: 600px; margin: 32px auto; padding: 24px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); }
    h1 { font-size: 22px; margin-bottom: 4px; }
    .job { color: #666; margin-bottom: 16px; }
    dl { margin: 0; }
    dt { color: #999; font-size: 13px; margin-top: 12px; }
    dd { margin: 0; font-size: 15px; }
    .back { display: inline-block; margin-top: 20px; }
    .actions { margin-top: 24px; display: flex; gap: 12px; align-items: center; }
    .edit-btn { background: #06c; color: #fff; text-decoration: none; padding: 8px 18px; border-radius: 4px; font-size: 14px; }
    .delete-btn { background: #d33; color: #fff; border: none; padding: 8px 18px; border-radius: 4px; font-size: 14px; cursor: pointer; }
</style>
</head>
<body>
    <header><a href="index.php">← 一覧に戻る</a></header>
    <main>
        <?php if ($result): ?>
            <h1><?= h($result['name']) ?></h1>
            <p class="job"><?= h($result['job']) ?></p>
            <dl>
                <dt>スキル</dt>
                <dd><?= h($result['skill']) ?></dd>
                <dt>経験年数</dt>
                <dd><?= h($result['experience']) ?>年</dd>
                <dt>プロフィール</dt>
                <dd><?= nl2br(h($result['profile'])) ?></dd>
            </dl>

            <!-- ここは会員専用ページ。企業担当者だけが編集・削除できる -->
            <div class="actions">
                <!-- 編集は edit.php へ。idをGETで渡す -->
                <a class="edit-btn" href="edit.php?id=<?= h($result['id']) ?>">編集する</a>

                <!-- 削除は必ずPOSTで。onsubmitで最終確認をはさむ -->
                <form method="POST" action="delete.php" onsubmit="return confirm('この人材データを削除します。よろしいですか？');">
                    <input type="hidden" name="id" value="<?= h($result['id']) ?>">
                    <button type="submit" class="delete-btn">削除する</button>
                </form>
            </div>
        <?php else: ?>
            <p>該当する人材データが見つかりませんでした。</p>
        <?php endif; ?>
    </main>
</body>
</html>
