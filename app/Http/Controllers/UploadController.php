<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class UploadController extends Controller
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource = Input::file('product-resource');

        if($resource->isValid()) {
            // 获取文件名称
            $filename = $resource->getClientOriginalName();

            // 获取文件扩展名
            $extension = $resource->getClientOriginalExtension();

            // 设置文件存放目录
            $path = 'uploads/' .date('Y/m/d');

            // 重命名文件
            $file = md5($filename . time()) . '.' . $extension;

            // 保存文件
            $resource->move($path, $file);

            //  返回成功信息
            return [
                'code' => 1,
                'message' => '上传成功',
                'data' => $path . '/' . $file
            ];
        }

        //  返回失败信息
        return [
            'code' => 0,
            'message' => '上传失败',
            'data' => $resource->getErrorMessage()
        ];
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
