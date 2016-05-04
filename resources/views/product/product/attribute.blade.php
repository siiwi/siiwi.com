<div id='addProductAttributeModal' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <!--Modal header-->
            <div class="modal-header">
                <h4 class="modal-title">添加产品&nbsp;-&nbsp;规格设置</h4>
            </div>

            <!--Modal body-->
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="panel-body">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-sm-10 col-sm-offset-1">
                                    <select name="aid" multiple data-placeholder="请选择规格项;若规格项下拉为空,请先至产品分类下设置"></select>
                                </div>
                            </div>
                        </div>
                        <div class="row table-responsive hide">
                            <table class="table table-striped table-hover table-add-sku">
                            </table>
                            <button class="btn btn-primary btn-labeled btn-xs fa fa-plus" p_action_dom="add_sku">添加一条</button>
                        </div>
                    </div>
                </div>
            </div>

            <!--Modal footer-->
            <div class="modal-footer">
                <button class="btn btn-default" type="button" data-dismiss="modal">取消</button>
                <button class="btn btn-primary" type="button" data-loading-text="Loading..." p_action_dom="confirm_add_sku">确认</button>
            </div>
        </div>
    </div>
</div>