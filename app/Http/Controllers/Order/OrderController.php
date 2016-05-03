<?php

namespace App\Http\Controllers\Order;

use App\Http\Models\Category;
use App\Http\Models\Order;
use App\Http\Models\OrderProduct;
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
     * @param  Requests\StoreOrderRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreOrderRequest $request)
    {
        $order = new Order;

        $order->uid = \Auth::id();
        $order->order_sn = $request->input('order_sn');
        $order->order_express_price = $request->input('order_express_price');
        $order->order_platform = $request->input('order_platform');
        $order->order_status = $request->input('order_status');
        $order->order_date = strtotime($request->input('order_date'));
        $order->buyer_name = $request->input('order_buyer_name');
        $order->buyer_phone = $request->input('order_buyer_phone');
        $order->buyer_address = $request->input('order_buyer_address');
        $order->save();

        $order_id = $order->id;

        // 保存订单产品
        if(is_array($request->input('sku')) && !empty($request->input('sku'))) {
            foreach($request->input('sku') as $key=>$value) {
                $order_product = ['order_id' => $order_id, 'sku_id' => $key, 'num' => $value['num'], 'price' => $value['price']];
                OrderProduct::create($order_product);
            }
        }

        $response = $order_id ? ['code' => 1, 'title' => '恭喜！', 'message' => '添加订单成功'] : ['code' => 0, 'title' => '抱歉！', 'message' => '添加订单失败'];

        return redirect('order')->with('message', $response);
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
