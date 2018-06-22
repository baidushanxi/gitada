@push('css')
    <link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/dataTables/dataTables.tableTools.min.css') }}" rel="stylesheet">
    @foreach($plugs ?? [] as $p)
        <link href="{{ asset('css/plugins/dataTables'). '/' . $p . '/' .$p . '.css'}}" rel="stylesheet">
    @endforeach
@endpush

@push('scripts')
    <script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
    <script src="{{ asset('js/plugins/dataTables/dataTables.tableTools.min.js') }}"></script>


    @foreach($plugs ?? [] as $p)
        <script src="{{ asset('js/plugins/dataTables'). '/' . $p . '/' .$p . '.js'}}"></script>
    @endforeach
    <script>
        var defaults = {
            "bLengthChange": false, //改变每页显示数据数量
            "bFilter": false, //过滤功能
            "bSort": true, //排序功能
            "bInfo": false,//页脚信息
            "bPaginate": false,  //启用分页
            language: {
                url: '{{ asset('js/plugins/dataTables/i18n/Chinese.json') }}'
            },
        };

        function aTargets(count) {
            var  aTargets = [], b = 0;
            for (; b < count; b++)
                aTargets.push(b);
            return aTargets;
        }

        function tableData(opt) {
            var table = $('#tableData').DataTable(
                opt
            );
        }
    </script>

@endpush