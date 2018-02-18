<?php

namespace App\Http\Requests;

use Auth;
use Illuminate\Foundation\Http\FormRequest;

class AlbumCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //'category_name' => 'required|unique:album_categories,category_name'
            'category_name' => 'required'

        ];
    }

    public function messages()
    {
        return [
            'category_name.required' => 'Insert the category name',
            //'category_name.unique' => 'This category name is already present'
        ];
    }

}
