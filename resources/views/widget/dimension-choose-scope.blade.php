<div class="form-group scope-area">

    <div class="col-md-12" id="dimension">
        {{ $scope->dimensionName }}
        @foreach($selectArray as $k => $v)
            <button type="button" class="btn btn-sm @if(in_array($k, $selected)) btn-success @else btn-white
            @endif" alias="{{ $v }}" dimension="{{ $k }}">{{ $v }}</button>
        @endforeach
        <input type="hidden" name="scope[dimension]" value="{{ $scope->dimension }}" class="form-control" id="scope-dimensions">
    </div>
</div>

@push('scripts')
<script>
    $(function () {
        var select = 'btn-success';
        var unselect = 'btn-white';
        var btn = $('#dimension').find('.btn');
        btn.click(function () {
            if ($(this).hasClass(select)) {
                $(this).removeClass(select).addClass(unselect);
            } else {
                $(this).removeClass(unselect).addClass(select);
            }
            var dimension = [];
            $('#dimension').find('.btn-success[dimension]').each(function () {
                dimension.push($(this).attr('dimension'));
            });
            $("input[name='scope[dimension]']").val(dimension.join(','));
        });

    });
</script>
@endpush