@extends('layout')

@section('title')
    订单
@endsection

@section('content-title')
    订单列表
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    订单
@endsection

@section('content')
    <!--Icon Tabs (Left Aligned)-->
    <!--===================================================-->
    <div class="tab-base">

        <!--Nav tabs-->
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#order_tab_1"><i class="fa fa-search"></i>&nbsp;检索订单</a></li>
            <li><a data-toggle="tab" href="#order_tab_2"><i class="fa fa-plus"></i>&nbsp;添加订单</a></li>
        </ul>

        <!--Tabs Content-->
        <div class="tab-content">
            <!-- start product_tab_1 -->
            <!--===================================================-->
            <div id="order_tab_1" class="tab-pane fade active in">
                <div class="panel-body">
                    <form method="post" action="#">
                        <div class="row">
                            <div class="col-sm-2 mar-btm">
                                <input type="text" placeholder="产品名称" class="form-control" value="">
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <input type="text" placeholder="交易订单号" class="form-control" value="">
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <select class="chosen_select" name="search_order_platform">
                                    <option value="0">交易平台</option>
                                    @foreach($platform as $p)
                                        <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <select class="chosen_select" name="search_order_status">
                                    <option value="0">订单状态</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <div class="input-daterange input-group">
                                    <input type="text" class="form-control" name="order_start_date" placeholder="起始日期" value="" />
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="order_end_date" placeholder="结束日期" value="" />
                                </div>
                            </div>
                            <div class="col-sm-1 mar-btm">
                                <button class="btn btn-primary" type="button">搜索</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!--===================================================-->
            <!-- end product_tab_1 -->

            <div id="order_tab_2" class="tab-pane fade">
                <div class="panel-body">
                    <!--===================================================-->
                    <!--start add product form-->
                    <form method="post" action="#" >
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="订单号" class="form-control" name="order_sn" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="快递总价（元）" class="form-control" name="order_express_price" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <div class="input-group">
                                    <input type="text" placeholder="交易日期" class="form-control order_date" name="order_date" value="" />
                                    <span class="input-group-addon"><i class="fa fa-calendar fa-lg"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="买家昵称或姓名" class="form-control" name="order_buyer_name" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="买家联系电话" class="form-control" name="order_buyer_phone" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="买家联系地址" class="form-control" name="order_buyer_address" value="" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <select class="chosen_select" name="order_platform">
                                    <option value="0">交易平台</option>
                                    @foreach($platform as $p)
                                        <option value="{{ $p['id'] }}">{{ $p['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <select class="chosen_select" name="order_status">
                                    <option value="0">订单状态</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s['id'] }}">{{ $s['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="button" class="btn btn-default btn-block" id="select_order_product" value="选择产品" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                {{ csrf_field() }}
                                <button class="btn btn-primary btn-block" type="submit">保存</button>
                            </div>
                        </div>
                    </form>
                    <!--end add product form-->
                    <!--===================================================-->
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
                    <h3 class="panel-title">订单列表</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                            <tr>
                                <th>产品</th>
                                <th>出售价</th>
                                <th>销售量</th>
                                <th>状态</th>
                                <th>交易日期</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <td colspan="6" class="text-center">暂无数据</td>
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

    <!--Start Add Product Attribute modal-->
    <!--================================-->
    @include('order.product')
    <!--===============================-->
    <!--End Add Product Attribute modal-->
@endsection

@section('content-script')
<script type="text/javascript">
$(function(){
    $('.chosen_select').chosen({
        width: '100%',
        disable_search: true
    });

    $('.input-daterange').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        enableOnReadonly: true,
        endDate: "0d",
        language: "zh-CN"
    });

    $('.order_date').datepicker({
        format: "yyyy-mm-dd",
        todayBtn: "linked",
        autoclose: true,
        todayHighlight: true,
        enableOnReadonly: true,
        endDate: "0d",
        language: "zh-CN"
    });

    $("#select_order_product").click(function(){
        $("#selectOrderProduct").modal('show');
    });

    $("a[p-action-dom=select_product_category]").click(function(){
        var category_id = $(this).attr('category_id');
        $(this).siblings('a').removeClass('active');
        $(this).addClass('active');
        console.log(category_id);
    });
});
</script>
@endsection