@extends('auth.auth')

@section('title')
    找回密码
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
                    <p class="pad-btm">输入注册电子邮箱，找回密码</p>
                    <form action="{{ url('password/email') }}" method="POST" id="resetPassword">
                        {!! csrf_field() !!}
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-envelope"></i></div>
                                <input type="text" name="email" class="form-control" placeholder="电子邮箱" />
                            </div>
                        </div>
                        <div class="form-group text-right">
                            <button class="btn btn-primary" type="botton">发送邮件</button>
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
                    }
                }
            });
        });
    </script>
@endsection