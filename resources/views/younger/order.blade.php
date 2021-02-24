@extends('layouts.app')

@section('header')

@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">

        <div class="ibox float-e-margins">
            <div class="ibox-content">
                <form action="{{route('order.detail', $date)}}" method="get" id="form">
                    <div class="row">
                        <div class="col-md-2 m-b">
                            <select class="form-control input-sm select2-input select2" name="building">
                                <option value=""> 楼号</option>
                                @foreach($buildings as $building)
                                    <option @if(request('building') == $building->building) selected
                                            @endif value="{{ $building->building }}">
                                        {{ $building->building }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 m-b">
                            <select class="form-control input-sm select2-input select2" name="floor">
                                <option value=""> 楼层</option>
                                @foreach($floors as $floor)
                                    <option @if(request('floor') == $floor->floor) selected
                                            @endif value="{{ $floor->floor }}">
                                        {{ $floor->floor }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 m-b">
                            <select class="form-control input-sm select2-input select2" name="room">
                                <option value=""> 科室</option>
                                @foreach($rooms as $room)
                                    <option @if(request('room') == $room->room) selected
                                            @endif value="{{ $room->room }}">
                                        {{ $room->room }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 m-b">
                            <select class="form-control input-sm select2-input select2" name="sort">
                                <option value=""> 排序(默认时间倒序)</option>
                                <option value="floor" @if(request('sort') == 'floor') selected @endif>楼层正序</option>
                                <option value="id" @if(request('sort') == 'id') selected @endif>时间正序</option>

                            </select>
                        </div>

                        <div class="col-sm-2 m-b">
                            <span class="btn-group">
                            <button type="submit" class="btn btn-sm btn-primary">
                                搜索
                            </button>
                            <button type="submit" formaction="{{ route('order.download',$date) }}"
                                    id="export_excel" class="btn btn-sm btn-success">
                                                导出
                                            </button>
                            </span>
                        </div>
                        <div class="col-sm-2 m-b">
                            <a class="btn btn-sm btn-info" href="{{route('order.index')}}"> 返回首页</a>
                        </div>
                    </div>

                </form>


                <div class="table-responsive">
                    <table class="table table-hover text-nowrap table-bordered">
                        <thead>
                        <tr>
                            <th class="text-middle">订单号</th>
                            <th class="text-middle">应付</th>
                            <th class="text-middle">楼号</th>
                            <th class="text-middle">楼层</th>
                            <th class="text-middle">科室</th>
                            <th class="text-middle">姓名</th>
                            <th class="text-middle">电话</th>
                            <th class="text-middle">套餐</th>
                            <th class="text-middle">盖浇饭</th>
                            <th class="text-middle">汤煲</th>
                            <th class="text-middle">加饭</th>
                            <th class="text-middle">备注</th>
                            <th class="text-middle">下单时间</th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach($rows as $row)
                            <tr>
                                <td class="text-middle">{{$row->serial_number}}</td>
                                <td class="text-middle">{{$row->total_price}}</td>
                                <td class="text-middle">{{$row->building}}</td>
                                <td class="text-middle">{{$row->floor}}</td>
                                <td class="text-middle">{{$row->room}}</td>
                                <td class="text-middle">{{$row->contact_person}}</td>
                                <td class="text-middle">{{$row->phone}}</td>
                                <td class="text-middle">{{$row->set_meal}}</td>
                                <td class="text-middle">{{$row->rice_bowl}}</td>
                                <td class="text-middle">{{$row->soup_pot}}</td>
                                <td class="text-middle">{{$row->extra_meal}}</td>
                                <td class="text-middle">{{$row->remark}}</td>
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