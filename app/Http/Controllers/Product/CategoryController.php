<?php

namespace App\Http\Controllers\Product;

use App\Http\Models\AttributeValue;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Category;
use App\Http\Models\Attribute;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $category = Category::where('uid' , \Auth::user()->id)
                            ->orWhere('type', 0)
                            ->orderBy('id', 'desc')
                            ->paginate(config('app.pagesize'));

        // 父级分类名称
        if(is_array($category->items()) && !empty($category->items())) {
            foreach($category->items() as $key=>$value) {
                if($value['pid']) {
                    $pcategory = Category::find($value['pid']);
                    $category->items()[$key]['pname'] = $pcategory['name'];
                } else {
                    $category->items()[$key]['pname'] = '-';
                }
            }
        }

        return view('product.category.index', ['category' => $category]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::where('type', 0)
                            ->orWhere(['pid' => 0, 'uid' => \Auth::user()->id])
                            ->orderBy('id', 'desc')
                            ->get();

        return view('product.category.form', ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreCategoryRequest $request)
    {
        // 写入新分类
        $category = new Category;
        $category->pid = $request->input('pid');
        $category->uid = \Auth::user()->id;
        $category->locale = config('app.locale');
        $category->name = $request->input('category_name');
        $category->type = 1;
        $category->status = 1;
        $category->save();

        // 获取新写入的分类ID
        $cid = $category->id;

        // 继承父级分类规格与规格值
        if($request->input('pid')) {
            $attributes = Attribute::where(['cid' => $request->input('pid'), 'uid' => 0])
                ->orWhere(['cid' => $request->input('pid'), 'uid' => \Auth::user()->id])
                ->get()
                ->toArray();

            if(is_array($attributes) && !empty($attributes)) {
                foreach($attributes as $attr) {
                    // 继承父级规格
                    $attribute = new Attribute;
                    $attribute->cid = $cid;
                    $attribute->uid = \Auth::user()->id;
                    $attribute->name = $attr['name'];
                    $attribute->status = 1;
                    $attribute->save();

                    // 获取新写入的规格ID
                    $aid = $attribute->id;

                    $attribute_values = AttributeValue::where(['aid' => $attr['id']])
                                                        ->get()
                                                        ->toArray();

                    // 继承父级规格值
                    if(is_array($attribute_values) && !empty($attribute_values)) {
                        foreach($attribute_values as $attr_value) {
                            $data['aid'] = $aid;
                            $data['value'] = $attr_value['value'];
                            AttributeValue::create($data);
                        }
                    }
                }
            }
        }

        $response = $cid ? ['title' => '恭喜！', 'message' => '添加分类成功'] : ['title' => '抱歉！', 'message' => '添加分类失败'];

        return redirect('category')->with('message', $response);
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
        $cate = Category::findOrFail($id);
        $category = Category::where('type', 0)
                            ->orWhere(['pid' => 0, 'uid' => \Auth::user()->id])
                            ->orderBy('id', 'desc')
                            ->get();
        return view('product.category.form', ['cate' => $cate, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\StoreCategoryRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreCategoryRequest $request, $id)
    {
        $status = Category::where('id', $id)->update(['name' => $request->input('category_name')]);

        $response = $status ? ['title' => '恭喜！', 'message' => '分类信息修改成功'] : ['title' => '抱歉！', 'message' => '分类信息修改失败'];

        return redirect('category')->with('message', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Category::where('id', $id)->update(['status' => 0]);

        $response = Category::destroy($id) ? ['code' => 1, 'message' => 'success'] : ['code' => 0, 'message' => 'failed'];

        return response()->json($response);
    }
}
