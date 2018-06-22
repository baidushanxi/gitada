{{-- https://select2.github.io/examples.html --}}
@push('css')


<link href="{{ asset('css/plugins/iCheck/custom.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/plugins/iCheck/icheck.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    });
    
    function icheck() {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
    }
</script>

@endpush