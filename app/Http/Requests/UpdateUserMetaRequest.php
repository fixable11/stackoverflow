<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserMetaRequest extends FormRequest
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
            'inputData.meta.full_name' => 'required|regex:/^[a-z. ]+$/i',
            'inputData.meta.address' => 'nullable|regex:/^[0-9a-z\'\.,\-_ ]+$/i',
            'inputData.meta.nickname' => 'required|alpha_num',
            'inputData.meta.description' => 'nullable|regex:/^[0-9a-z.,+-_@ ]+$/i',
            'inputData.meta.number' => 'nullable|digits:12',
            'inputData.meta.social_links' => 'nullable',
            'inputData.meta.social_links.*.title' => 'required|alpha_num',
            'inputData.meta.social_links.*.url' => 'required|url',
            'inputData.meta.birthday' => 'nullable|date_format:Y-m-d',
            'inputData.meta.gender' => [
                'nullable',
                Rule::in(['male', 'female'])
            ]
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'inputData.meta.full_name' => 'Full name',
            'inputData.meta.address' => 'Address',
            'inputData.meta.nickname' => 'Nickname',
            'inputData.meta.description' => 'Description',
            'inputData.meta.number' => 'Number',
            'inputData.meta.social_links.*.title' => 'The social link title',
            'inputData.meta.social_links.*.url' => 'The social link url',
            'inputData.meta.birthday' => 'Birthday',
            'inputData.meta.gender' => 'Gender',
        ];
    }
}
