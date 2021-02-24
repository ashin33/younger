@extends('errors.main')

@section('code')
    404
@endsection

@section('content')

    <h1>404</h1>
    <h3 class="font-bold">Not Found</h3>

    <div class="error-desc">

        <br/>

        资源不存在，或已被删除
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