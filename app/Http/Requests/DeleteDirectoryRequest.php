<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteDirectoryRequest extends FormRequest
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
        $path_rules = (new GetDirectoryRequest())->rules()['path'];
        $path_rules[] = function($attribute, $value, $fail) {

            if (($value == './') || ($value == '/'))
                return $fail('error');

        };
        
        return [
            'path' => $path_rules,
        ];
    }
}
