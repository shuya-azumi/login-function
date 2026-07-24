-- ==========================================================
--  人材紹介アプリ（Day4 課題）データベース定義 ★さくら本番用★
--
--  ローカル用（gs_db_jinzai.sql）との違い:
--    さくらでは DB をコントロールパネルで先に作成するため、
--    このファイルには CREATE DATABASE / USE を含めていません。
--
--  【使い方】
--  さくらの phpMyAdmin にログイン
--   → 左メニューで「さくらで作成したデータベース」を選択（重要）
--   → 上部メニュー「インポート」タブ
--   → 「ファイルを選択」でこの gs_db_jinzai_sakura.sql を選ぶ → 実行
--  （DBを選択した状態でインポートすれば、その中にテーブルが作られます）
-- ==========================================================

-- ----------------------------------------------------------
-- 1) 人材テーブル（一覧・詳細で表示するデータ）
-- ----------------------------------------------------------
DROP TABLE IF EXISTS gs_jinzai_table;
CREATE TABLE gs_jinzai_table (
  id          INT AUTO_INCREMENT PRIMARY KEY,   -- 主キー（自動連番）
  name        VARCHAR(50)  NOT NULL,            -- 氏名
  job         VARCHAR(50)  NOT NULL,            -- 職種
  skill       VARCHAR(255) NOT NULL,            -- スキル（一覧に表示）
  experience  INT          NOT NULL DEFAULT 0,  -- 経験年数
  profile     TEXT,                             -- 詳細プロフィール（詳細ページで表示）
  indate      DATETIME     DEFAULT CURRENT_TIMESTAMP -- 登録日時
) DEFAULT CHARACTER SET utf8mb4;

-- ----------------------------------------------------------
-- 2) ユーザーテーブル（ログイン用の会員）
-- ----------------------------------------------------------
DROP TABLE IF EXISTS gs_user_table;
CREATE TABLE gs_user_table (
  id         INT AUTO_INCREMENT PRIMARY KEY,    -- 主キー（自動連番）
  lid        VARCHAR(255) NOT NULL,             -- ログインID
  lpw        VARCHAR(255) NOT NULL,             -- パスワード（ハッシュ化して保存）
  kanri_flg  INT          NOT NULL DEFAULT 0    -- 権限 0:一般会員 1:管理者
) DEFAULT CHARACTER SET utf8mb4;

-- ----------------------------------------------------------
-- 3) 人材のサンプルデータ
-- ----------------------------------------------------------
INSERT INTO gs_jinzai_table (name, job, skill, experience, profile) VALUES
('山田 太郎', 'フロントエンドエンジニア', 'HTML / CSS / JavaScript / React', 5,
 '受託開発会社で5年間、主にReactを使ったWebアプリのフロント開発を担当。UI設計から実装まで一貫して対応できます。'),
('鈴木 花子', 'バックエンドエンジニア', 'PHP / MySQL / Laravel', 3,
 'ECサイトのバックエンド開発を3年経験。PHPとMySQLが得意で、PDOを使った安全なDB操作を心がけています。'),
('佐藤 次郎', 'インフラエンジニア', 'AWS / Docker / Linux', 7,
 'クラウドインフラの構築・運用を7年担当。AWS上でのサーバー構築やDockerでの環境構築が専門です。'),
('田中 美咲', 'UI/UXデザイナー', 'Figma / Photoshop / Illustrator', 4,
 'Web・アプリのUIデザインを4年経験。Figmaでのプロトタイピングとデザインシステム構築が得意です。');

-- ----------------------------------------------------------
-- 4) ユーザーのサンプルデータ（パスワードはハッシュ化済み）
--
--   ログインID  パスワード    権限
--   admin       admin123     管理者(kanri_flg=1)
--   yamada      pass1234     一般会員(kanri_flg=0)
--   suzuki      pass5678     一般会員(kanri_flg=0)
-- ----------------------------------------------------------
INSERT INTO gs_user_table (lid, lpw, kanri_flg) VALUES
('admin',  '$2y$10$fT3a0p/diNlzAGihCgCyNe9NnwVdgJDCvNQ75CvZrtl.PvYnBqztq', 1),
('yamada', '$2y$10$P1./rvR9jn3hBlAdP9KY0u9uy4c.fWnnEzKlWB45BbzYv9G9kkJ2W', 0),
('suzuki', '$2y$10$PXac4MBY8TE.r8AtTs7qpux/ItGkd5XkULJgqRSA/0rAXNOHvESue', 0);
