#!/bin/sh

while read line
do
    php artisan make:controller "${line}Controller" -rR
    php artisan make:factory "${line}Factory" --model=${line}
    php artisan make:model $line -m
    # モデルテストLesson
    php artisan make:test --unit "Models/${line}Test"
    # コントローラテスト
    php artisan make:test "Http/Controllers/${line}ControllerTest"
done < tables.txt
