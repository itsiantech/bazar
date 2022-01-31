<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class AdminChatRequestStore extends FormRequest
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
            'id' => 'required|integer',
            'message' => 'required|max:191'
        ];
    }


    public function failedValidation(Validator $validator)
    {

        $response = response()->json([
            'response' => [
                'data' => [],
                'status' => 422,
                'errors' => $validator->errors(),
            ]
        ]);

        throw new ValidationException($validator, $response);
    }
}
