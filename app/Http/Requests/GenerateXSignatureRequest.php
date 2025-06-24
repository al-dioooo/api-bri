<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GenerateXSignatureRequest extends FormRequest
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
            'path' => 'required|string',
            'verb' => 'required|string|in:GET,POST,PUT,PATCH,DELETE',
            'token' => 'required|string',
            'client_key' => 'required|string',
            'timestamp' => 'required|string',
            'body' => 'nullable'
        ];
    }
}
