<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
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
          'type' => 'required',
          'phone' => 'required|email|max:255|unique:users',
          'cost' => 'required|min:8|max:8',
          'order_by' => 'required',
        ];
    }
}
