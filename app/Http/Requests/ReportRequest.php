<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportRequest extends FormRequest
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
            'user_id' => ['required'],
            'post_id' => ['required'],
            'coment' => ['required', 'max:32'],
        ];
        
    }

    public function attributes()
    {
        return [
            'coment' => 'コメント',
        ];
        
    }

    public function  messages()
    {
        return [
            'coment.required' => ':attribute を入力してください',
            'coment.max' => ':attribute は32文字以内で入力してください',
        ];
        
    }
}
