<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AlbumRequest extends FormRequest
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
            'name' => 'required|unique:albums,album_name',
           // 'description' => 'required',
            'album_thumb' => 'required|image'
            //'user_id' => 'required|digit|exists:users'
    ];
    }

    public function messages(){
        return [
            'name.required' => 'Insert a name',
            'name.unique' => 'This name is already present',
          //  'description.required' => 'Insert a description',
            'album_thumb.required' => 'Insert an image file',
            'album_thumb.image' => 'Format file non correct: insert an image file'

        ];
    }
}
