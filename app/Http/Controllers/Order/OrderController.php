<?php

namespace App\Http\Controllers\Order;

use App\Http\Models\Attribute;
use App\Http\Models\Category;
use App\Http\Models\Order;
use App\Http\Models\OrderProduct;
use App\Http\Models\Platform;
use App\Http\Models\Product;
use App\Http\Models\ProductResource;
use App\Http\Models\ProductSku;
use App\Http\Models\Status;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // 查询
        $whereRaw = '`uid` = "' .\Auth::id() . '"';
        $where = [];

        if(is_array($request->all()) && !empty($request->all())) {
            if($request->input('search_order_sn')) {
                $whereRaw .= ' and `order_sn` = "' . trim($request->input('search_order_sn')) . '"';
                $where['search_order_sn'] = trim($request->input('search_order_sn'));
            }

            if($request->input('search_order_platform')) {
                $whereRaw .= ' and `order_platform` = "' . trim($request->input('search_order_platform')) . '"';
                $where['search_order_platform'] = trim($request->input('search_order_platform'));
            }

            if($request->input('search_order_status')) {
                $whereRaw .= ' and `order_status` = "' . trim($request->input('search_order_status')) . '"';
                $where['search_order_status'] = trim($request->input('search_order_status'));
            }

            if($request->input('search_order_start_date')) {
                $whereRaw .= ' and `order_date` >= "' . strtotime($request->input('search_order_status')) . '"';
                $where['search_order_start_date'] = trim($request->input('search_order_start_date'));
            }

            if($request->input('search_order_end_date')) {
                $whereRaw .= ' and `order_date` <= "' . strtotime($request->input('search_order_end_date')) . '"';
                $where['search_order_end_date'] = trim($request->input('search_order_end_date'));
            }

            if($request->input('search_order_name')) {
                $whereRaw .= ' and `products_name` like "%' . trim($request->input('search_order_name')) . '%"';
                $where['search_order_name'] = trim($request->input('search_order_name'));
            }
        }

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

        // 订单列表
        $orders = Order::whereRaw($whereRaw)
                        ->orderBy('id', 'desc')
                        ->paginate(config('app.pagesize'));

        if(is_array($orders->items()) && !empty($orders->items())) {
            foreach($orders->items() as $key=>$value) {
                // 交易平台
                $platforms = Platform::where(['id' => $value['order_platform']])->first()->toArray();
                $orders[$key]['order_platform'] = $platforms['name'];

                // 交易状态
                $s = Status::where(['id' => $value['order_status']])->first()->toArray();
                $orders[$key]['order_status'] = $s['name'];

                // 订单产品
                $order_products = OrderProduct::where(['order_id' => $value['id']])->get()->toArray();
                if(is_array($order_products) && !empty($order_products)) {
                    foreach($order_products as $k=>$v) {
                        $sku_info = ProductSku::where(['id' => $v['sku_id']])->first()->toArray();
                        $product_info = Product::where(['id' => $sku_info['pid']])->first()->toArray();
                        $resource_info = ProductResource::where(['pid' => $sku_info['pid']])->get()->toArray();

                        // 解析图片资源
                        if(is_array($resource_info) && !empty($resource_info)) {
                            $resource = [];
                            foreach($resource_info as $val) {
                                $resource[] = config('app.url') . $val['path'];
                            }
                            $p[$k]['resource'] = $resource;
                        }

                        // 解析SKU规格
                        $attributes = @json_decode($sku_info['attribute'], true);
                        if(is_array($attributes) && !empty($attributes)) {
                            $attr = [];
                            foreach($attributes as $i=>$j) {
                                $attribute_info = Attribute::withTrashed()->where(['id' => $i])->first()->toArray();
                                $attr[] = $attribute_info['name'] . ":" . $j;
                            }
                            $p[$k]['attribute'] = join(', ', $attr);
                        }

                        $p[$k]['name'] = $product_info['name'];
                        $p[$k]['num'] = $v['num'];
                        $p[$k]['price'] = $v['price'];
                        $p[$k]['url'] = $product_info['url'];
                        $orders[$key]['product'] = $p;
                    }
                }
            }
        }

        return view('order.index', ['status' => $status, 'platform' => $platform, 'category' => $category, 'orders' => $orders, 'where' => $where]);
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
        $order->order_sn = trim($request->input('order_sn'));
        $order->order_express_price = trim($request->input('order_express_price'));
        $order->order_platform = $request->input('order_platform');
        $order->order_status = $request->input('order_status');
        $order->order_date = strtotime($request->input('order_date'));
        $order->buyer_name = trim($request->input('order_buyer_name'));
        $order->buyer_phone = trim($request->input('order_buyer_phone'));
        $order->buyer_address = trim($request->input('order_buyer_address'));
        $order->save();

        $order_id = $order->id;

        // 订单存储产品名称用于查询
        $products_name_arr = [];

        // 保存订单产品
        if(is_array($request->input('sku')) && !empty($request->input('sku'))) {
            foreach($request->input('sku') as $key=>$value) {
                // 订单数据
                $num = (isset($value['num']) && $value['num']) ? $value['num'] : 0;
                $price = (isset($value['price']) && $value['price']) ? $value['price'] : 0;
                $order_product = ['order_id' => $order_id, 'sku_id' => $key, 'num' => $num, 'price' => $price];
                OrderProduct::create($order_product);

                // 根据sku_id查找产品名称
                $product_sku_info = ProductSku::withTrashed()->where(['id' => $key])->first()->toArray();
                $products_name_arr[$product_sku_info['pid']] = $product_sku_info['product_name'];
            }
        }

        $order->products_name = join('|', $products_name_arr);
        $order->save();

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
        $response = Order::destroy(['uid' => \Auth::id(), 'id' => $id]) ? ['code' => 1, 'message' => 'success'] : ['code' => 0, 'message' => 'failed'];

        return response()->json($response);
    }
}
