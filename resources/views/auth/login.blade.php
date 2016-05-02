@extends('auth.auth')

@section('title')
    登录
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
                <p class="pad-btm">登录</p>
                <form action="{{ url('auth/login') }}" method="POST" id="login">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-user"></i></div>
                            <input type="text" class="form-control" placeholder="电子邮箱" name="email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                            <input type="password" class="form-control" placeholder="密码" name="password" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="text-left checkbox">
                            <label class="form-checkbox form-icon">
                                <input type="checkbox" name="remember" /> 自动登录
                            </label>
                        </div>
                        <div class="text-right">
                            <button class="btn btn-primary" type="submit">登录</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="pad-ver">
            <a href="{{ url('password/email') }}" class="btn-link mar-rgt">忘记密码</a>
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
            $('#login').bootstrapValidator({
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
                    }
                }
            });
        });
    </script>
@endsection