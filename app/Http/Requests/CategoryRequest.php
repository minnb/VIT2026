<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:200',
            'sort' => 'nullable|integer|min:0|max:9999',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'tên danh mục',
            'sort' => 'thứ tự',
        ];
    }
}
