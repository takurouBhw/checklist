<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ZipCodeRule;

class UpdateTaskRequest extends FormRequest
{
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
            'memo' => 'required|string|min:1',
            'title' =>  'required|string|min:1||max:100',
        ];
    }

    public function taskAttributes()
    {
        return $this->only([
            'title',
            'memo',
        ]);
    }
}
