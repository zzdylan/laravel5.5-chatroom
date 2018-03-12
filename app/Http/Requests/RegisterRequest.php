<?php

namespace App\Http\Requests;

use Dingo\Api\Http\FormRequest;

class RegisterRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'username' => 'required|max:10|unique:users',
            'password' => 'required|between:6,18',
        ];
    }

    public function messages() {
        return [
            'username.required' => '请填写用户名',
            'username.unique' => '该用户名已经被注册',
            'password.required' => '请填写密码',
            'password.between' => '密码为6~18位',
        ];
    }

}
