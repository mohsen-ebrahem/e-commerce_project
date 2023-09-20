<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlaceOrderRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name'=>'bail|required|max:200',
            'city'=>'bail|required',
            'address'=>'bail|required|regex:/[A-Za-z]+([\,]([A-Za-z]+))*/',
            'tel'=>'bail|required|max:10|regex:/^(0)\d{9}/',
            'mobile'=>'bail|required|max:10|regex:/(^09\d{8})/',
            'note'=>'bail|required|max:500'
        ];
    }
}
