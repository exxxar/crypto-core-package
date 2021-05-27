<?php

namespace Cryptolib\CryptoCore\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConnectionStoreRequest extends FormRequest
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

    public function messages()
    {
        return [
            'userId.required' => 'Поле user_id - должно присутстовать объязательно',
            'userId.min:2' => 'Длина user_id должена быть не меньше 2х символов',
            'userId.max:18' => 'Длина user_id должена быть не больше 512 символов',
            'deviceId.required' => 'Поле device_id объязательо',
            'deviceId.min:18' => 'Длина device_id должена быть не меньше 18 символов',
            'deviceId.max:18' => 'Длина device_id должена быть не больше 18 символов',
            //'active.required' => 'Поле active является объязательным',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "userId"=> ['required','min:2','max:512'],
            "deviceId"=> ['required', 'min:18','max:18'],
            //"active"=> ['required'],
        ];
    }
}
