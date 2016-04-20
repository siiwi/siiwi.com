<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param int $cid
     * @return \Illuminate\Http\Response
     */
    public function index($cid)
    {
        // 分类
        $category = Models\Category::where('type', 0)
                                    ->orWhere(['uid' => \Auth::user()->id])
                                    ->orderBy('id', 'desc')
                                    ->get();

        // 规格
        $attribute = Models\Attribute::where(['uid' => \Auth::user()->id, 'cid' => $cid])
                                    ->orderBy('id', 'desc')
                                    ->paginate(config('app.pagesize'));

        // 规格值
        if(is_array($attribute->items()) && !empty($attribute->items())) {
            foreach($attribute->items() as $key=>$value) {
                $val = array();
                $vals = Models\AttributeValue::where(['attribute_id' => $value['id']])->get()->toArray();

                foreach($vals as $k=>$v) {
                    $val[] = $v['value'];
                }

                $attribute->items()[$key]['value'] = $val;
            }
        }

        return view('product.attribute.index', ['cid' => $cid, 'attribute' => $attribute, 'category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param int $cid
     * @return \Illuminate\Http\Response
     */
    public function create($cid)
    {
        return view('product.attribute.form', ['cid' => $cid]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreAttributeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store($cid, Requests\StoreAttributeRequest $request)
    {
        $data = $request->all();

        $data['uid'] = \Auth::user()->id;
        $data['cid'] = $cid;

        $response = Models\Attribute::create($data) ? ['code' => 1, 'title' => '恭喜！', 'message' => '添加规格成功'] : ['code' => 0, 'title' => '抱歉！', 'message' => '添加规格失败'];

        $redirect = "category/$cid/attribute";

        return redirect($redirect)->with('message', $response);
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
     * @param int $cid
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($cid, $id)
    {
        $response = Models\Attribute::where(['id' => $id, 'cid' => $cid])->delete() ? ['code' => 1, 'message' => 'success'] : ['code' => 0, 'message' => 'failed'];

        return response()->json($response);
    }
}
