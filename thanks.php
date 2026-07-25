<?php
// ============================================================
// thanks.php … 登録完了画面(ログイン不要 = 公開ページ)
// ============================================================
// insert.php での保存が成功した後に表示する「ありがとう」画面。
// 求職者に他の登録者一覧は見せたくないので、insert後はここへ来る。
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>登録完了 | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; margin: 0; }
    main { max-width: 480px; margin: 80px auto; padding: 40px 24px; background: #fff; border-radius: 8px; box-shadow: 0 1px 4px rgba(0,0,0,0.1); text-align: center; }
    h1 { font-size: 22px; color: #2a7; }
    p { color: #555; font-size: 15px; line-height: 1.7; }
    a { display: inline-block; margin-top: 20px; color: #06c; }
</style>
</head>
<body>
    <main>
        <h1>登録が完了しました</h1>
        <p>ご登録ありがとうございます。<br>
           企業担当者があなたのプロフィールを確認します。</p>
        <a href="entry.php">続けて別の内容を登録する</a>
    </main>
</body>
</html>
