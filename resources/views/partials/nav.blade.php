<header id="navbar">
    <div id="navbar-container" class="boxed">

        <!--Brand logo & name-->
        <!--================================-->
        <div class="navbar-header">
            <a href="/" class="navbar-brand">
                <img src="{{ asset('img/logo.png') }}"  class="brand-icon">
                <div class="brand-title">
                    <span class="brand-text">{{ config('app.site') }}</span>
                </div>
            </a>
        </div>
        <!--================================-->
        <!--End brand logo & name-->


        <!--Navbar Dropdown-->
        <!--================================-->
        <div class="navbar-content clearfix">
            <ul class="nav navbar-top-links pull-left">

                <!--Navigation toogle button-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li class="tgl-menu-btn">
                    <a class="mainnav-toggle" href="javascript:;">
                        <i class="fa fa-navicon fa-lg"></i>
                    </a>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End Navigation toogle button-->

            </ul>
            <ul class="nav navbar-top-links pull-right">
                <!--User dropdown-->
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <li id="dropdown-user" class="dropdown">
                    <a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle text-right">
                        <span class="pull-right">
                            <img class="img-circle img-user media-object" src="{{ asset('img/av1.png') }}" />
                        </span>
                        <div class="username hidden-xs">{{ Auth::user()->name }}</div>
                    </a>


                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right panel-default">

                        <!-- Dropdown heading  -->
                        <div class="pad-all bord-btm">
                            <p class="text-lg text-muted text-semibold mar-btm">750Gb of 1,000Gb Used</p>
                            <div class="progress progress-sm">
                                <div class="progress-bar" style="width: 70%;">
                                    <span class="sr-only">70%</span>
                                </div>
                            </div>
                        </div>


                        <!-- User dropdown menu -->
                        <ul class="head-list">
                            <li>
                                <a href="#">
                                    <i class="fa fa-user fa-fw fa-lg"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <span class="badge badge-danger pull-right">9</span>
                                    <i class="fa fa-envelope fa-fw fa-lg"></i> Messages
                                </a>
                            </li>
                            <li>
                                <a href="{{ url('user/') }}/{{ Auth::user()->id }}/password">
                                    <i class="fa fa-gear fa-fw fa-lg"></i> 密码重置
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-question-circle fa-fw fa-lg"></i> Help
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <i class="fa fa-lock fa-fw fa-lg"></i> Lock screen
                                </a>
                            </li>
                        </ul>

                        <!-- Dropdown footer -->
                        <div class="pad-all text-right">
                            <a href="{{ url('/auth/logout') }}" class="btn btn-primary">
                                <i class="fa fa-sign-out fa-fw"></i> 注销
                            </a>
                        </div>
                    </div>
                </li>
                <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                <!--End user dropdown-->

            </ul>
        </div>
        <!--================================-->
        <!--End Navbar Dropdown-->

    </div>
</header>