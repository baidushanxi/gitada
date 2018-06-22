@push('css')

<link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.tableTools.min.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/plugins/dataTables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.responsive.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.tableTools.min.js') }}"></script>


<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

<script>
    var hiddenButton =  {!! $button['hiddenColumn'] !!};
    $(document).ready(function() {
        var table = $('#tableData').DataTable( {
            "paging": false,
            "bInfo": false,
            "searching":false,
            "ordering": false,
            "columnDefs": [
                { "visible": false, "targets": hiddenButton}
            ]
        } );
        //显示隐藏列
        $('.toggle-vis').on('change', function (e) {
            if ($('.tablesorter')){
                $("table").tablesorter();
            }
            e.preventDefault();
            var column = table.column($(this).attr('data-column'));
            column.visible(!column.visible());
        });
    } );
</script>

@endpush