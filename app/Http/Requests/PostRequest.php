<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'recipe_id' => ['required'],
            'image_id' => ['required'],
            'title' => ['required'],
            'recipe' => ['required'],
        ];
    }

    public function attributes()
    {
        return [
            'image_id' => 'レシピの画像',
            'recipe' => 'レシピ',
        ];
    }

    public function messages()
    {
        return [
            'image_id.required' => ':attribute は必須です。画像を編集してください',
            'recipe.required' => ':attribute は必須です。レシピを編集してください',
        ];
    }
}
