<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required'],
        ];
    }
    

    public function attributes()
    {
        return [
            'name' => 'お名前',
            'email' => 'メールアドレス',
            'password' => 'パスワード',
            'password_confirmation' => '確認用パスワード',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => ':attribute を入力してください',
            'email.required' => ':attribute を入力してください',
            'email.email' => ':attribute 形式で入力してください',
            'email.unique:users' => 'この :attribute は登録済みです 他の :attribute を入力してください',
            'password.required' => ':attribute を入力してください',
            'password.min:8' => ':attribute は8字以上で入力してください',
            'password.confirmed' => ':attribute が入力されていません',
            'password_confirmation.required' => ':attribute を入力してください',
        ];
    }
}
