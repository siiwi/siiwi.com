<div class="modal-dialog">
    <div class="modal-content">
        <form id="addAttributeForm" method="post" action="{{ url('category') }}/{{ $cid }}/attribute">
            <!--Modal header-->
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">添加新规格</h4>
            </div>

            <!--Modal body-->
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">规格名称：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="attribute_name" value="" />
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
                {{ csrf_field() }}
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $(function(){
        $('#addAttributeForm').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check-circle fa-lg text-success',
                invalid: 'fa fa-times-circle fa-lg',
                validating: 'fa fa-refresh'
            },
            fields: {
                attribute_name: {
                    container: 'tooltip',
                    validators: {
                        notEmpty: {
                            message: '请输入规格名称'
                        }
                    }
                }
            }
        });
    });
</script>