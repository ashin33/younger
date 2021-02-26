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
                                <a class="btn btn-sm btn-info" href="{{route('application.create')}}"> 新增应用</a>
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
                                <th class="text-middle">应用名称</th>
                                <th class="text-middle">应用ID(client_id)</th>
                                <th class="text-middle">应用密钥(client_secret)</th>
                                <th class="text-middle">启用状态</th>
                                <th class="text-middle">创建时间</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($rows as $row)
                                <tr>
                                    <td class="text-middle">{{$row->id}}</td>
                                    <td class="text-middle">{{$row->name}}</td>
                                    <td class="text-middle">{{$row->client_id}}</td>
                                    <td class="text-middle">{{$row->client_secret}}</td>
                                    <th class="text-middle">
                                        <i class="fa {{ $row->statusDisplay('icon') }}"></i> {{ $row->statusDisplay() }}
                                    </th>
                                    <td class="text-middle">{{$row->created_at}}</td>
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

@endsection


@section('footer')
    <script>
        $(function () {
            $('.select2').select2();
        });
    </script>
@endsection