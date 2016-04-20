@extends('auth.auth')

@section('title')
    注册
@endsection

@section('content')

    <div id="container" class="cls-container">


        <!-- BACKGROUND IMAGE -->
        <!--===================================================-->
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

        <!-- REGISTRATION FORM -->
        <!--===================================================-->
        <div class="cls-content">
            <div class="cls-content-sm panel">
                <div class="panel-body">
                    <p class="pad-btm">注册</p>
                    <form action="{{ url('auth/register') }}" method="post" id="register">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-user"></i></div>
                                <input type="text" class="form-control" placeholder="用户名" name="name" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="text" class="form-control" placeholder="电子邮箱" name="email" />
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-lock"></i></div>
                                <input type="password" class="form-control" placeholder="密码" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-key"></i></div>
                                <input type="password" class="form-control" placeholder="确认密码" name="password_confirmation">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-8 text-left checkbox">
                                <label class="form-checkbox form-icon">
                                    <input type="checkbox" name="agree">同意并接受 <a href="#" style="color: #23527c;">Siiwi.com 服务条款</a>
                                </label>
                            </div>
                            <div class="col-xs-4">
                                <div class="form-group text-right">
                                    <button class="btn btn-success text-uppercase"  type="submit">提交</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="pad-ver">
                <a href="{{ url('password/email') }}" class="btn-link mar-rgt">忘记密码？</a>
                <a href="{{ url('auth/login') }}" class="btn-link mar-rgt">登录</a>
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
            $('#register').bootstrapValidator({
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
                                message: '请输入用户名'
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