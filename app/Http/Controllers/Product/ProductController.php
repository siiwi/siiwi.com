<?php

namespace App\Http\Controllers\Product;

use App\Http\Models\Attribute;
use App\Http\Models\Product;
use App\Http\Models\ProductResource;
use App\Http\Models\ProductSku;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Supplier;
use App\Http\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
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
            if($request->input('search_sn')) {
                $whereRaw .= ' and `product_sn` = "' . trim($request->input('search_sn')) . '"';
                $where['search_sn'] = trim($request->input('search_sn'));
            }

            if($request->input('search_sid')) {
                $whereRaw .= ' and `sid` = "' . trim($request->input('search_sid')) . '"';
                $where['search_sid'] = trim($request->input('search_sid'));
            }

            if($request->input('search_cid')) {
                $whereRaw .= ' and `cid` = "' . trim($request->input('search_cid')) . '"';
                $where['search_cid'] = trim($request->input('search_cid'));
            }

            if($request->input('search_name')) {
                $whereRaw .= ' and `product_name` like "%' . trim($request->input('search_name')) . '%' . '"';
                $where['search_name'] = trim($request->input('search_name'));
            }
        }

        // 供应商
        $suppliers = Supplier::where(['uid' => \Auth::id()])
                                ->orderBy('id', 'desc')
                                ->get();

        // 分类
        $categories = Category::where(['type' => 0])
                                ->orWhere(['uid' => \Auth::id(), 'type' => 1])
                                ->orderBy('id', 'desc')
                                ->get();

        // 产品SKU信息
        $product_sku = ProductSku::whereRaw($whereRaw)
                            ->orderBy('id', 'desc')
                            ->paginate(config('app.pagesize'));

        if(is_array($product_sku->items()) && !empty($product_sku->items())) {
            foreach($product_sku->items() as $key=>$value) {
                // 产品基本信息
                $product = Product::where(['id' => $value['pid']])->first()->toArray();
                $product_sku[$key]['name'] = $product['name'];
                $product_sku[$key]['sn'] = $product['sn'];
                $product_sku[$key]['cid'] = $product['cid'];
                $product_sku[$key]['sid'] = $product['sid'];
                $product_sku[$key]['url'] = $product['url'];

                // 产品图片
                $product_resource = ProductResource::where(['pid' => $value['pid']])->get()->toArray();
                if(is_array($product_resource) && !empty($product_resource)) {
                    $resource = [];
                    foreach($product_resource as $val) {
                        $resource[] = config('app.url') . $val['path'];
                    }
                    $product_sku[$key]['resource'] = $resource;
                }

                // 产品分类
                $product_category = Category::where(['id' => $product['cid']])->first()->toArray();
                $product_sku[$key]['category_name'] = $product_category['name'];

                // 产品规格
                $attributes = @json_decode($value['attribute'], true);
                if(is_array($attributes) && !empty($attributes)) {
                    $attr = [];
                    foreach($attributes as $k=>$v) {
                        $attribute_info = Attribute::withTrashed()->where(['id' => $k])->first()->toArray();
                        $attr[$k]['id'] = $k;
                        $attr[$k]['name'] = $attribute_info['name'];
                        $attr[$k]['value'] = $v;
                    }
                    $product_sku[$key]['attribute'] = $attr;
                }
            }
        }

        return view('product.product.index', ['suppliers' => $suppliers, 'categories' => $categories, 'product_sku' => $product_sku, 'where' => $where]);
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
     * @param Requests\StoreProductRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreProductRequest $request)
    {
        // 将产品基本信息存入产品基本信息表
        $product = new Product;
        $product->cid = $request->input('cid');
        $product->sid = $request->input('sid');
        $product->uid = \Auth::id();
        $product->name = trim($request->input('product_name'));
        $product->url = trim($request->input('url'));
        $product->sn = $request->input('sn') ? trim($request->input('sn')) : '';
        $product->save();
        $pid = $product->id;

        // 未传入产品编号的自动生成一个
        if($pid && !$request->input('sn')) {
            $sn = create_product_sn($pid);
            $product->sn = $sn;
            $product->save();
        } else {
            $sn = $request->input('sn');
        }

        // 保存产品图片
        if(is_array($request->input('resource')) && !empty($request->input('resource'))) {
            $data = [];
            foreach($request->input('resource') as $value) {
                $data['pid'] = $pid;
                $data['uid'] = \Auth::id();
                $data['path'] = $value;
                ProductResource::create($data);
            }
        }

        // 保存产品规格及SKU
        if(is_array($request->input('sku')) && !empty($request->input('sku'))) {
            foreach($request->input('sku') as $value) {
                $productSku = new ProductSku;
                $productSku->sid = $request->input('sid');
                $productSku->cid = $request->input('cid');
                $productSku->pid = $pid;
                $productSku->uid = \Auth::id();
                ksort($value['attribute']);
                $productSku->attribute = json_encode($value['attribute']);
                $productSku->purchase_price = $value['purchase_price'];
                $productSku->product_name = $request->input('product_name');
                $productSku->product_sn = $sn;
                $productSku->stock = $value['stock'];
                $productSku->sku = $value['sku'] ? $value['sku'] : '';
                $productSku->save();

                // 未传入SKU的自动生成一个
                if(!$productSku->sku) {
                    $id = $productSku->id;
                    $productSku->sku = create_product_sku($pid, $id);
                    $productSku->save();
                }
            }
        }

        $response = $pid ? ['title' => '恭喜！', 'message' => '添加产品成功'] : ['title' => '抱歉！', 'message' => '添加产品失败'];

        return redirect('product')->with('message', $response);
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
        $response = ProductSku::destroy(['uid' => \Auth::id(), 'id' => $id]) ? ['code' => 1, 'message' => 'success'] : ['code' => 0, 'message' => 'failed'];

        return response()->json($response);
    }

    /**
     * AJAX获取产品列表
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function loadProduct(Request $request)
    {
        $where = ['uid' => \Auth::id()];

        if($request->input('cid')) {
            $where = ['uid' => \Auth::id(), 'cid' => $request->input('cid')];
        }

        $response = Product::where($where)->orderBy('id', 'desc')->paginate(config('app.pagesize'));

        return response()->json(['code' => 1, 'data' => $response->toArray()]);
    }

    /**
     * AJAX获取产品SKU列表
     *
     * @param $pid
     * @return \Illuminate\Http\Response
     */
    public function loadSku($pid)
    {
        $rtn = [];
        $sku =  ProductSku::where(['pid' => $pid])->orderBy('id', 'desc')->get()->toArray();

        if(is_array($sku) && !empty($sku)) {
            foreach($sku as $key=>$value) {
                $rtn[$key]['id'] = $value['id'];
                $rtn[$key]['stock'] = $value['stock'];
                $rtn[$key]['purchase_price'] = $value['purchase_price'];

                $attributes = @json_decode($value['attribute'], true);
                if(is_array($attributes) && !empty($attributes)) {
                    foreach($attributes as $k=>$v) {
                        $attribute_info = Attribute::withTrashed()->where(['id' => $k])->first()->toArray();
                        $attr['id'] = $attribute_info['id'];
                        $attr['name'] = $attribute_info['name'];
                        $attr['value'] = $v;
                        $rtn[$key]['attribute'][] = $attr;
                    }
                }
            }
        }

        $response = (is_array($rtn) && !empty($rtn)) ? ['code' => 1, 'message' => 'success', 'data' => $rtn] : ['code' => 0, 'message' => 'failed', 'data' => []];

        return response()->json($response);
    }

    /**
     * 获取SKU信息
     *
     * @param $sku
     * @return \Illuminate\Http\Response
     */
    public function getSku($sku)
    {
        $sku_info = ProductSku::where(['sku' => $sku, 'uid' => \Auth::id()])->get();

        $count = $sku_info->count();

        $response = ($count) ? ['code' => 1, 'message' => 'success', 'data' => $sku_info] : ['code' => 0, 'message' => 'failed', 'data' => []];

        return response()->json($response);
    }
}
