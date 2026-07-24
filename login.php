<?php
// このページ自体はDBにアクセスしない「表示するだけ」のページ。
// フォームの送信先(action)がlogin_act.phpになっている点に注目。
// これはDay1〜2で学んだ「form → 処理するphp」の型そのもの。
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>ログイン | 人材紹介</title>
<style>
    body { font-family: sans-serif; background: #f5f5f5; }
    .login-box { max-width: 360px; margin: 80px auto; background: #fff; padding: 32px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
    h1 { font-size: 20px; margin-bottom: 24px; }
    label { display: block; margin-bottom: 16px; font-size: 14px; }
    input[type="text"], input[type="password"] { width: 100%; padding: 8px; margin-top: 4px; box-sizing: border-box; }
    input[type="submit"] { width: 100%; padding: 10px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; }
</style>
</head>
<body>
    <div class="login-box">
        <h1>会員ログイン</h1>
        <form method="POST" action="login_act.php">
            <label>
                ログインID
                <input type="text" name="lid" required>
            </label>
            <label>
                パスワード
                <input type="password" name="lpw" required>
            </label>
            <input type="submit" value="ログイン">
        </form>
        <p style="margin-top:16px;"><a href="index.php">一覧に戻る</a></p>
    </div>
</body>
</html>
