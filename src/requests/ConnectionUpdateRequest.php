<?php

namespace Cryptolib\CryptoCore\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectionUpdateRequest extends FormRequest
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
            "userId"=> ['required'],
            "trustedDevicePublicId"=> ['required'],
            //"active"=> ['required'],
        ];
    }
}
