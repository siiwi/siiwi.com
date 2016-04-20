@extends('layout')

@section('title')
    产品
@endsection

@section('content-title')
    产品列表
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    产品
@endsection

@section('content')
    <!--Icon Tabs (Left Aligned)-->
    <!--===================================================-->
    <div class="tab-base">

        <!--Nav tabs-->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#product_tab_1"><i class="fa fa-search"></i>&nbsp;检索产品</a></li>
            <li><a data-toggle="tab" href="#product_tab_2"><i class="fa fa-plus"></i>&nbsp;添加产品</a></li>
        </ul>

        <!--Tabs Content-->
        <div class="tab-content">
            <div id="product_tab_1" class="tab-pane fade active in">
                <div class="panel-body">
                    <form method="post" action="#">
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品名称" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品编号" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <select name="supplier" class="chosen_select">
                                    <option value="0">供应商</option>
                                    @if(count($suppliers)>0)
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <button class="btn btn-primary" type="button">搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="product_tab_2" class="tab-pane fade">
                <div class="panel-body">
                    <form method="post" action="#">
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品名称" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品编号" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="进货链接" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <select name="category" class="chosen_select">
                                    <option value="0">产品分类</option>
                                    @if(count($categories)>0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">@if($category->type)用户分类@else系统分类@endif - {{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="supplier" class="chosen_select">
                                    <option value="0">供应商</option>
                                    @if(count($suppliers)>0)
                                        @foreach($suppliers as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <button class="btn btn-default btn-block" type="button" >规格设置</button>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <button class="btn btn-default btn-block" type="button">图片设置</button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <button class="btn btn-primary btn-block" type="button">保存</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Icon Tabs (Left Aligned)-->
    <!--===================================================-->

    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title">产品列表</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th>名称</th>
                                <th>进货价(元)</th>
                                <th>销售量</th>
                                <th>库存</th>
                                <th>类别</th>
                                <th>状态</th>
                                <th>操作</th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="7" class="text-center">暂无数据</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="pull-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content-script')
<script type="text/javascript">
$(function(){
    // select样式
    $('.chosen_select').chosen({ width: '100%' });
});
</script>
@endsection