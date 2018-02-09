<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Models\Album;

class AlbumUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $album = Album::find($this->id);
        if(\Gate::denies('manage-album', $album)){
            return false;
        }
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
            'name' => 'required',
            'name' => Rule::unique('albums','album_name')->ignore($this->id,'id'),
            'description' => 'required'
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Insert a name',
            'description.required' => 'Insert a description'
        ];
    }
}
