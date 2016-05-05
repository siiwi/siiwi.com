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
                    <form method="get" action="{{ url('order') }}">
                        <div class="row">
                            <div class="col-sm-2 mar-btm">
                                <input type="text" placeholder="产品名称" class="form-control" name="search_order_name" value="@if(isset($where['search_order_name']) && $where['search_order_name']){{ $where['search_order_name'] }}@endif">
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <input type="text" placeholder="交易订单号" class="form-control" name="search_order_sn" value="@if(isset($where['search_order_sn']) && $where['search_order_sn']){{ $where['search_order_sn'] }}@endif">
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <select class="chosen_select" name="search_order_platform">
                                    <option value="0">交易平台</option>
                                    @foreach($platform as $p)
                                        <option value="{{ $p['id'] }}" @if(isset($where['search_order_platform']) && ($p['id'] == $where['search_order_platform'])) selected @endif>{{ $p['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-2 mar-btm">
                                <select class="chosen_select" name="search_order_status">
                                    <option value="0">订单状态</option>
                                    @foreach($status as $s)
                                        <option value="{{ $s['id'] }}" @if(isset($where['search_order_status']) && ($s['id'] == $where['search_order_status'])) selected @endif>{{ $s['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <div class="input-daterange input-group">
                                    <input type="text" class="form-control" name="search_order_start_date" placeholder="起始日期" value="@if(isset($where['search_order_start_date']) && $where['search_order_start_date']){{ $where['search_order_start_date'] }}@endif" />
                                    <span class="input-group-addon">-</span>
                                    <input type="text" class="form-control" name="search_order_end_date" placeholder="结束日期" value="@if(isset($where['search_order_end_date']) && $where['search_order_end_date']){{ $where['search_order_end_date'] }}@endif" />
                                </div>
                            </div>
                            <div class="col-sm-1 mar-btm">
                                <button class="btn btn-primary" type="submit">搜索</button>
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
                    <form method="post" action="{{ url('order') }}" onsubmit="return form_validate();" id="submitOrder" >
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="交易订单号" class="form-control" name="order_sn" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="快递总价(元)" class="form-control" name="order_express_price" value="" />
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
                        <table class="table table-condensed table-hover">
                            <thead>
                                <tr>
                                    <th width="40">#</th>
                                    <th>交易订单号</th>
                                    <th>交易平台</th>
                                    <th>交易状态</th>
                                    <th>交易日期</th>
                                    <th>买家</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($orders) > 0)
                                @foreach($orders as $order)
                                <tr>
                                    <td><a href="javascript:;" p-action-dom="show-product-list"><i class="fa fa-plus-circle"></i></a></td>
                                    <td>{{ $order->order_sn }}</td>
                                    <td>{{ $order->order_platform }}</td>
                                    <td>{{ $order->order_status }}</td>
                                    <td>{{ date('Y-m-d', $order->order_date) }}</td>
                                    <td>{{ $order->buyer_name }}</td>
                                    <td><button class="btn btn-xs btn-danger add-tooltip delOrder" data-toggle="tooltip" data-original-title="删除" data-container="body" order_id="{{ $order->id }}" ><i class="fa fa-times"></i></button></td>
                                </tr>
                                <tr class="hide" p-action-dom="product-list" style="background: #FFFFEE;">
                                    <td colspan="7">
                                    @foreach($order->product as $product)
                                        <div class="col-sm-12 mar-btm">
                                            <div class="col-sm-1">
                                                @if(count($product['resource'])>0)
                                                    <div p_action_dom="product_resource" style="min-height: 56px;">
                                                        @foreach($product['resource'] as $k => $resource)
                                                            <a href="{{ $resource }}" class="thumbnail @if($k>0) hide @endif">
                                                                <img src="{{ $resource }}" width="56" />
                                                            </a>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <a href="javascript:;" class="thumbnail">
                                                        <img src="{{ asset('img/no-pic.jpg') }}" width="56" />
                                                    </a>
                                                @endif
                                            </div>
                                            <div class="col-sm-11">
                                                <p>名称：<a href="@if($product['url']) {{ $product['url'] }} @else javascript:; @endif" class="btn-link" target="_blank">{{ $product['name'] }}</a></p>
                                                <p>销量：{{ $product['num'] }}</p>
                                                <p>售价：{{ $product['price'] }}</p>
                                                <p>规格：{{ $product['attribute'] }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="6" class="text-center">暂无数据</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $orders !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start Select Product modal-->
    <!--================================-->
    @include('order.product')
    <!--===============================-->
    <!--End Select Product modal-->

    <!--Start Select Product SKU modal-->
    <!--================================-->
    @include('order.sku')
    <!--===============================-->
    <!--End Select Product SKU modal-->
@endsection

@section('content-script')
<script type="text/javascript">
var order_platform = 0;
var order_status = 0;

function nt(m)
{
    $.niftyNoty({
        type: 'danger',
        icon: 'fa fa-times fa-lg',
        message: m,
        container: 'floating',
        closeBtn: true,
        timer: 3000
    });
}

function form_validate()
{
    var order_sn = $("input[name=order_sn]").val();
    if(order_sn.length <= 0) {
        nt('提交失败！请输入订单号！');
        $("input[name=order_sn]").focus();
        return false;
    }

    var order_express_price = $("input[name=order_express_price]").val();
    if(order_express_price.length <= 0) {
        nt('提交失败！请输入快递总价！');
        $("input[name=order_express_price]").focus();
        return false;
    }

    var order_date = $("input[name=order_date]").val();
    if(order_date.length <= 0) {
        nt('提交失败！请选择交易日期！');
        return false;
    }

    var order_buyer_name = $("input[name=order_buyer_name]").val();
    if(!order_buyer_name) {
        nt('提交失败！请输入买家名称！');
        $("input[name=order_buyer_name]").focus();
        return false;
    }

    var order_buyer_phone = $("input[name=order_buyer_phone]").val();
    if(!order_buyer_phone) {
        nt('提交失败！请输入买家联系方式！');
        $("input[name=order_buyer_phone]").focus();
        return false;
    }

    var order_buyer_address = $("input[name=order_buyer_address]").val();
    if(!order_buyer_address) {
        nt('提交失败！请输入买家联系地址！');
        $("input[name=order_buyer_address]").focus();
        return false;
    }

    if(isNaN(order_platform) || order_platform <= 0) {
        nt('提交失败！请选择交易平台！');
        return false;
    }

    if(isNaN(order_status) || order_status <= 0) {
        nt('提交失败！请选择交易状态！');
        return false;
    }

    var sku = $(".hidden-dynamic-sku");
    if(sku.length <= 0) {
        nt('提交失败！请设置订单产品！');
        return false;
    }

    return true;
}

$(function(){
    $('.chosen_select').chosen({
        width: '100%',
        disable_search: true
    });

    $('select[name=order_platform]').change(function(){
        order_platform = $(this).val();
    });

    $('select[name=order_status]').change(function(){
        order_status = $(this).val();
    });

    // 显示产品列表
    $('a[p-action-dom="show-product-list"]').click(function(){
        $(this).parents('tr').next('tr[p-action-dom="product-list"]').toggleClass('hide');
        if($(this).parents('tr').next('tr[p-action-dom="product-list"]').hasClass('hide')) {
            var html = '<i class="fa fa-plus-circle"></i>';
        } else {
            var html = '<i class="fa fa-minus-circle"></i>';
        }
        $(this).html(html);
    });

    // 产品图片
    $("div[p_action_dom=product_resource]").lightGallery({
        thumbnail:true
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

    function loadProduct(cid, page)
    {
        var url = '{{ url('product/load') }}?';

        if(!isNaN(page) && page > 1) {
            url += 'page=' + page;
            if(!isNaN(cid) && cid > 0) {
                url += '&';
            }
        }

        if(!isNaN(cid) && cid > 0) {
            url += 'cid=' + cid;
        }

        var progress_bar = '<tr><td colspan="4"><div class="col-sm-6 col-sm-offset-3"><div class="progress progress-striped active"><div style="width: 100%;" class="progress-bar progress-bar-primary"></div></div></div></td></tr>'

        $(".paginate").remove();
        $('tbody[p-action-dom="product_list"]').html(progress_bar);

        $.get(url, function(response){
            var html;
            var paginate;
            if(response.code == 1 && response.data.total > 0) {
                for(var i=0; i<response.data.data.length; i++) {
                    html += '<tr>';
                    html += '<td><label class="form-checkbox form-normal form-primary form-text"><input type="checkbox" name="' + response.data.data[i].id + '" ></label></td>';
                    html += '<td>' + response.data.data[i].sn + '</td>';
                    html += '<td>' + response.data.data[i].name + '</td>';
                    html + '</tr>';
                }
                if(response.data.next_page_url || response.data.prev_page_url) {
                    var next = 0, prev = 0;
                    if(response.data.next_page_url) {
                        next = response.data.current_page + 1;
                    }

                    if(response.data.prev_page_url) {
                        prev = response.data.current_page - 1;
                    }

                    paginate = '<div class="col-sm-2 col-sm-offset-10 paginate"><ul class="pager">';
                    if(prev>0) {
                        paginate += '<li>';
                    } else {
                        paginate += '<li class="disabled">';
                    }
                    paginate += '<a href="javascript:;" p-action-dom="product_list_paginate" page="'+prev+'"><i class="fa fa-long-arrow-left"></i></a></li>';
                    paginate += '&nbsp;&nbsp;';
                    if(next>0) {
                        paginate += '<li>';
                    } else {
                        paginate += '<li class="disabled">';
                    }
                    paginate += '<a href="javascript:;" p-action-dom="product_list_paginate" page="'+next+'"><i class="fa fa-long-arrow-right"></i></a></li>';
                    paginate += '</ul></div>';
                    $('tbody[p-action-dom="product_list"]').parents('table').after(paginate);
                }

            } else {
                html = '<tr><td colspan="4" align="center">产品列表为空</td></tr>';
            }
            $('tbody[p-action-dom="product_list"]').html(html)
        }, 'json');
    }

    // 分类点击效果
    var cid = 0;
    $("a[p-action-dom=select_product_category]").click(function(){
        if(!$(this).hasClass('active')) {
            cid = $(this).attr('category_id');
            $(this).addClass('active').siblings('a').removeClass('active');
            loadProduct(cid, 0);
        }
    });

    // 加载产品
    loadProduct(0, 0);

    // 产品分页
    $("#selectOrderProduct").on('click', 'a[p-action-dom="product_list_paginate"]', function(){
        var page = $(this).attr('page');
        if(page > 0) {
            loadProduct(cid, page);
        }
    });

    $('tbody[p-action-dom="product_list"]').on('click', 'input[type="checkbox"]', function(){
        // 列表checkbox点击效果
        $(this).parents("label").toggleClass('active');

        var id = $(this).attr('name');

        if($(this).parents("label").hasClass('active')) {
            var url = "{{ url('product') }}/" + id + "/sku";
            $.get(url, function(response){
                if(response.code == 1) {
                    var html_tr, html_td;
                    for(var j=0; j<response.data.length; j++) {
                        html_td += '<tr>';

                        for(var i=0; i<response.data[0].attribute.length; i++) {
                            if(j == 0) {
                                html_tr += '<th>' + response.data[0].attribute[i].name + '</th>';
                            }
                            html_td += '<td>' + response.data[j].attribute[i].value + '</td>';
                        }

                        if(j == 0) {
                            html_tr += '<th>进价</th>';
                            html_tr += '<th>库存</th>';
                            html_tr += '<th>销量</th>';
                            html_tr += '<th>售价（总价）</th>';
                        }

                        html_td += '<td>' + response.data[j].purchase_price + '</td>';
                        html_td += '<td>' + response.data[j].stock + '</td>';
                        html_td += '<td><input type="text" class="form-control col-sm-1 set-product-sku-input" name="num" sku_id="' + response.data[j].id + '" product_id="' + id + '" value="" /></td>';
                        html_td += '<td><input type="text" class="form-control col-sm-1 set-product-sku-input" name="price" sku_id="' + response.data[j].id + '" product_id="' + id + '" value="" /></td>';
                        html_td += '</tr>';
                    }

                    $('table[p-action-dom="set-product-sku-table"]>thead>tr').html(html_tr);
                    $('table[p-action-dom="set-product-sku-table"]>tbody').html(html_td);
                    $("#selectOrderProductSku").modal('show');
                } else {
                    swal('', '抱歉！获取产品列表失败', 'error');
                }
            }, 'json');
        } else {
            $("#submitOrder").children(".pid_" + id).remove();
        }
    });

    $('button[p-action-dom="set-product-sku"]').click(function(){
        var e = $('.set-product-sku-input');
        var html = '';
        var count = 0;
        for(var i=0; i<e.length; i++) {
            var v = e.eq(i).val();
            if(!isNaN(v) && v > 0) {
                var pid = e.eq(i).attr('product_id');
                var sid = e.eq(i).attr('sku_id');
                var name = e.eq(i).attr('name');
                html += '<input type="hidden" name="sku[' + sid+ '][' + name + ']" value="' + v + '" class="hidden-dynamic-sku pid_' + pid + '">';
                count += 1;
            }
        }

        if(count%2 != 0) {
            swal('', '抱歉！存在未填写的销量或售价', 'error');
            return;
        }

        $("#submitOrder").append(html);
        $("#selectOrderProductSku").modal('hide');
    });

    $(".delOrder").click(function(){
        var id = $(this).attr('order_id');
        swal({
            title: '',
            text: "确认删除该订单？",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },function(){
            $.ajax({
                url: "{{ url('order') }}/"+id,
                type: 'DELETE',
                data: {_token: '{{ csrf_token() }}'},
                dataType: 'json',
                success: function(response) {
                    if(response.code) {
                        swal({
                            title: '',
                            text: '删除成功',
                            type: "success",
                            confirmButtonText: "确认"
                        }, function(){
                            window.location.reload();
                        });
                    } else {
                        swal('', '删除失败', 'error');
                    }
                }
            });
        });
    })
});
</script>
@endsection