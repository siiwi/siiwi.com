<?php

namespace App\Http\Controllers\Product;

use App\Http\Models\Product;
use App\Http\Models\ProductResource;
use App\Http\Models\ProductSku;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Supplier;
use App\Http\Models\Category;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 供应商
        $suppliers = Supplier::where(['uid' => \Auth::user()->id])
                                ->orderBy('id', 'desc')
                                ->get();

        // 分类
        $categories = Category::where(['type' => 0])
                                ->orWhere(['uid' => Auth::user()->id, 'type' => 1])
                                ->orderBy('id', 'desc')
                                ->get();

        return view('product.product.index', ['suppliers' => $suppliers, 'categories' => $categories]);
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
        $product->name = $request->input('product_name');
        $product->url = $request->input('url');
        $product->sn = $request->input('sn') ? $request->input('sn') : '';
        $product->save();
        $pid = $product->id;

        // 未传入产品编号的自动生成一个
        if($pid && !$request->input('sn')) {
            $product->sn = create_product_sn($pid);
            $product->save();
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
                $productSku->pid = $pid;
                $productSku->uid = \Auth::id();
                ksort($value['attribute']);
                $productSku->attribute = json_encode($value['attribute']);
                $productSku->purchase_price = $value['purchase_price'];
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
        //
    }
}
