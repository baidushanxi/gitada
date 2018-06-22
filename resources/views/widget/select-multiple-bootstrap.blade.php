@push('css')
<link href="{{ asset('css/plugins/bootstrap-multiselect/bootstrap-multiselect.css') }}" rel="stylesheet">
@endpush
@push('scripts')

<script src="{{ asset('js/plugins/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
@include('widget.select2')
<script type="text/javascript">
    $(document).ready(function() {
        $('.select_multiselect').multiselect({
            allSelectedText: '{!! trans('app.已全选') !!}',
            nonSelectedText: '{!! $select_tip ?? trans('app.请选择') !!}',
            buttonWidth: '180px',
        });
    });
</script>
@endpush
<select class="select_multiselect" multiple="multiple">
    @foreach($lists as $key => $value)
        <option value="{{ $key }}" @if (in_array($key, $selected)) selected @endif >
            {{ $value }}
        </option>
    @endforeach
</select>


