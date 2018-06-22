{{-- https://select2.github.io/examples.html --}}
@push('css')

<link href="{{ asset('css/plugins/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/select2/select2-bootstrap.min.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/plugins/select2/select2.full.min.js') }}"></script>
<script>
    $(function() {
        $.fn.select2.defaults.set("theme", "bootstrap");
    });
</script>

@endpush