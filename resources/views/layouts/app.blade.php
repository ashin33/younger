<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name') }}
    </title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-tagsinput/bootstrap-tagsinput.css') }}" rel="stylesheet">
    <link href="{{ asset('css/font-awesome/css/font-awesome.css') }}" rel="stylesheet">

    <!-- Select2 style -->
    <link href="{{ asset('css/select2/select2.min.css') }}" rel="stylesheet">

    <!-- Ladda style -->
    <link href="{{ asset('css/ladda/ladda-themeless.min.css') }}" rel="stylesheet">

    <!-- Sweet alert -->
    <link href="{{ asset('css/sweetalert/sweetalert2.css') }}" rel="stylesheet">

    <link href="{{ asset('css/animate.css') }}" rel="stylesheet">

    <!-- iCheck -->
    <link href="{{ asset('css/iCheck/flat/green.css') }}" rel="stylesheet">
    <link href="{{ asset('css/iCheck/custom.css') }}" rel="stylesheet">
    @yield('header')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">

    <style>
        html {
            font-size: 16px;
        }

        .swal2-container {
            z-index: 999999 !important;
        }

        .select2-dropdown--below{
            z-index: 3000
        }
    </style>
</head>

<body class="fixed-navigation" style="background-color: #2f4050">
<div id="wrapper">

    @include('layouts.sidebar')

    <div id="page-wrapper" class="gray-bg @if(route_name() == 'dashboard') sidebar-content @endif">
        <div class="row border-bottom">
            <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#">
                        <i class="fa fa-bars"></i>
                    </a>
                </div>

                <ul class="nav navbar-top-links navbar-right">

                    <li class="m-l-sm">
                        <div style="position: relative; top: 8px; text-align:right">
                            <span>younger</span>
                        </div>
                    </li>
                    <li>
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="padding: 0px;">
                            <!-- The user image in the navbar-->
                            <img src="{{asset('img/younger.svg')}}" class="user-image">
                            <i class="fa fa-sort-desc"></i>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        </a>
                        {{--                        <ul class="dropdown-menu">--}}
                        {{--                            <!-- Menu Footer-->--}}
                        {{--                            <li class="user-footer">--}}
                        {{--                                <a href="#" style="text-align: center">账号信息</a>--}}
                        {{--                                <a href="#"--}}
                        {{--                                   style="text-align: center">修改密码</a>--}}
                        {{--                                <a href="#"--}}
                        {{--                                   style="text-align: center">退出</a>--}}
                        {{--                            </li>--}}
                        {{--                        </ul>--}}
                    </li>
                </ul>
            </nav>
        </div>

        <div class="wrapper wrapper-content animated fadeInRight">
            @yield('content')

        </div>

        <div class="footer" style="">
            <div class="pull-right">
                <strong>younger.tech</strong>
            </div>
            <div>
                <strong>Copyright</strong> &copy; 2020-{{ date('Y') }}
            </div>
        </div>

    </div>
</div>

<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/jquery.serializejson.min.js') }}"></script>

<!-- Mainly scripts -->
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/slimscroll/jquery.slimscroll.min.js') }}"></script>

<!-- Sweet alert -->
<script src="{{ asset('js/sweetalert/sweetalert2.min.js') }}"></script>


<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/pace/pace.min.js') }}"></script>

<!-- Ladda -->
<script src="{{ asset('js/ladda/spin.min.js') }}"></script>
<script src="{{ asset('js/ladda/ladda.min.js') }}"></script>
<script src="{{ asset('js/ladda/ladda.jquery.min.js') }}"></script>

<!-- jQuery UI -->
<script src="{{ asset('js/jquery-ui/jquery-ui.min.js') }}"></script>


<script src="/js/select2/select2.full.min.js"></script>
<script src="/js/select2/zh-CN.js"></script>
<script src="/js/admin.js"></script>

<script src="{{ asset('js/iCheck/icheck.min.js') }}"></script>
<script>
    $('#reset-btn').click(function () {
        var formObj = $(this).parents('form');
        formObj.find('input[type=text]').val('');
        formObj.find('textarea').val('');
        formObj.find('input[type=radio]:first').attr('checked', true);
        formObj.find("select").each(function (k, selectObj) {
            selectObj = $(selectObj);
            selectObj.find("option:first").attr('selected', false).attr('selected', true);
            if (selectObj.hasClass("select2-hidden-accessible")) {
                selectObj.val(null).trigger("change");
                // selectObj.html('');
            }
        });
    });
</script>

<script>

    $(document).ready(function () {
        Ladda.bind('.ladda-button');

        $.extend({
            json: function (url, data, success, options) {
                let that = this, type = typeof data === 'function';

                if (type) {
                    options = success
                    success = data;
                    data = {};
                }

                options = options || {};

                return $.ajax({
                    type: options.type || 'post',
                    dataType: options.dataType || 'json',
                    data: data,
                    url: url,
                    success: function (res) {
                        if (res.code === 200) {
                            success && success(res);
                        } else {
                            Swal.fire({
                                title: "操作提醒",
                                text: res.msg || res.code,
                                icon: 'warning',
                                confirmButtonText: "确认",
                                closeOnConfirm: false
                            });
                            options.error && options.error();
                        }
                    },
                    error: function (e) {

                        Swal.fire({
                            title: e.status,
                            text: e.responseJSON.message,
                            icon: 'error',
                            confirmButtonText: "确认",
                            closeOnConfirm: false
                        });
                        options.error && options.error(e);
                    }
                });
            }
        })

    });
</script>

@yield('footer')
</body>
</html>
