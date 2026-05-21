<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'image'        => ['required', 'mimes:jpeg,png'],
            'categories'   => ['required'],
            'condition_id' => ['required'],
            'name'         => ['required'],
            'description'  => ['required', 'max:255'],
            'price'        => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image.required'         => '商品画像は必須です',
            'image.mimes'            => '画像はjpegまたはpng形式にしてください',
            'categories.required'    => 'カテゴリーを選択してください',
            'condition_id.required'  => '商品の状態を選択してください',
            'name.required'          => '商品名は必須です',
            'description.required'   => '商品説明は必須です',
            'description.max'        => '商品説明は255文字以内にしてください',
            'price.required'         => '販売価格は必須です',
            'price.numeric'          => '販売価格は数値で入力してください',
            'price.min'              => '販売価格は0円以上にしてください',
        ];
    }
}

