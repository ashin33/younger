<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a href="{{url('/')}}">
                        <span style="margin: auto">
                            <img alt="image" class="img-circle" src="{{ asset('img/younger.jpg') }}"
                                 style="width: 80px;height: 80px;"/>
                             </span>
                        <span class="clear">
                         <span class="block m-t-xs">
                             <strong class="font-bold text-white">
                                 紫箸餐厅自助点餐系统
                             </strong>
                         </span>
                     </span>
                    </a>

                </div>
                <div class="logo-element">
                    紫箸
                </div>
            </li>


            <li class="@if(current_namespace() == 'Order') active @endif">
                <a href="{{ route('order.index') }}" style="">
                    <i class="fa fa-book"></i> <span class="nav-label">订单列表</span>
                </a>
            </li>

            <li class="@if(current_namespace() == 'Printer') active @endif">
                <a href="#"><i class="fa fa-print"></i> <span class="nav-label">打印机管理</span>
                    <span class="fa arrow"></span>
                </a>
                <ul class="nav nav-second-level collapse">
                    <li class="@if(route_name() == 'printer.manage') active @endif"><a
                                href="{{ route('printer.manage') }}">机器管理</a></li>
                    <li class="@if(route_name() == 'printer.list') active @endif"><a
                                href="{{ route('printer.list') }}">打印列表</a></li>
                </ul>
            </li>
        </ul>

    </div>
</nav>
