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
        return false;
    }

    public function messages()
    {
        return [
            'user_id.required' => 'Поле user_id - должно присутстовать объязательно',
            'user_id.min:2' => 'Длина user_id должена быть не меньше 2х символов',
            'user_id.max:18' => 'Длина user_id должена быть не больше 512 символов',
            'device_id.required' => 'Поле device_id объязательо',
            'device_id.min:18' => 'Длина device_id должена быть не меньше 18 символов',
            'device_id.max:18' => 'Длина device_id должена быть не больше 18 символов',
            'active.required' => 'Доле active является объязательным',
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
            "user_id"=> ['required','min:2','max:512'],
            "device_id"=> ['required', 'min:18','max:18'],
            "active"=> ['required'],

        ];
    }
}
