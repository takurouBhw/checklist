<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ZipCodeRule;

class StoreTaskRequest extends FormRequest
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
            'memo' => 'nullable|string|min:1',
            'title' =>  'required|string|min:1||max:100',
        ];
    }

    /**
     * バリデーションメッセージを取得する
     *
     * @return バリデーションメッセージの連想配列
     */
    // public function meessages()
    // {
    //     return [
    //     ];
    // }

    public function taskAttributes()
    {
        return $this->only([
            'memo',
            'title',
            'user_id',
        ]);
    }
}
