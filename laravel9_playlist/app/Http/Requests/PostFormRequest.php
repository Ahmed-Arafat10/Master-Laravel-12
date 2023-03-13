<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        $rules = [
            'title' => 'required|max:255|unique:posts,title,' . $this->id ,
            'excerpt' => 'required',
            'body' => 'required',
            'image_path' => ['mimes:jpq,png,jpeg', 'max:5048'],
            'min_to_read' => 'min:0|max:60',
        ];

        # add required for image if the method is post ( in case of store() method )
        if (in_array($this->method(), ['POST'])) $rules['image_path'] = ['required', 'mimes:jpq,png,jpeg', 'max:5048'];
        //if($this->method() == 'POST') $rules['image'] = ['required','mimes:jpq,png,jpeg', 'max:5048'];
        return $rules;
    }
}
