<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreProductRequest extends Request
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
            'product_name' => 'required',
            'cid' => 'required|exists:attribute,cid,uid,' . \Auth::id(),
            'sid' => 'required|exists:suppliers,id,uid,' . \Auth::id(),
            'sn' => 'unique:product,sn,null,null,uid,' . \Auth::id() ,
            'sku' => 'required',
            'resource' => 'required'
        ];
    }
}
