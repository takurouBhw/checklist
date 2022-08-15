<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Rules\ZipCodeRule;

class UpdateCompanyRequest extends FormRequest
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
            'name' => 'required|max:100',
            'postal_code' =>  ['required', new ZipCodeRule()],
            'address' => 'required|max:255',
            'email' => 'required|email|unique:companies,email,' . $this->id . '|max:255',
            'phone' => 'required|max:15',
            'url' => 'url',
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
