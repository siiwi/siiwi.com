<div id='selectOrderProduct' class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog" style="width: 90%">
        <div class="modal-content">
            <!--Modal header-->
            <div class="modal-header">
                <button data-dismiss="modal" class="close" type="button">
                    <span aria-hidden="true">×</span>
                </button>
                <h4 class="modal-title">添加订单&nbsp;-&nbsp;产品设置</h4>
            </div>

            <!--Modal body-->
            <div class="modal-body">
                <div class="panel-body"  style="background: #e7ebee;">
                    <div class="col-sm-3 eq-box-sm">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">产品分类</h3>
                            </div>
                            <div class="panel-body" style="overflow-y:scroll; min-height: 200px; max-height: 350px;">
                                <div class="list-group">
                                    @if(count($category) > 0)
                                    @foreach($category as $cate)
                                        <a class="list-group-item  list-item-sm" p-action-dom="select_product_category" category_id="{{ $cate['id'] }}" href="javascript:;">@if($cate['p_name']){{ $cate['p_name'] }}&nbsp;&nbsp;&gt;&nbsp;&nbsp;@endif{{ $cate['name'] }}</a>
                                    @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-9 eq-box-sm">
                        <div class="panel">
                            <div class="panel-heading">
                                <h3 class="panel-title">产品列表</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th class="col-sm-1">#</th>
                                                <th class="col-sm-3">产品编号</th>
                                                <th class="col-sm-7">产品名称</th>
                                            </tr>
                                        </thead>
                                        <tbody p-action-dom="product_list"></tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--Modal footer-->
            <div class="modal-footer">
                <button class="btn btn-primary" type="button" data-dismiss="modal">确认</button>
            </div>
        </div>
    </div>
</div>