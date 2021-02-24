@extends('errors.main')

@section('code')
    400
@endsection

@section('content')

    <h1>400</h1>
    <h3 class="font-bold">Bad Request</h3>

    <div class="error-desc">

        <br/>

        数据有误，请求被拒绝
        <br/>
        <br/>

        <p>
            消息: {{ $exception->getMessage() }}
        </p>

        <div class="btn-group">

            <a href="{{ url('/dashboard') }}" class="btn btn-success m-t"><i class="fa fa-home"></i> 返回主页</a>
            <button class="btn btn-primary m-t" type="button" onclick="history.back()"><i class="fa fa-mail-reply"></i> 返回上一页</button>

        </div>
    </div>


@endsection