<?php

namespace App\Http\Requests;

use App\Services\Utils\JsonResponseFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class GuestRequestSendChatMessage extends JsonResponseFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'present|nullable|string|max:191|required_without:phone',
            'phone' => 'present|nullable|string|max:11|required_without:email',
            'message' => 'required|string|max:191',
        ];
    }


}
