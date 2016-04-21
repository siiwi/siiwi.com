<?php

namespace App\Http\Controllers\Product;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Models\Supplier;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::where('uid', \Auth::user()->id)
                             ->orderBy('id', 'desc')
                             ->paginate(config('app.pagesize'));

        return view('product.supplier.index', ['suppliers' => $suppliers]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.supplier.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Requests\StoreSupplierRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StoreSupplierRequest $request)
    {
        $data = $request->all();

        $data['uid'] = \Auth::user()->id;
        $data['name'] = $request->input('supplier_name');
        $data['status'] = 1;

        $response = Supplier::create($data) ? ['title' => '恭喜！', 'message' => '添加供应商成功'] : ['title' => '抱歉！', 'message' => '添加供应商失败'];

        return redirect('supplier')->with('message', $response);
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
        $supplier = Supplier::findOrFail($id);

        return view('product.supplier.form', ['supplier' => $supplier]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Requests\StoreSupplierRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\StoreSupplierRequest $request, $id)
    {
        $data = $request->all();

        $data['name'] = $data['supplier_name'];

        unset($data['_method'], $data['_token'], $data['supplier_name']);

        $status = Supplier::where('id', $id)->update($data);

        $response = $status ? ['title' => '恭喜！', 'message' => '供应商信息修改成功'] : ['title' => '抱歉！', 'message' => '供应商信息修改失败'];

        return redirect('supplier')->with('message', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Supplier::where('id', $id)->update(['status' => 0]);

        $response = Supplier::destroy($id) ? ['code' => 1, 'message' => 'success'] : ['code' => 0, 'message' => 'failed'];

        return response()->json($response);
    }
}
