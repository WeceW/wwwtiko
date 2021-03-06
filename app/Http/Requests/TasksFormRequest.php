<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class TasksFormRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
        #return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'solution' => 'required|start_with_sql_command|even_brackets|semicolon_at_end|semicolon_max:1',
            'type' => 'required',
        ];
    }
}
