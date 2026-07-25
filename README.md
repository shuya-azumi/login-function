# 人材紹介アプリ（G's Academy PHP課題 Day2・Day3・Day4 統合版）

素のPHP＋MySQL（PDO）で作った人材紹介サービス。
**求職者**が自分を登録し、**企業担当者**がログインして人材を閲覧・管理する、2つの主体を持つアプリです。
授業の Day2（DB入門）・Day3（CRUD）・Day4（ログイン）の課題を、バラバラにせず1つのアプリに統合しています。

---

## 1. 2つの主体と画面の流れ

### 求職者側（公開・ログイン不要）＝ CRUDの「C（登録）」
```
entry.php（登録フォーム）
  → confirm.php（確認画面）
    → insert.php（DBにINSERT）
      → thanks.php（完了）
```

### 企業側（会員専用・ログイン必須）＝ CRUDの「R・U・D」
```
login.php → login_act.php（ログイン）
index.php（人材一覧 / R：SELECT 全件）※一覧は公開
  → detail.php（詳細 / R：SELECT 1件）
      → edit.php（編集フォーム）→ update.php（U：UPDATE 1件）
      → delete.php（D：DELETE 1件）
```

---

## 2. 授業課題との対応（どのファイルが何の要件か）

| 課題 | 要件 | 担当ファイル |
|---|---|---|
| **Day2** DB入門 | INSERT | `entry.php` → `confirm.php` → `insert.php` |
| **Day2** DB入門 | SELECT（一覧） | `index.php` |
| **Day2** DB入門 | PDO＋プレースホルダ | 全PHP（`bindValue`を使用） |
| **Day3** CRUD | 詳細表示 | `detail.php` |
| **Day3** CRUD | UPDATE | `edit.php` → `update.php` |
| **Day3** CRUD | DELETE | `delete.php` |
| **Day3** CRUD | コードの関数化 | `funcs.php`（`db_conn` / `sql_error` / `redirect` / `h`） |
| Day4 ログイン | セッション・権限・ハッシュ | `login.php` / `login_act.php` / `logout.php` / `loginCheck()` |

すべてのDB操作は授業で習った **4ブロック構造**（1.DB接続 → 2.SQL作成 → 3.実行 → 4.実行後の処理）で書いています。

---

## 3. ローカル（XAMPP）での動かし方

1. **XAMPP を起動** — Apache と MySQL を Start。
2. **DBをインポート** — `http://localhost/phpmyadmin` を開き、「インポート」タブから
   `SQL/gs_db_jinzai.sql` を選んで実行。`gs_db_jinzai` DB とサンプルデータが作られます。
3. **`db_config.php` を用意する** ← 初回のみ
   `db_config.php` は認証情報を含むため `.gitignore` で除外されており、リポジトリには含まれていません。
   `db_config.sample.php` をコピーして `db_config.php` という名前で保存し、中身を次のローカル用の値に
   書き換えてください:
   ```php
   return [
       'db_name' => 'gs_db_jinzai',
       'db_id'   => 'root',
       'db_pw'   => '',
       'db_host' => 'localhost',
   ];
   ```
   さくら本番サーバーにデプロイする際は、`db_name` / `db_id` / `db_pw` / `db_host` を
   さくらのコントロールパネルで発行された値に書き換えてから、FTPで（Git経由ではなく）アップロードします。
4. **ブラウザで開く**
   - 求職者登録：`http://localhost/jinzai_app/entry.php`
   - 人材一覧：`http://localhost/jinzai_app/index.php`
   - 企業ログイン：`http://localhost/jinzai_app/login.php`
     （ログインID `admin` / パスワード `admin123`）

---

## 4. 課題の提出について

- **課題2・課題3ともに、同じGitHubリポジトリのURLを提出する**
  （`https://github.com/shuya-azumi/login-function`）。
  このリポジトリ自体がDay3時点の完成形であり、Day2で要求されるCreate（INSERT）・Read（SELECT）は
  そのままこの中に含まれているため、別リポジトリやスナップショットを分ける必要はない。
- 要件とファイルの対応は「2. 授業課題との対応」の表を参照。説明を求められたときはこの表の通りに
  対応関係を辿れば良い。
- `.sql` ファイル（`SQL/gs_db_jinzai.sql`）はリポジトリに含まれているため、URLを提出すればそのまま
  確認してもらえる。別途ファイルを添付する必要はない。
- `db_config.php` は認証情報を含むため **提出・push しません**（`.gitignore` で除外済み。雛形の
  `db_config.sample.php` だけ公開されます）。

---

## 5. セキュリティ・設計メモ

- **SQLインジェクション対策**：値は文字列連結せず `prepare` ＋ `bindValue`（プレースホルダ）。
- **XSS対策**：画面出力は必ず `h()`（`htmlspecialchars`）を通す。
- **WHERE忘れ対策**：UPDATE / DELETE には必ず `WHERE id = :id`。削除は `confirm()` で最終確認。
- **削除はPOST**：GETで消えないように、削除は必ず `<form method="POST">`。
- **個人情報**：公開デモにはダミーデータのみを入れる（実在の連絡先を入れない）。

---

## 6. 今後の統合ステップ（課題の先）

- 既存の面接日程調整アプリ（Firebase製 scheduler）を、`detail.php` に
  「面接日程を調整する」ボタンとして接続（人材ごとに room URL を紐付け）。移植はしない。
- トップに「求職者はこちら／企業はこちら」の2導線を整理。
- 本番（さくら）反映時は `db_config.php` を本番値に戻して FTP アップロード。
