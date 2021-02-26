@extends('layouts.app')

@section('header')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        新增易联云应用
                        <small class="text-danger">[*]</small>
                        <small> 为必填项, 暂只支持自用型应用的创建</small>
                    </h5>
                </div>
                <div class="ibox-content">

                    <div class="alert alert-danger alert-dismissable text-center {{ $errors->first('error') ? '' : 'collapse'}}">
                        <span><strong>{{ $errors->first('error') }}</strong></span>
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    </div>

                    <form method="post" class="form-horizontal" action="{{ route('application.store') }}" id="form">

                        {{ csrf_field() }}
                        <input type="hidden" name="pre_url" value="{{url()->previous()}}">

                        <div class="form-group m-b {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">应用名称<span class="text-danger"></span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="应用名称" value="{{ old('name') }}" maxlength="32">
                                <small class="help-block m-b-none text-muted">请输入应用名称,用于区分应用</small>
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group m-b {{ $errors->has('client_id') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">应用ID(client_id)<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="client_id" placeholder="应用ID" value="{{ old('client_id') }}" maxlength="255">
                                <small class="help-block m-b-none text-muted">应用ID</small>
                            </div>
                            @if ($errors->has('client_id'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('client_id') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group m-b {{ $errors->has('client_secret') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">应用密钥(client_secret)<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="client_secret" placeholder="应用密钥" value="{{ old('client_secret') }}" maxlength="255">
                                <small class="help-block m-b-none text-muted">应用密钥</small>
                            </div>
                            @if ($errors->has('client_secret'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('m_sign') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group m-b {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">启用状态<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                @foreach(\App\Models\Application::$status as $k => $v)
                                    <label class="i-checks checkbox-inline">
                                        <input type="radio" value="{{ $k }}" name="status" class="i-checks checkbox-inline checkbox" @if(old('status') == $k) checked @endif> {{$v['text']}}
                                    </label>
                                @endforeach
                                <small class="help-block m-b-none text-muted">是否启用应用,当前模式暂不支持多应用同时启用</small>
                            </div>
                            @if ($errors->has('status'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('status') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group m-b">
                            <div class="col-sm-4 col-sm-offset-2">
                                <a class="btn btn-sm btn-white" href="{{url()->previous()}}">
                                    <i class="fa fa-mail-reply m-r-xs"></i>
                                    返回
                                </a>

                                <button type="submit" class="btn btn-sm btn-primary">
                                    <i class="fa fa-cloud-upload m-r-xs"></i>
                                    保存
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer')
    <script>
        $(function () {

            $('.i-checks').iCheck({
                checkboxClass: 'icheckbox_square-green',
                radioClass: 'iradio_square-green',
            });
        });

    </script>
@endsection
