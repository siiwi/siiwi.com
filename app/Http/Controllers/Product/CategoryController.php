<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Category;

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
        $data = $request->all();

        $data['uid'] = \Auth::user()->id;
        $data['locale'] = config('app.locale');
        $data['name'] = $request->input('category_name');
        $data['type'] = 1;
        $data['status'] = 1;

        $response = Category::create($data) ? ['title' => '恭喜！', 'message' => '添加分类成功'] : ['title' => '抱歉！', 'message' => '添加分类失败'];

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
