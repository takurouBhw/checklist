<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ZipCodeRule implements Rule
{
    public function __construct()
    {
    }

    /**
     * 郵便番号の書式バリデーション
     * 例 123-4567 以外はバリデーションエラー
     * @param [type] $attribute
     * @param [type] $value
     * @return void
     */
    public function passes($attribute, $value)
    {
        return preg_match('/\A\d{3}[-]\d{4}\z/', $value);
    }

    public function message()
    {
        return '郵便番号が正しくありません。123-4567の書式で指定してください。';
    }
}
