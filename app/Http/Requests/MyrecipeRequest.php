<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MyrecipeRequest extends FormRequest
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
            'user_id' => ['nullable', 'required_without:recipe_id',],
            'recipe_id' => ['nullable', 'required_without:user_id'],
            'title' => ['required'],
            'url' => ['nullable', 'required_without:recipe', 'url', ],
            'recipe' => ['nullable', 'required_without:url'],
        ];
    }

    public function attributes()
    {
        return [
            'title' => 'タイトル',
            'url' => 'URL',
            'recipe' => 'レシピ',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => ':attribute を入力してください',
            'url.required_without' => ':attribute もしくはレシピどちらかを入力してください',
            'url.url' => ':attribute 形式で入力してください',
            'recipe.required_without' => ':attribute もしくはURLどちらかを入力してください',
        ];
    }
}
