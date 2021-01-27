@if ($paginator->hasPages())
    <ul class="pagination  no-margin pull-right">
        {{-- 首页 --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span>首页</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->url(1) . '&limit=' . $paginator->perPage() }}">首页</a>
            </li>
        @endif

        {{-- 上一页 --}}
        @if ($paginator->onFirstPage())
            <li class="disabled">
                <span>上一页</span>
            </li>
        @else
            <li>
                <a href="{{ $paginator->previousPageUrl() . '&limit=' . $paginator->perPage() }}">上一页</a>
            </li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
        <!-- "Three Dots" Separator -->
            @if (is_string($element))
                <li class="disabled"><span>{{ $element }}</span></li>
            @endif

        <!-- Array Of Links -->
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="active"><span>{{ $page }}</span></li>
                    @else
                        <li><a href="{{ $url . '&limit=' . $paginator->perPage() }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- 下一页 --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->nextPageUrl() . '&limit=' . $paginator->perPage() }}">下一页</a>
            </li>
        @else
            <li class="disabled">
                <span>下一页</span>
            </li>
        @endif

        {{-- 尾页 --}}
        @if ($paginator->hasMorePages())
            <li>
                <a href="{{ $paginator->url($paginator->lastPage()) . '&limit=' . $paginator->perPage() }}">尾页</a>
            </li>
        @else
            <li class="disabled">
                <span>尾页</span>
            </li>
        @endif
        <li>
        <span data-toggle="tooltip" data-placement="bottom" title="输入页码，按回车快速跳转">
            第 <input type="text" onkeydown="keyup_submit(event)" class="text-center no-padding" value="{{ $paginator->currentPage() }}" id="customPage" data-total-page="{{ $paginator->lastPage() }}" style="width: 50px; height: 18px; outline: none"> 页 / 共 {{ $paginator->lastPage() }} 页 / 每页 {{ $paginator->perPage() }} 条 / 总计: {{ $paginator->total() }}
        </span>
        </li>
    </ul>
    <ul class="clearfix"></ul>

    <script>
        function keyup_submit(e){

            var evt = window.event || e;
            url = window.location.href;
            var arr = url.split("?");
            if (arr[1] === undefined) {

                if (evt.keyCode == 13) {
                    window.location.href = arr[0] + '?page=' + $('#customPage').val();
                }
            } else {

                var pageIndex = arr[1].indexOf('page');

                if (pageIndex == -1) {
                    window.location.href = arr[0] + '?' + arr[1] + '&page=' + $('#customPage').val();
                } else {

                    var andIndex = arr[1].indexOf('&', pageIndex);

                    //page是否为最后一个参数
                    if(andIndex == -1) {
                        var back = '';
                    } else {
                        var back = arr[1].slice(andIndex);
                    }

                    //page是否为第一个参数
                    if (pageIndex === 0) {

                        var front = '';
                    } else {

                        var front = arr[1].slice(0, pageIndex - 1);
                    }

                    // 监听回车，page之前参数+page之后参数+page输入的值
                    if (evt.keyCode == 13){
                        window.location.href = arr[0] + '?' + front + back + '&page=' + $('#customPage').val();
                    }
                    console.log('str:' + arr[1]);
                    console.log('pageIndex:' + pageIndex);
                    console.log('andIndex:' + andIndex);
                    console.log('front:' + front);
                    console.log('back:' + back);
                    console.log(front + back);
                }
            }
            {{--var uri = {!! Request::getRequestUri()!!}--}}
            {{--    console.log(uri);--}}
            {{--var evt = window.event || e;--}}
            {{--if (evt.keyCode == 13){--}}
            {{--    window.location.href='/your/pages?page=' + $('#customPage').val();--}}
            {{--}--}}
        }
    </script>
@endif
