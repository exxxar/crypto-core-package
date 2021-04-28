<?php

namespace CryptoCore\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransferStoreRequest extends FormRequest
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
            "sender_user_id"=> ['required'],
            "recipient_user_id"=> ['required'],
            "data"=> ['required'],
            "status"=> ['required'],
        ];
    }
}
