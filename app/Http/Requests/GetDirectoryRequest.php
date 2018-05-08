<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class GetDirectoryRequest extends FormRequest
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
            'path' => [
                'required',
                function($attribute, $value, $fail) {

                    if (($value != './') && ($value != '/') && (!Storage::disk('public')->exists($value)))
                        return $fail('error');

                },
                function($attribute, $value, $fail) {

                    if (!File::isDirectory(Storage::disk('public')->path($value)))
                        return $fail('error');

                }
            ]
        ];
    }
}
