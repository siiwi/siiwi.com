<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models;

class AttributeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $attribute_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($attribute_id, Request $request)
    {
        $response = Models\AttributeValue::create(['attribute_id' => $attribute_id, 'value' => $request->get('value')]) ? ['code' => 1, 'title'=> '恭喜！', 'message' => '添加规格值成功'] : ['code' => 0, 'title' => '抱歉！', 'message' => '添加规格值失败'];

        return response()->json($response);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int  $attribute_id
     * @param string $value
     * @return \Illuminate\Http\Response
     */
    public function destroy($attribute_id, $value)
    {
        $response = Models\AttributeValue::where(['attribute_id' => $attribute_id, 'value' => $value])->delete() ? ['code' => 1, 'title'=> '恭喜！', 'message' => '删除规格值成功'] : ['code' => 0, 'title' => '抱歉！', 'message' => '删除规格值失败'];

        return response()->json($response);
    }
}
