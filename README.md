# kyoruni/chie-box

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