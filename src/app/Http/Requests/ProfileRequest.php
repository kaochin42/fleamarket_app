<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'          => ['required', 'max:20'],
            'profile_img'   => ['mimes:jpeg,png'],
            'postcode'      => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address'       => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'          => 'ユーザー名は必須です',
            'name.max'          => 'ユーザー名は20文字以内で入力してください',
            'profile_img.mimes'            => '画像はjpegまたはpng形式にしてください',
            'postcode.required' => '郵便番号は必須です',
            'postcode.regex' => '郵便番号はハイフン(-)ありの８文字で入力してください',
            'address.required' => '住所は必須です',
        ];
    }
}
