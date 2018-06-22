{{--  --}}
@push('css')
<link href="{{ asset('css/plugins/switchery/switchery.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('js/plugins/switchery/switchery.js') }}"></script>
<script>
    // switchery 对象数组，方便外部模块操作 传入 $row 表示一共几列
    // eg : 第一列第一个用 switcherys[0][0].element 来获取
    var switcherys = [];
    var row = {!! $row ?? 1 !!}
    $(function () {
        var elems = document.querySelectorAll('.js-switch');
        var j = 0;
        for (var i = 0; i < elems.length; i++) {
            var line = Math.floor(i / row);
            if (typeof switcherys[line] == 'undefined') {
                switcherys[line] = []
                j = 0;
            }
            switcherys[line][j] = new Switchery(elems[i], {
                color: '#1AB394'
                , secondaryColor: '#dfdfdf'
                , jackColor: '#fff'
                , jackSecondaryColor: null
                , className: 'switchery'
                , disabled: false
                , disabledOpacity: 0.5
                , speed: '0.1s'
                , size: 'small'
                ,
            });
            j++;
        }
    })
</script>

@endpush