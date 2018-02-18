<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UserFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' =>
                [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    Rule::unique('users','email')
                        ->ignore($this->id,'id')
                ],
            'password' => 'nullable|min:6|confirmed',
            'role' =>
                [
                    'required',
                    Rule::in(['user','admin'])
                ]
        ];
    }

    public function messages(){
        return [
            'name.required' => 'Insert a name',
            'role.required' => 'Insert a role',
            'email.required' => 'Insert an email',
            'email.unique' => 'Email must be unique'

        ];
    }
}
