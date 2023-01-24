<?php

namespace App\Http\Requests;

use Illuminate\contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RealtimeSaveRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'checklist_id' => 'exists:checklists,id',
            // 'check_item.*.no' => 'required|integer|min:1',
            'check_item.*.key' => 'required|string|max:32',
            'check_item.*.checklist_works_id' => 'required|string',
            // 'check_item.*.headline' => 'required|string',
            'check_item.*.user_id' => 'required|string|max:35',
            'check_item.*.val' => 'required|string|max:1',
            'check_item.*.memo' => 'required|string',
            'check_item.*.check_time' => 'required|integer',
        ];
    }
    public function faildValidation(Validator $validator) {
        $response = response()->json([
            'status' => 400,
            'errors' => $validator->errors(),
        ], 400);

        throw new HttpResponseException($response);
    }
}
