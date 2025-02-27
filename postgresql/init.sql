CREATE SCHEMA IF NOT EXISTS app;

CREATE TABLE IF NOT EXISTS "app"."users" (
    id SERIAL,
    name VARCHAR(31) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP WITH TIME ZONE NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY ("id"),
    UNIQUE ("name"),
    UNIQUE ("email")
);

COMMENT ON TABLE  "app"."users"              IS 'ユーザー';
COMMENT ON COLUMN "app"."users"."id"         IS 'ID';
COMMENT ON COLUMN "app"."users"."name"       IS 'ユーザー名';
COMMENT ON COLUMN "app"."users"."email"      IS 'メールアドレス';
COMMENT ON COLUMN "app"."users"."password"   IS 'パスワード';
COMMENT ON COLUMN "app"."users"."created_at" IS '作成日時';
COMMENT ON COLUMN "app"."users"."updated_at" IS '更新日時';
