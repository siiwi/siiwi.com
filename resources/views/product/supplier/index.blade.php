@extends('layout')

@section('title')
    供应商
@endsection

@section('content-title')
    产品供应商列表
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    供应商
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <button class="btn btn-mint btn-labeled fa fa-plus" id="addSupplier">添加供应商</button>
                    </div>
                    <h3 class="panel-title">供应商列表</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>名称</th>
                                    <th>联系人</th>
                                    <th>电话</th>
                                    <th>电子邮箱</th>
                                    <th>地址</th>
                                    <th width="15%">描述</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(count($suppliers) > 0)
                                @foreach($suppliers as $supplier)
                                <tr>
                                    <td>{{ $supplier->id }}</td>
                                    <td><a class="btn-link" href="{{ $supplier->url ? $supplier->url : 'javascript:;' }}" target="_blank">{{ $supplier->name }}</a></td>
                                    <td>{{ $supplier->contact }}</td>
                                    <td>{{ $supplier->phone }}</td>
                                    <td>{{ $supplier->email }}</td>
                                    <td>{{ $supplier->address }}</td>
                                    <td><span class="label label-table label-default" title="{{ $supplier->desc }}">{{ $supplier->desc }}</span></td>
                                    <td>
                                        <button class="btn btn-xs btn-default add-tooltip editSupplier" data-toggle="tooltip" data-original-title="编辑" data-container="body" supplier_id="{{ $supplier->id }}"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-xs btn-danger add-tooltip deleteSupplier" data-toggle="tooltip" data-original-title="删除" data-container="body" supplier_id="{{ $supplier->id }}"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="8" class="text-center">暂无数据</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $suppliers->render() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Start modal-->
    <div id='supplierModel' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false"></div>
    <!--End modal-->
@endsection

@section('content-script')
<script type="text/javascript">
    // 添加供应商
    $("#addSupplier").click(function() {
        var url = "{{ url('supplier/create') }}";
        $.get(url, function(data){
            $('#supplierModel').html(data);
            $('#supplierModel').modal('show');
        });
    });

    // 编辑供应商
    $(".editSupplier").click(function() {
        var supplier_id = $(this).attr('supplier_id');
        var url = "{{ url('supplier') }}/" + supplier_id + '/edit';
        $.get(url, function(data){
            $('#supplierModel').html(data);
            $('#supplierModel').modal('show');
        });
    });

    // 删除供应商
    $('.deleteSupplier').click(function(){
        var supplier_id = $(this).attr('supplier_id');
        swal({
            title: '',
            text: "确认删除该供应商？",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },function(){
            $.ajax({
                url: "{{ url('supplier') }}/"+supplier_id,
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
</script>
@endsection