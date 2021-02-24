@extends('errors.main')

@section('code')
    200
@endsection

@section('content')

    <h1 style="height: 160px"> </h1>

    <h2 class="font-bold" >成功</h2>

    <div class="error-desc">

        <br/>

        <br/>
        <br/>

        <h3>
            消息: {{ $exception->getMessage() }}
        </h3>

        <div class="btn-group">

            <a href="{{ url('/dashboard') }}" class="btn btn-success m-t"><i class="fa fa-home"></i> 返回主页</a>
            <button class="btn btn-primary m-t" type="button" onclick="history.back()"><i class="fa fa-mail-reply"></i> 返回上一页</button>

        </div>
    </div>


@endsection