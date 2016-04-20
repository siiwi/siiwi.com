<!--MAIN NAVIGATION-->
<!--===================================================-->
<nav id="mainnav-container">
    <div id="mainnav">

        <div id="mainnav-shortcut"></div>

        <!--Menu-->
        <!--================================-->
        <div id="mainnav-menu-wrap">
            <div class="nano">
                <div class="nano-content">
                    <ul id="mainnav-menu" class="list-group">

                        <!--Category name-->
                        <li class="list-header">常用功能</li>

                        <!--Menu list item-->
                        <li @if(Route::currentRouteName() == 'home.index') class="active active-sub active-link" @endif>
                            <a href="{{ url('/') }}">
                                <i class="fa fa-dashboard"></i>
                                <span class="menu-title">
                                    <strong>控制面板</strong>
                                </span>
                            </a>
                        </li>

                        <!--Menu list item-->
                        <li @if(in_array(Route::currentRouteName(), array('supplier.index', 'category.index', 'category.attribute.index'))) class="active active-sub" @endif>
                            <a href="javascript:;">
                                <i class="fa fa-th"></i>
                                <span class="menu-title">
                                    <strong>产品管理</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li @if(in_array(Route::currentRouteName(), ['category.index', 'category.attribute.index'])) class="active-link" @endif><a href="{{ url('category') }}">产品分类列表</a></li>
                                <li @if(Route::currentRouteName() == 'supplier.index') class="active-link" @endif><a href="{{ url('supplier') }}">产品供应商列表</a></li>
                                <li><a href="javascript:;">产品列表</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-table"></i>
                                <span class="menu-title">
                                    <strong>订单管理</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="javascript:;">订单列表</a></li>
                            </ul>
                        </li>

                        <li class="list-divider"></li>

                        <!--Category name-->
                        <li class="list-header">其他功能</li>

                        <!--Menu list item-->
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-briefcase"></i>
                                <span class="menu-title">
                                    <strong>财务管理</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="javascript:;">财务记账</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-line-chart"></i>
                                <span class="menu-title">
                                    <strong>报表管理</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="javascript:;">销售报表</a></li>
                                <li><a href="javascript:;">产品排名</a></li>
                            </ul>
                        </li>

                        <li class="list-divider"></li>

                        <!--Category name-->
                        <li class="list-header">应用工具</li>

                        <!--Menu list item-->
                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-briefcase"></i>
                                <span class="menu-title">
                                    <strong>刊登工具</strong>
                                </span>
                                <i class="arrow"></i>
                            </a>

                            <!--Submenu-->
                            <ul class="collapse">
                                <li><a href="javascript:;">eBay</a></li>
                            </ul>
                        </li>

                        <li>
                            <a href="javascript:;">
                                <i class="fa fa-line-chart"></i>
                                <span class="menu-title">
                                    <strong>关键词排名查询</strong>
                                </span>
                            </a>
                        </li>

                    </ul>

                </div>
            </div>
        </div>
        <!--================================-->
        <!--End menu-->

    </div>
</nav>
<!--===================================================-->
<!--END MAIN NAVIGATION-->