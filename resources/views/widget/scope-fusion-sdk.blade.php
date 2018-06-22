@include('widget.daterangepicker')
@include('widget.datepicker')

<div class="row m-b-md">
    <div class="col-xs-10">
        {!! Form::open(['class' => 'form-horizontal', 'id' => 'scope-form', 'method' => 'get', 'url' => Route::getCurrentRequest()->path()]) !!}
        @if(isset($scope->displayDates) ? $scope->displayDates : false)
            {!! Form::hidden('scope[startDate]', $scope->startDate, ['id' => 'scope-start-date']) !!}
            {!! Form::hidden('scope[endDate]', $scope->endDate, ['id' => 'scope-end-date']) !!}
        @endif
        {!! Form::close() !!}
        <div class="form-inline" id="scope-area">
            @if(isset($scope->block))
                @include($scope->block)
            @endif

            @if(isset($scope->displayDates) ? $scope->displayDates : false)
                <div class="input-group col-xs-5 m-l">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="date-range" class="form-control" style="width: 230px;">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @elseif(isset($scope->displayMonth) ? $scope->displayMonth : false)
                <div class="list-inline">
                    <span class="form-control col-xs-2" style="width: 25px"><i class="fa fa-calendar"></i></span>
                    <input type="text" class=" form-control col-xs-3 date_month" style="width: 120px;"
                           name="scope[startMonth]" value="{{ $scope->startMonth }}"
                           placeholder="{{ trans('app.开始时间') }}"/>
                    <div class="form-control col-xs-2" style="width: 45px;">To</div>
                    <input type="text" class=" form-control col-xs-2 date_month" style="width: 150px;"
                           name="scope[endMonth]" value="{{ $scope->endMonth }}" placeholder="{{ trans('app.结束时间') }}"/>
                </div>
                <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
            @else

                <div class="input-group col-xs-1 m-l">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @endif
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
