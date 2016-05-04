@extends('auth.auth')

@section('title')
    重置密码
@endsection

@section('content')
    <div id="container" class="cls-container">
        <div id="bg-overlay" class="bg-img img-balloon"></div>

        <!-- HEADER -->
        <!--===================================================-->
        <div class="cls-header cls-header-lg">
            <div class="cls-brand">
                <a class="box-inline" href="{{ url('/') }}">
                    <span class="brand-title">{{ config('app.site') }}</span>
                </a>
            </div>
        </div>
        <!--===================================================-->

        <!-- LOGIN FORM -->
        <!--===================================================-->
        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <form action="{{ url('password/reset') }}" method="POST" id="resetPassword">
                        {!! csrf_field() !!}
                        <input type="hidden" name="token" value="{{ $token }}">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="text" name="email" class="form-control" placeholder="电子邮箱" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                <input type="password" name="password" class="form-control" placeholder="新密码" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" placeholder="确认密码" name="password_confirmation" value="" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="text-right">
                                <button class="btn btn-primary" type="submit">提交</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pad-ver">
                <a href="{{ url('auth/login') }}" class="btn-link mar-rgt">登录</a>
                <a href="{{ url('auth/register') }}" class="btn-link mar-lft">注册</a>
            </div>
        </div>
        <!--===================================================-->
    </div>
    <!--===================================================-->
    <!-- END OF CONTAINER -->
@endsection

@section('script')
    <script type="text/javascript">
        $(function(){
            $('#resetPassword').bootstrapValidator({
                feedbackIcons: {
                    valid: 'fa fa-check-circle fa-lg text-success',
                    invalid: 'fa fa-times-circle fa-lg',
                    validating: 'fa fa-refresh'
                },
                fields: {
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
                    },
                    password: {
                        container: 'tooltip',
                        validators: {
                            notEmpty: {
                                message: '请输入密码'
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