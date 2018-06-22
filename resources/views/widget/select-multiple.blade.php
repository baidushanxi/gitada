<select class="js-select2-multiple form-control" name="{{ $name }}[]" style="width: 75%;"   multiple="multiple">
    @foreach($lists as $key => $value)
        <option value="{{ $key }}" @if (in_array($key, $selected)) selected @endif >
            {{ $value }}
        </option>
    @endforeach
</select>

@push('scripts')

@include('widget.select2')
<script>
    $(function () {
        var placeholder = '{{ $placeholder ?? '' }}';
        $(".js-select2-multiple").select2({
            placeholder: placeholder,
            allowClear: true,
        });
    });
</script>
@endpush