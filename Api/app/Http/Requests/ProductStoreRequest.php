<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        if(request()->isMethod('post')){

            return [
                'name' => 'required|string|max:258',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
            ];
        }else{

            return [
                'name' => 'required|string|max:258',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description' => 'required|string',
            ];
        }
    }
    public function messages()
    {
        if(request()->isMethod('post')){

            return [
                'name.required' => 'É obrigatório adicionar um nome!',
                'image.required' => 'É obrigatório adicionar uma imagem!',
                'description.required' => 'É obrigatório existir uma descrição!',
            ];
        }else{

            return [
                'name.required' => 'É obrigatório adicionar um nome!',
                'description.required' => 'É obrigatório existir uma descrição!',
            ];
        }
    }
}
