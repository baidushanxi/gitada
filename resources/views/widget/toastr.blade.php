{{-- https://select2.github.io/examples.html --}}
@push('css')

<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

@endpush

@push('scripts')

<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function () {
            toastr.options = {
                closeButton: true,
                progressBar: true,
                showMethod: 'slideDown',
                timeOut: 4000
            };
            toastr.{!! $tip_type ?? 'success' !!}('{!! $msg ?? trans('app.提示信息') !!}');
        }, 1300);
    });
</script>

@endpush