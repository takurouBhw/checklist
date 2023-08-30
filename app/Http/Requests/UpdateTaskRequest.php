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
            'memo' => 'nullable|string|min:1',
            'task_title' =>  'nullable|string|min:1||max:100',
            'is_done' =>  'nullable|boolean',
            'todo_id' => 'required|integer|min:0',
            'sort_no' => 'required|integer|min:0',
        ];
    }

    public function taskAttributes()
    {
        return $this->only([
            'title',
            'memo',
        ]);
    }
    public function taskPatchAttribute()
    {
        return $this->only([
            'is_done',
        ]);
    }
}
