<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;

use Illuminate\Http\Exceptions\HttpResponseException;

use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users'),
            ],
            'phone' => [
                'required',
                'regex:/^(0?)(3[2-9]|5[6|8|9]|7[0|6-9]|8[0-6|8|9]|9[0-4|6-9])[0-9]{7}$/',
                Rule::unique('users'),
            ],
            'password' => [
                'required',
                'min:6',
                'confirmed',
            ],
            // 'password_confirmation' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute không được để trống',
            'string' => ':attribute phải là ký tự',
            'unique' => ':attribute đã tồn tại',
            'email' => ':attribute không đúng địng dạng',
            'regex' => ':attribute không đúng định dạng',
            'min' => ':attribute phải lớn hơn :min ký tự',
            'confirmed' => ':attribute không trùng khớp',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Tên tài khoản',
            'email' => 'Email',
            'phone' => 'Số điện thoại',
            'password' => 'Mật khẩu',
            // 'password_confirmation' => 'Mật khẩu nhập lại'
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response() -> json([$validator -> errors()], 402));
    }
}
