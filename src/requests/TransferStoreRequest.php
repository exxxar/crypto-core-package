<?php

namespace Cryptolib\CryptoCore\Requests;

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
            "senderUserId"=> ['required','min:2','max:512'],
            "recipientUserId"=> ['required','min:2','max:512'],
            "data"=> ['required'],
            // С ПУ не приходит
            //"status"=> ['required'],
        ];
    }
}
