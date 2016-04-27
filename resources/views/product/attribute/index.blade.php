@extends('layout')

@section('title')
    规格
@endsection

@section('content-title')
    产品规格列表
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    产品规格
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-heading">
                    <div class="panel-control">
                        <button class="btn btn-mint btn-labeled fa fa-plus" id="addAttribute">添加规格</button>
                    </div>
                    <h3 class="panel-title">
                        规格列表 -
                        <select onchange="location.href=this.options[this.selectedIndex].value;" class="form-control" style="width: 260px; display: inline-block;">
                            @foreach($category as $value)
                                <option value="{{ url('category') }}/{{ $value['id'] }}/attribute" @if($value['id'] == $cid)selected="true"@endif>@if($value['type'])用户分类@else系统分类@endif - {{ $value['name'] }}</option>
                            @endforeach
                        </select>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">规格组</th>
                                <th class="text-center">规格项</th>
                                <th class="text-center">操作</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($attribute)>0)
                            @foreach($attribute as $attr)
                                <tr>
                                    <td class="text-center">
                                        {{ $attr->id }}
                                    </td>
                                    <td class="text-center">
                                        {{ $attr->name }}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control attributeValue" data-role="tagsinput" attribute_id="{{ $attr->id }}" placeholder="添加规格值" value="{{ join(',', $attr->value) }}" />
                                    </td>
                                    <td class="text-center">
                                        <button class="btn btn-xs btn-danger add-tooltip deleteAttribute" data-toggle="tooltip" data-original-title="删除" data-container="body" attribute_id="{{ $attr->id }}"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">暂无数据</td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {!! $attribute !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Start modal-->
    <div id='attributeModel' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false"></div>
    <!--End modal-->
@endsection

@section('content-script')
<script type="text/javascript">
$(function(){
    // 添加规格值
    $(".attributeValue").on('beforeItemAdd', function(e) {
        var attribute_id = $(this).attr('attribute_id');
        var url = "{{ url('attribute') }}/" + attribute_id + "/value";
        var params = {};
        params.value = e.item;
        params._token = "{{ csrf_token() }}";

        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: params,
            async: false,
            success: function(response) {
                var type = (response.code == 1) ? 'info' : 'danger';
                $.niftyNoty({
                    type: type,
                    icon: 'fa fa-info fa-lg',
                    container : 'floating',
                    message : response.message,
                    closeBtn: true,
                    timer : 2500
                });
            }
        });
    });

    // 删除规格值
    $(".attributeValue").on('beforeItemRemove', function(e) {
        var env = window.event;
        if(env.keyCode == 8) {
            e.cancel = true;
            return false;
        }
        var attribute_id = $(this).attr('attribute_id');
        var value = e.item;
        var url = "{{ url('attribute') }}/" + attribute_id + "/value/" + value;
        var params = {};
        params._token = "{{ csrf_token() }}";

        $.ajax({
            url: url,
            type: 'DELETE',
            dataType: 'json',
            data: params,
            async: false,
            success: function(response) {
                var type = (response.code == 1) ? 'info' : 'danger';
                $.niftyNoty({
                    type: type,
                    icon: 'fa fa-info fa-lg',
                    container : 'floating',
                    message : response.message,
                    closeBtn: true,
                    timer : 2500
                });
            }
        });
    });

    // 添加新规格
    $("#addAttribute").click(function() {
        var url = "{{ url('category') }}/{{ $cid }}/attribute/create";
        $.get(url, function(data){
            $('#attributeModel').html(data);
            $('#attributeModel').modal('show');
        });
    });

    // 删除规格
    $(".deleteAttribute").click(function() {
        var attribute_id = $(this).attr('attribute_id');
        swal({
            title: '',
            text: "确认删除该规格？",
            type: "warning",
            showCancelButton: true,
            confirmButtonText: "确认",
            cancelButtonText: "取消",
            closeOnConfirm: false
        },function(){
            $.ajax({
                url: "{{ url('category') }}/{{ $cid }}/attribute/"+attribute_id,
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