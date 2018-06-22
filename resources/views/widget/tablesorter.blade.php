{{-- http://tablesorter.com/docs/ --}}
@push('css')

<link href="{{ asset('css/plugins/tablesorter/themes/blue/style.css') }}" rel="stylesheet">

@endpush

@push('scripts')
<script src="{{ asset('js/plugins/tablesorter/jquery.metadata.js') }}"></script>
<script src="{{ asset('js/plugins/tablesorter/jquery.tablesorter.min.js') }}"></script>
<script>
    $(function() {
        $(".tablesorter").tablesorter({
            type: "numeric" //按数值排序
        });
    });
</script>

@endpush