<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>younger</title>
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body>
<div class="table-responsive">
    <table class="table table-hover text-nowrap">
        <thead>
        <tr>
            <th class="text-middle">ID</th>
            <th class="text-middle">日期</th>
            <th class="text-middle">操作</th>
        </tr>
        </thead>
        <tbody>

        @foreach($rows as $row)
            <tr>
            <td class="text-middle">{{$row->id}}</td>
            <td class="text-middle">{{$row->date}}</td>
            <td class="text-middle">
                <a class="btn-success btn btn-xs"
                   href="{{ route('younger.detail', $row->date) }}">
                    明细
                </a>
                <a class="btn-primary btn btn-xs"
                   href="{{ route('younger.download', $row->date) }}">
                    下载
                </a>
            </td>
            </tr>
        @endforeach

        </tbody>
    </table>
</div>

{!! $rows->links() !!}

</body>
<script src="{{asset('js/jquery-2.2.3.min.js')}}" charset="utf-8"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/select2/select2.full.min.js') }}"></script>
<script src="{{ asset('js/select2/zh-CN.js') }}"></script>
<script>
    $(function () {
        $('.select2').select2();
    });
</script>
</html>