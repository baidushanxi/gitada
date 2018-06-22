<div class="row m-b-md">
    <div class="col-xs-10">

        <div class="row" id="scope-area">
        {!! Form::open(['class' => 'form-horizontal', 'id' => 'scope-form', 'method' => 'get', 'url' => Route::getCurrentRequest()->path()]) !!}

            <div class="col-xs-2">
                <input type="text" name="scope[position_name]" value="{{ $scope->positionName }}" class="form-control col-xs-6"   placeholder="{{ trans('app.广告位名称') }}">
            </div>

            <div class="col-xs-2">
                @include('widget.select-single', ['name' => 'scope[ad_channel_id]', 'lists' => [0 => trans('app.广告渠道')] + \App\Models\Ad\Channel::all()->pluck('channel_alias','channel_id')->toArray(), 'selected' => $scope->adChannelId])
            </div>


            <div class="input-group date col-xs-1 m-l">
                <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>


@push('scripts')

<script>
    $('.btn-submit').click(function () {
        // 设置 内容到scope-form 表单去
        $('#scope-area').find("*[name*='scope']").each(function () {
            var name = $(this).attr('name');
            $('#scope-form').find("input[name='" + name + "']").remove();
            var html = '<input name="' + name + '" value="' + $(this).val() + '" type="hidden">';
            $('#scope-form').prepend(html)
        })

        $('#scope-form').submit();
    });
</script>

@endpush