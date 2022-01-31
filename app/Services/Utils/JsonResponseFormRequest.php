<?php
namespace App\Services\Utils;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class JsonResponseFormRequest extends FormRequest
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
