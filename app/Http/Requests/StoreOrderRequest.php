<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreOrderRequest extends Request
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
            'order_sn' => 'required|unique:order,order_sn,null,null,uid,' . \Auth::id() ,
            'order_express_price' => 'required',
            'order_date' => 'required|date',
            'order_platform' => 'required|exists:platform,id',
            'order_status' => 'required|exists:status,id',
            'order_buyer_name' => 'required',
            'order_buyer_phone' => 'required',
            'order_buyer_address' => 'required',
            'sku' => 'required'
        ];
    }
}
