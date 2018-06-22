<select class="js-select2-single form-control" name="{{ $name }}"  style="{{ $style ?? '' }}" >
    @foreach($lists as $key => $value)
        <option value="{{ $key }}" @if ($key == $selected) selected @endif >
            {{ $value }}
        </option>
    @endforeach
</select>

@push('scripts')
@include('widget.select2')
<script>
    $(function () {
        $(".js-select2-single").select2();
        //避免在BootStrap的modal中使用Select2搜索框无法输入
        $.fn.modal.Constructor.prototype.enforceFocus = function () {};
    });
</script>
@endpush