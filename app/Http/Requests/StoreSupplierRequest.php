<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreSupplierRequest extends Request
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
            'supplier_name' => 'required|unique:suppliers,name,null,status,status,1,uid,'. \Auth::user()->id,
            'contact' => 'required',
            'phone' => 'required',
            'email' => 'required|email'
        ];
    }
}
