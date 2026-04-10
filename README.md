# kyoruni/chie-box

## セットアップ

```bash
# 環境設定ファイルをコピー
$ cp backend/.env.example backend/.env
$ cp backend/.env.testing.example backend/.env.testing

# コンテナ起動
$ docker compose up -d --build

# APP_KEY 生成
$ docker compose exec php php artisan key:generate
$ docker compose exec php php artisan key:generate --env=testing

# マイグレーション & シード
$ docker compose exec php php artisan migrate --seed
```

## 起動方法

```bash
$ docker compose up -d
```

## テスト

```bash
$ docker compose exec php composer test
```

## DB

```bash
$ docker compose exec db psql -U postgres -d chiebox
```
