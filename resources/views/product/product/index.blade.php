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
            <!-- start product_tab_1 -->
            <!--===================================================-->
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
            <!--===================================================-->
            <!-- end product_tab_1 -->

            <div id="product_tab_2" class="tab-pane fade">
                <div class="panel-body">
                    <!--===================================================-->
                    <!--start add product form-->
                    <form method="post" action="{{ url('product') }}" onsubmit="return form_validate();" id="add-product">
                        <div class="row">
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品名称" name="product_name" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="产品编号" name="sn" class="form-control" value="" />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input type="text" placeholder="进货链接" name="url" class="form-control" value="" />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-3">
                                <select name="cid" class="chosen_select" required>
                                    <option value="0">产品分类</option>
                                    @if(count($categories)>0)
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}">@if($category->type)用户分类@else系统分类@endif - {{ $category->name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="col-sm-3">
                                <select name="sid" class="chosen_select">
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
                                <input class="btn btn-default btn-block" type="button" id="setProductAttribute" value="规格设置"  />
                            </div>
                            <div class="col-sm-3 mar-btm">
                                <input class="btn btn-default btn-block" type="button" id="setProductResource" value="图片设置" />
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
                    <h3 class="panel-title">产品列表</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-vcenter">
                            <thead>
                            <tr>
                                <th width="80">#</th>
                                <th width="200">编号</th>
                                <th width="300">名称</th>
                                <th width="200">规格</th>
                                <th>分类</th>
                                <th>进货价(元)</th>
                                <th>库存</th>
                                <th>状态</th>
                                <th>销售量</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                                @if(count($product_sku) > 0)
                                @foreach($product_sku as $sku)
                                <tr>
                                    <td>
                                        @if(count($sku->resource)>0)
                                        <div p_action_dom="product_resource" style="min-height: 56px;">
                                            @foreach($sku->resource as $k => $resource)
                                            <a href="{{ $resource }}" class="thumbnail @if($k>0) hide @endif">
                                                <img src="{{ $resource }}" width="56" style="border-radius: 2px;" />
                                            </a>
                                            @endforeach
                                        </div>
                                        @else
                                            <img src="{{ asset('img/no-pic.jpg') }}" width="56" style="border-radius: 2px;" />
                                        @endif
                                    </td>
                                    <td>{{ $sku->sn }}</td>
                                    <td><a href="@if($sku->url){{ $sku->url }}@else javascript:; @endif" class="btn-link" target="_blank">{{ $sku->name }}</a></td>
                                    <td>
                                        @if(count($sku->attribute)>0)
                                        @foreach($sku->attribute as $v)
                                            {{ $v['name'] }}：{{ $v['value'] }}<br/>
                                        @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $sku->category_name }}</td>
                                    <td>{{ $sku->purchase_price }}</td>
                                    <td>{{ $sku->stock }}</td>
                                    <td>
                                        @if($sku->stock>0)
                                            <span class="label label-info">有货</span>
                                        @else
                                            <span class="label label-warning">缺货</span>
                                        @endif
                                    </td>
                                    <td>0</td>
                                    <td>
                                        <button class="btn btn-xs btn-danger add-tooltip deleteProductSku" data-toggle="tooltip" data-original-title="删除" data-container="body" product_sku="{{ $sku->id }}" ><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="9" class="text-center">暂无数据</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $product_sku !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start Add Product Attribute modal-->
    <!--================================-->
    @include('product.product.attribute')
    <!--===============================-->
    <!--End Add Product Attribute modal-->

    <!--Start Add Product Attribute modal-->
    <!--================================-->
    @include('product.product.resource')
    <!--===============================-->
    <!--End Add Product Attribute modal-->
@endsection

@section('content-script')
<script type="text/javascript">
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
        var product_name = $("input[name=product_name]").val();
        if(product_name.length <= 0) {
            nt('提交失败！请输入产品名称！');
            $("input[name=product_name]").focus();
            return false;
        }

        var cid = $("select[name=cid]").val();
        if(cid <= 0) {
            nt('提交失败！请选择产品分类！');
            $("select[name=cid]").focus();
            return false;
        }

        var sku = $(".hidden-dynamic-sku");
        if(sku.length <= 0) {
            nt('提交失败！请设置产品规格！');
            return false;
        }

        var resource = $(".hidden-dynamic-resource");
        if(resource.length <= 0) {
            nt('提交失败！请设置产品图片！');
            return false;
        }

        return true;
    }

    $(function(){
        // 添加产品select样式
        $('.chosen_select').chosen({ width: '100%' });

        // 产品图片
        $("div[p_action_dom=product_resource]").lightGallery({
            thumbnail:true
        });

        // 添加产品规格modal
        $("#setProductAttribute").click(function(){
            var cid = $('select[name=cid]').val();
            if(cid == 0) {
                nt('请先选择产品分类！');
                return false;
            }

            $("#addProductAttributeModal").modal('show');
        });

        // 添加产品图片modal
        $("#setProductResource").click(function(){
            $("#addProductResourceModal").modal('show');
        });

        // Modal规格列表
        $('select[name=cid]').change(function() {
            var cid = $('select[name=cid]').val();
            if(cid == 0) return false;
            var url = "{{ url('category') }}/" + cid + '/attributes';
            $.get(url, function(res){
                var html = '';
                if(res.length > 0) {
                    for(var i=0; i<res.length; i++) {
                        html += "<option value='" + res[i].id + "'>" + res[i].name + "</option>";
                    }
                }
                $("select[name=aid]").html(html).chosen({ width: '100%' }).trigger("chosen:updated");
            });

            // 表格init
            var table = '<thead><tr>' +
                    '<th>SKU</th>' +
                    '<th>库存</th>' +
                    '<th>进货价</th>' +
                    '<th>操作</th>' +
                    '</tr></thead>' +
                    '<tbody><tr>' +
                    '<td><input type="text" class="form-control" name="sku" /></td>' +
                    '<td><input type="text" class="form-control" name="stock" /></td>' +
                    '<td><input type="text" class="form-control" name="purchase_price" /></td>' +
                    '<td><button class="btn btn-xs btn-danger delete-sku"><i class="fa fa-times"></i></button></td>' +
                    '</tr></tbody>';
            $(".table-add-sku").parents('.table-responsive').addClass('hide');
            $(".table-add-sku").html(table);
        });

        // 选择规格
        $('select[name=aid]').change(function(a, b){
            // 添加规格
            if(b.selected) {
                var aid = b.selected;
                if(!isNaN(aid)) {
                    // 显示table
                    $(".table-add-sku").parents('.table-responsive').removeClass('hide');

                    // 表格th名称
                    var url = "{{ url('attribute') }}/" + aid;
                    $.get(url, function(res) {
                        var th = '<th class="aid_' + aid + '">' + res.name + '</th>';
                        $(".table-add-sku>thead>tr").prepend(th);
                    });

                    // 表格td内容
                    url = "{{ url('attribute') }}/" + aid + "/value";
                    $.get(url, function(res) {
                        var td = '<td class="aid_' + aid + ' dynamic"><select class="form-control" aid="' + aid + '">';
                        if(res.length > 0) {
                            for(var i=0; i<res.length; i++) {
                                td += "<option value='" + res[i].value + "'>" + res[i].value + "</option>";
                            }
                        }
                        td += '</select></td>';
                        $(".table-add-sku>tbody>tr").prepend(td);
                    });
                }
            }

            // 取消规格
            if(b.deselected) {
                var aid= b.deselected;
                $(".aid_"+aid).remove();
                if(!$("th[class^=aid]").length) {
                    $(".table-add-sku").parents('.table-responsive').addClass('hide');
                }
            }
        });

        // 添加一行SKU
        $('button[p_action_dom="add_sku"]').click(function(){
            var html = $(".table-add-sku>tbody>tr").eq(0).html();
            html = '<tr>' + html + '</td>';
            $(".table-add-sku>tbody").append(html);
        });

        // 删除一行SKU
        $(".table-add-sku").on("click", ".delete-sku", function(){
            if($(".table-add-sku>tbody>tr").length > 1) {
                $(this).parents('tr').remove();
            }
        });

        // 确认sku
        $("button[p_action_dom='confirm_add_sku']").click(function(){
            var status = true;
            var btn = $(this).button('loading');
            $(".hidden-dynamic-sku").remove();
            var a = $(".table-add-sku>tbody>tr");
            var attrs = [];
            var sku =[];
            loop:
            for(var i=0; i<a.length; i++) {
                var b = a.eq(i).find('td');
                var attr = '';
                for(var j = 0; j<b.length-1; j++) {
                    var c = b.eq(j);
                    var v, name;
                    if(b.eq(j).hasClass('dynamic')) {
                        v = b.eq(j).find("select").val();
                        name = b.eq(j).find("select").attr('aid');
                        attr += name + '-' + v;
                    } else {
                        v = b.eq(j).find("input").val();
                        name = b.eq(j).find("input").attr('name');
                    }

                    if(name == 'stock') {
                        if(isNaN(v) || v < 0 || v.length <= 0) {
                            swal('', '请输入库存，且库存只能为大于等于0的数字', 'error');
                            status = false;
                            break loop;
                        }
                    }

                    if(name == 'purchase_price') {
                        if(isNaN(v) || v < 0 || v.length <= 0) {
                            swal('', '请输入进货价，进货价只能为大于等于0的数字', 'error');
                            status = false;
                            break loop;
                        }
                    }

                    if(name == 'sku') {
                        if(v.length > 0) {
                            var url = "{{ url('sku') }}/" + v;
                            $.ajax({
                                type: "GET",
                                url: url,
                                dataType: "json",
                                async: false,
                                success: function(response){
                                    if(response.code == 1) status = false;
                                }
                            });
                            if(!status) {
                                swal('', 'SKU已存在', 'error');
                                break loop;
                            }
                            if($.inArray(v, sku) >= 0) {
                                swal('', '输入了相同的SKU值', 'error');
                                status = false;
                                break;
                            }
                            sku.push(v);
                        }
                    }

                    var html = '';
                    if(!isNaN(name)) {
                        html = "<input type='hidden' name='sku["+i+"][attribute]["+name+"]' value='"+v+"' class='hidden-dynamic-sku' />";
                    } else {
                        html = "<input type='hidden' name='sku["+i+"]["+name+"]' value='"+v+"' class='hidden-dynamic-sku' />";
                    }

                    $("#add-product").append(html);
                }

                if($.inArray(attr, attrs) >= 0) {
                    swal('', '存在相同的规格组，请确认', 'error');
                    status = false;
                    break;
                }

                attrs.push(attr);
            }

            btn.button('reset');
            if(!status) return;

            $("#addProductAttributeModal").modal('hide');
        });

        $("#product-upload-resource").fileinput({
            language: 'zh',
            uploadUrl: "{{ url('upload') }}",
            allowedFileExtensions: ["jpg", "png", "gif"],
            allowedFileTypes: ["image"],
            showClose: false,
            showCaption: false,
            maxFileSize: 1200,
            maxFileCount: 10,
            removeFromPreviewOnError: true,
            layoutTemplates: {actionDelete: '<button type="button" class="kv-file-remove hide" title="删除文件"><i class="glyphicon glyphicon-trash text-danger"></i></button>'}
        }).on('fileuploaded', function(e, d) {
            if(d.response.code == 1) {
                var html = "<input type='hidden' name='resource[]' value='" + d.response.data + "' class='hidden-dynamic-resource' />";
                $("#add-product").append(html);
            } else {
                $.niftyNoty({
                    type: 'danger',
                    icon: 'fa fa-bolt fa-lg',
                    message: d.response.message + ':' + d.response.data,
                    container: 'floating',
                    closeBtn: true,
                    timer: 3000
                });
            }
        }).on('filecleared', function(e) {
            $(".hidden-dynamic-resource").remove();
        });

        // 删除SKU
        $(".deleteProductSku").click(function() {
            var product_sku = $(this).attr('product_sku');
            swal({
                title: '',
                text: "确认删除该产品？",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false
            },function(){
                $.ajax({
                    url: "{{ url('product') }}/"+product_sku,
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
        });
    });
</script>
@endsection