@extends('layout')

@section('title')
    分类
@endsection

@section('content-title')
    产品分类列表
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    产品分类
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <button class="btn btn-mint btn-labeled fa fa-plus" id="addCategory">添加分类</button>
                    </div>
                    <h3 class="panel-title">分类列表</h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>名称</th>
                                    <th>父级分类</th>
                                    <th>类型</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                            @if(count($category)>0)
                            @foreach($category as $cate)
                                <tr>
                                    <td>{{ $cate->id }}</td>
                                    <td>{{ $cate->name }}</td>
                                    <td>{{ $cate->pname }}</td>
                                    <td>{{ ($cate->type == 1) ? '自定义分类' : '系统分类' }}</td>
                                    <td>
                                        <a class="btn btn-success btn-xs add-tooltip" data-toggle="tooltip" data-original-title="规格管理" data-container="body" href="{{ url('category') }}/{{ $cate->id }}/attribute" target="_blank"><i class="fa fa-cog"></i></a>
                                    @if($cate->type == 1)
                                        <button class="btn btn-xs btn-default add-tooltip editCategory" data-toggle="tooltip" data-original-title="编辑" data-container="body" category_id="{{ $cate->id }}"><i class="fa fa-pencil"></i></button>
                                        <button class="btn btn-xs btn-danger add-tooltip deleteCategory" data-toggle="tooltip" data-original-title="删除" data-container="body" category_id="{{ $cate->id }}"><i class="fa fa-times"></i></button>
                                    @endif
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">暂无数据</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $category !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start modal-->
    <div id='categoryModel' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false"></div>
    <!--End modal-->
@endsection

@section('content-script')
<script type="text/javascript">
    $(function(){
        // 添加产品分类
        $("#addCategory").click(function() {
            var url = "{{ url('category/create') }}";
            $.get(url, function(data){
                $('#categoryModel').html(data);
                $('#categoryModel').modal('show');
            });
        });

        // 编辑产品分类
        $(".editCategory").click(function() {
            var category_id = $(this).attr('category_id');
            var url = "{{ url('category') }}/" + category_id + '/edit';
            $.get(url, function(data){
                $('#categoryModel').html(data);
                $('#categoryModel').modal('show');
            });
        });

        // 删除产品分类
        $(".deleteCategory").click(function() {
            var category_id = $(this).attr('category_id');
            swal({
                title: '',
                text: "确认删除该分类？",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "确认",
                cancelButtonText: "取消",
                closeOnConfirm: false
            },function(){
                $.ajax({
                    url: "{{ url('category') }}/"+category_id,
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