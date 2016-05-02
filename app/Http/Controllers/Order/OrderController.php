<?php

namespace App\Http\Controllers\Order;

use App\Http\Models\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 状态
        $status = get_order_status();

        // 平台
        $platform = get_order_platforms();

         // 分类
        $category = Category::where(['uid' => \Auth::id()])
                            ->orWhere(['type' => 0])
                            ->orderBy('pid', 'desc')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

        // 父级分类
        if(is_array($category) && !empty($category)) {
            foreach($category as $k=>$v) {
                $category[$k]['p_name'] = '';
                if($v['pid']) {
                    $category_info = Category::findOrFail(['id' => $v['pid']])->first()->toArray();
                    $category[$k]['p_name'] = $category_info['name'];
                }
            }
        }

        return view('order.index', ['status' => $status, 'platform' => $platform, 'category' => $category]);
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
        return $request->all();
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
