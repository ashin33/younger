@extends('layouts.app')

@section('header')

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-content">
                    <form action="" method="get" id="form">
                        <div class="row">
                            <div class="col-sm-2 m-b">
                                <a class="btn btn-sm btn-info" href="{{route('printer.create')}}"> 新增打印机</a>
                            </div>
                        </div>

                    </form>
                    @if(session('success'))
                        <div class="alert alert-info alert-dismissable text-center">
                            <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                            {!! session('success') !!}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap table-bordered">
                            <thead>
                            <tr>
                                <th class="text-middle">ID</th>
                                <th class="text-middle">打印机名称</th>
                                <th class="text-middle">打印机终端号</th>
                                <th class="text-middle">打印机秘钥</th>
                                <th class="text-middle">启用状态</th>
                                <th class="text-middle">授权状态</th>
                                <th class="text-middle">创建时间</th>
                                <th class="text-middle">操作</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($rows as $row)
                                <tr>
                                    <td class="text-middle">{{$row->id}}</td>
                                    <td class="text-middle">{{$row->name}}</td>
                                    <td class="text-middle">{{$row->machine_code}}</td>
                                    <td class="text-middle">{{$row->m_sign}}</td>
                                    <th class="text-middle">
                                        <i class="fa {{ $row->statusDisplay('icon') }}"></i> {{ $row->statusDisplay() }}
                                    </th>
                                    <th class="text-middle">
                                        <i class="fa {{ $row->authStatusDisplay('icon') }}"></i> {{ $row->authStatusDisplay() }}
                                    </th>
                                    <td class="text-middle">{{$row->created_at}}</td>
                                    <td class="text-middle">
                                        <a class="btn btn-white btn-xs authorize" href="#" data-toggle="modal"
                                           data-target="#auth" attr-url="{{route('printer.authorize',['id' => $row->id])}}">
                                            <i class="fa fa-link"></i> 授权
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>


                    {!! $rows->links() !!}

                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="auth" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">打印机授权应用</h4>
                </div>
                <div class="modal-body row">
                    <label class="col-sm-6">请选择应用</label>
                    <div class="col-sm-6">
                        <select name="application_id" class="input-sm m-b form-control select2" id="application_id">
                            <option value="">请选择要授权的应用</option>
                            @foreach($applications as $k => $v)
                                <option value="{{$v->id}}">{{$v->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="auth_url">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">取消</button>
                    <button class="btn btn-primary" id="authorize">确定</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection


@section('footer')
    <script>
        $(function () {
            $('.select2').select2();

            $('.authorize').click(function (){
                let url = $(this).attr('attr-url');
                $('#auth_url').val(url);
            });

            $('#authorize').click(function (){
                let url = $('#auth_url').val();
                let application_id = $('#application_id').val();
                if (!application_id) {
                    Swal.fire({
                        title: "操作提醒",
                        text: '请选择要授权的应用',
                        icon: 'warning',
                        closeOnConfirm: false,
                        allowOutsideClick: false,
                        confirmButtonText: '确认'
                    });
                    return false;
                }

                Swal.queue([{
                    title: "操作提醒?",
                    text: "确定授权吗?授权操作暂不可逆",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "确认",
                    cancelButtonText: "取消",
                    showLoaderOnConfirm: true,
                    allowOutsideClick: false,
                    focusCancel: true,
                    preConfirm: () => {
                        return $.post(url, {
                            '_token': '{{csrf_token()}}',
                            'application_id': application_id,
                        }, function (res) {
                            Swal.fire({
                                icon: res.code === 200 ? 'success' : 'warning',
                                title: '操作提醒',
                                text: res.msg,
                                confirmButtonText: "确认",
                                allowOutsideClick: false,
                                preConfirm: () => {
                                    if (res.code === 200) {
                                        location.reload();
                                    }
                                }
                            });
                        }, 'json');
                    }
                }]);
            });


        });
    </script>
@endsection