# Laraveによる駅選択サイト

## 目的

本サイトの利用者は目当ての鉄道駅を選択できる

## 機能要件

- 鉄道情報は以下の情報からなる
    - 鉄道会社
    - 路線
    - 駅
- 鉄道情報はあらかじめ公開日時および非公開を定めることができ、アクセス日時によって時限的に変更が適用されること
- 鉄道情報の変更の日時と内容を証跡として保持すること
- 認証および認可機能は不要とする

## 非機能要件

- データベースの変更操作はレコードの追加のみを行い、レコードの変更および削除は行わないこと

## 便利なコマンドメモ

php artisan migrate:refresh
php artisan migrate:refresh --database railway_testing

php artisan db:seed --class=TruncateSeeder
php artisan db:seed --class=LocalSeeder

APP_ENV=testing php artisan test
APP_ENV=testing php artisan test tests/Feature/Admin/RailwayStation/ControllerCreateTest.php

php artisan serv

php artisan queue:work
