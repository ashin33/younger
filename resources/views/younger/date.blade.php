@extends('layouts.app')

@section('header')

    <link href="{{ asset('css/datepicker/datepicker3.css') }}" rel="stylesheet">
    <link href="{{ asset('css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet">

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-12">

            <div class="ibox float-e-margins">
                <div class="ibox-content">

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
                                           href="{{ route('order.detail', $row->date) }}">
                                            明细
                                        </a>
                                        <a class="btn-primary btn btn-xs"
                                           href="{{ route('order.download', $row->date) }}">
                                            下载
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

@endsection


@section('footer')

@endsection