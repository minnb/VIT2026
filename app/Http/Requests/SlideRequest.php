<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SlideRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'fileImage'   => 'required|array|max:10',
            'fileImage.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ];
    }

    public function attributes()
    {
        return ['fileImage.*' => 'ảnh slide'];
    }
}
