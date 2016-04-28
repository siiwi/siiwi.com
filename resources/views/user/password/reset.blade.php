@extends('layout')

@section('title')
    用户中心
@endsection

@section('content-title')
    重置密码
@endsection

@section('content-search-url')
    #
@endsection

@section('content-breadcrumb-title')
    重置密码
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel">
                <div class="panel-body">
                    <form id="reset_password" class="form-horizontal" method="POST" action="{{ url('user/') }}/{{ Auth::user()->id }}/password">
                        <div class="panel-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">原密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" name="old_password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">新密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" name="password" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">确认新密码</label>
                                <div class="col-sm-3">
                                    <input type="password" class="form-control" name="password_confirmation" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3 col-sm-offset-3">
                                    {{ csrf_field() }}
                                    <button class="btn btn-primary" type="submit">提交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('content-script')
    <script type="text/javascript">
        $(function(){
            $('#reset_password').bootstrapValidator({
                feedbackIcons: {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                },
                fields: {
                    old_password: {
                        container: 'tooltip',
                        validators: {
                            notEmpty: {
                                message: '请输入原密码'
                            }
                        }
                    },
                    password: {
                        container: 'tooltip',
                        validators: {
                            notEmpty: {
                                message: '请输入新密码'
                            }
                        }
                    },
                    password_confirmation: {
                        container: 'tooltip',
                        validators: {
                            notEmpty: {
                                message: '请输入确认密码'
                            },
                            identical: {
                                field: 'password',
                                message: '两次密码不一致'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endsection