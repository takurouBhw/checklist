<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ZipCodeRule;

class StoreCompanyRequest extends FormRequest
{
    protected $redirect = '/';
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:100',
            'postal_code' =>  ['required', new ZipCodeRule()],
            'address' => 'required|max:255',
            'email' => 'required|email|unique:companies|max:255',
            'phone' => 'required|max:15',
            'url' => 'url',
        ];
    }

    /**
     * バリデーションメッセージを取得する
     *
     * @return バリデーションメッセージの連想配列
     */
    public function meessages()
    {
        return [
            'url' => '有効なURL形式で指定してください。',
            'postal_code' => '郵便番号はハイフンの最大８桁の数字を指定してください。',
            'phone' => '電話番号は15桁以下でハイフンなしの数字を指定してください。',
        ];
    }

    public function companyAttributes()
    {
        return $this->only([
            'name',
            'postal_code',
            'address',
            'email',
            'phone',
            'representative',
            'responsible',
            'url',
        ]);
    }
}
