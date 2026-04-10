# chie-box

## 技術スタック
- PHP 8.4.3
- Laravel 13（laravel/laravel v13.1.2 / laravel/framework v13.4.0）
- PostgreSQL 17.4
- nginx 1.27
- Docker Compose

## ディレクトリ構成
```
chie-box/
├── Dockerfile            # PHP-FPM コンテナ
├── compose.yaml          # Docker Compose 設定
├── nginx/
│   ├── Dockerfile        # nginx コンテナ
│   └── default.conf      # nginx 設定（FastCGI で php:9000 に転送）
├── postgresql/
│   ├── Dockerfile        # PostgreSQL コンテナ
│   ├── init.sql          # DB 初期化（app スキーマ作成）
│   └── postgresql.conf   # PostgreSQL 設定（search_path = 'app, public'）
├── backend/              # Laravel アプリケーション
└── frontend/             # フロントエンド（未着手）
```

## 開発コマンド
```bash
# コンテナ起動
docker compose up -d --build

# PHP コンテナに入る（artisan, composer 等はここで実行）
docker compose exec php bash

# マイグレーション
docker compose exec php php artisan migrate

# DB 接続
docker compose exec db psql -U postgres -d chiebox

# コンテナ停止
docker compose down

# DB を初期化する場合（ボリューム削除）
docker compose down -v
```

## ルール
- AIはコミットを絶対にしない。ユーザーが手動でコミットする。
- 作業は1ステップずつ進める。1ステップ完了したらユーザーに確認を取る。ユーザーがコミットして話しかけたら、次の作業に進む。
