<div class="modal-dialog">
    <div class="modal-content">
        <form id="addCategoryForm" method="post" action="{{ url('category') }}@if(isset($cate->id))/{{ $cate->id }}@endif">
            <!--Modal header-->
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">@if(isset($cate->id))编辑产品分类@else添加产品分类@endif</h4>
            </div>

            <!--Modal body-->
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">分类名称：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="name" value="{{ isset($cate->name) ? $cate->name : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">父级分类：</label>
                            <div class="col-sm-7">
                                <select name="pid" @if(isset($cate['id'])) disabled @endif>
                                    <option value="0">-- 请选择 --</option>
                                @foreach($category as $value)
                                    <option value="{{ $value['id'] }}" @if(isset($cate['pid']) && ($value['id'] == $cate['pid']))selected="true"@endif>@if($value['type'])用户分类@else系统分类@endif - {{ $value['name'] }}</option>
                                @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Modal footer-->
            <div class="modal-footer">
                <p class="pull-left text-danger">*&nbsp;红色为必填项</p>
                <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                <button class="btn btn-primary" type="submit">提交</button>
                @if(isset($cate->id))
                    <input name="_method" type="hidden" value="PUT">
                @endif
                {{ csrf_field() }}
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        // select样式
        $('select[name="pid"]').chosen({ width: '100%' });

        $('#addCategoryForm').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check-circle fa-lg text-success',
                invalid: 'fa fa-times-circle fa-lg',
                validating: 'fa fa-refresh'
            },
            fields: {
                name: {
                    container: 'tooltip',
                    validators: {
                        notEmpty: {
                            message: '请输入分类名称'
                        }
                    }
                }
            }
        });
    });
</script>