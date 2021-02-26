@extends('layouts.app')

@section('header')
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>
                        新增打印机
                        <small class="text-danger">[*]</small>
                        <small> 为必填项</small>
                    </h5>
                </div>
                <div class="ibox-content">

                    <div class="alert alert-danger alert-dismissable text-center {{ $errors->first('error') ? '' : 'collapse'}}">
                        <span><strong>{{ $errors->first('error') }}</strong></span>
                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                    </div>

                    <form method="post" class="form-horizontal" action="{{ route('printer.store') }}" id="form">

                        {{ csrf_field() }}
                        <input type="hidden" name="pre_url" value="{{url()->previous()}}">

                        <div class="form-group m-b {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">打印机名称<span class="text-danger"></span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="name" placeholder="打印机名称" value="{{ old('name') }}" maxlength="32">
                                <small class="help-block m-b-none text-muted">请输入打印机名称,用于区分打印机</small>
                            </div>
                            @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group m-b {{ $errors->has('machine_code') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">打印机终端号<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="machine_code" placeholder="打印机终端号" value="{{ old('machine_code') }}" maxlength="255">
                                <small class="help-block m-b-none text-muted">易联云打印机终端号</small>
                            </div>
                            @if ($errors->has('machine_code'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('machine_code') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group m-b {{ $errors->has('m_sign') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">打印机终端密钥<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="m_sign" placeholder="打印机终端密钥" value="{{ old('m_sign') }}" maxlength="255">
                                <small class="help-block m-b-none text-muted">易联云打印机终端密钥</small>
                            </div>
                            @if ($errors->has('m_sign'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('m_sign') }}</strong>
                                </span>
                            @endif
                        </div>

                        <div class="form-group m-b {{ $errors->has('status') ? 'has-error' : '' }}">
                            <label class="col-sm-2 control-label text-right">启用状态<span class="text-danger">[*]</span></label>
                            <div class="col-sm-4">
                                @foreach(\App\Models\Printer::$status as $k => $v)
                                    <label class="i-checks checkbox-inline">
                                        <input type="radio" value="{{ $k }}" name="status" class="i-checks checkbox-inline checkbox" @if(old('status') == $k) checked @endif> {{$v['text']}}
                                    </label>
                                @endforeach
                                <small class="help-block m-b-none text-muted">是否启用打印机,当前模式暂不支持多台打印机同时启用</small>
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
