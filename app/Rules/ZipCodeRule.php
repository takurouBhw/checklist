<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ZipCodeRule implements Rule
{
    public function __construct()
    {
    }

    public function passes($attribute, $value)
    {
        return preg_match('/\A\d{7}\z/', $value);
    }

    public function message()
    {
        return '郵便番号が正しくありません。';
    }
}
