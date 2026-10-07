<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validate dung chung cho san pham / du an / tin tuc / tai lieu.
 *
 * Truoc day khong co bat ky validate nao trong toan du an: moi input di
 * thang vao DB va file upload duoc tin tuong theo phan mo rong do client gui.
 */
class PostRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'          => 'required|string|max:255',
            'description'   => 'nullable|string|max:5000',
            'content'       => 'nullable|string',
            'cate_id'       => 'nullable|integer|exists:categories,id',
            'fileImage'     => 'nullable|array|max:20',
            'fileImage.*'   => 'image|mimes:jpg,jpeg,png,gif,webp|max:4096',
        ];
    }

    public function attributes()
    {
        return [
            'name'        => 'tiêu đề',
            'description' => 'mô tả',
            'content'     => 'nội dung',
            'cate_id'     => 'danh mục',
            'fileImage.*' => 'hình ảnh',
        ];
    }
}
