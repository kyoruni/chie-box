FROM php:8.4.3-fpm-bookworm

# タイムゾーン設定
ENV TZ=Asia/Tokyo

# 必要なパッケージをインストール
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql

# Composer インストール
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.8.5

# 作業ディレクトリの作成
RUN mkdir -p /home/chie-box
WORKDIR /home/chie-box

# 権限の設定
RUN chown -R www-data:www-data /home/chie-box

# コンテナ起動時のデフォルトコマンド
CMD ["php-fpm"]