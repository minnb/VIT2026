<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name'    => 'nullable|string|max:191',
            'address' => 'nullable|string|max:191',
            'phone'   => 'nullable|string|max:191',
            'fax'     => 'nullable|string|max:50',
            'email'   => 'nullable|email|max:191',
        ];
    }
}
