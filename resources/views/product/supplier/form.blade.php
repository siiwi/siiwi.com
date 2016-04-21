<div class="modal-dialog">
    <div class="modal-content">
        <form id="addSupplierForm" method="post" action="{{ url('supplier') }}@if(isset($supplier->id))/{{ $supplier->id }}@endif">
            <!--Modal header-->
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">@if(isset($supplier->id))编辑供应商@else添加供应商@endif</h4>
            </div>

            <!--Modal body-->
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="panel-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">名称：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="supplier_name" value="{{ isset($supplier->name) ? $supplier->name : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">联系人：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="contact" value="{{ isset($supplier->contact) ? $supplier->contact : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">电话：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="phone" value="{{ isset($supplier->phone) ? $supplier->phone : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label text-danger">电子邮箱：</label>
                            <div class="col-sm-7">
                                <input type="email" class="form-control input-sm" name="email" data-bv-field="email" value="{{ isset($supplier->email) ? $supplier->email : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">联系地址：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="address" value="{{ isset($supplier->address) ? $supplier->address : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">网上链接：</label>
                            <div class="col-sm-7">
                                <input type="text" class="form-control input-sm" name="url" value="{{ isset($supplier->url) ? $supplier->url : '' }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">描述：</label>
                            <div class="col-sm-7">
                                <textarea rows="4" class="form-control" name="desc" style="resize:none;">{{ isset($supplier->desc) ? $supplier->desc : '' }}</textarea>
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
                @if(isset($supplier->id))
                <input name="_method" type="hidden" value="PUT">
                @endif
                {{ csrf_field() }}
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
$(function(){
    $('#addSupplierForm').bootstrapValidator({
        feedbackIcons: {
            valid: 'fa fa-check-circle fa-lg text-success',
            invalid: 'fa fa-times-circle fa-lg',
            validating: 'fa fa-refresh'
        },
        fields: {
            supplier_name: {
                container: 'tooltip',
                validators: {
                    notEmpty: {
                        message: '请输入供应商名称'
                    }
                }
            },
            contact: {
                container: 'tooltip',
                validators: {
                    notEmpty: {
                        message: '请输入联系人'
                    }
                }
            },
            phone: {
                container: 'tooltip',
                validators: {
                    notEmpty: {
                        message: '请输入供应商联系方式'
                    }
                }
            },
            email: {
                container: 'tooltip',
                validators: {
                    notEmpty: {
                        message: '请输入电子邮箱'
                    },
                    regexp: {
                        regexp: /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/,
                        message: '电子邮箱格式不正确'
                    }
                }
            }
        }
    });
});
</script>