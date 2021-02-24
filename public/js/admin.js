(function ($) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    });

    $.fn.extend({
        /**
         *  select2 ajax封装
         * @param string url
         * @param obj transfer 转换响应数据 {id:'',text''}
         * @param obj addQuery 增加的查询条件
         * @param obj params select2配置，可覆盖默认配置
         * @param string searchField  查询字段名
         * @param int limit     每页显示数量
         */
        adminSelect2: function (url, transfer, addQuery = {}, params = {}, searchField = 'search', limit = 10) {
            var intiParams = {
                ajax: {
                    url: url,
                    method: 'post',
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        var query = {
                            limit: limit,
                            page: params.page || 1
                        }
                        query[searchField] = params.term;
                        query = $.extend(query, addQuery);
                        return query;
                    },
                    processResults: function (data, params) {
                        // var newData = [{id:0,text:'请选择'}];
                        var newData = $.map(data.data.data, function (obj) {
                            obj.id = obj[(transfer.id)];
                            obj.text = obj[(transfer.text)];
                            return obj;
                        });
                        if(!params.page || params.page === 1){
                            newData.unshift({ id: 0, text: '请选择' });
                        }
                        return {
                            results: newData,
                            pagination: {
                                more: data.data.current_page < data.data.last_page
                            }
                        };
                    },
                    cache: true,
                },
                // minimumInputLength: 2,
                language: "zh-CN",
            };
            params = $.extend(intiParams, params);
            return $(this).select2(params);
        },
    })

})(jQuery)
