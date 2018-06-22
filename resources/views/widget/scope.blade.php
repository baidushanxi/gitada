@include('widget.daterangepicker')
@include('widget.datepicker')
@include('widget.scopejs', compact('scope'))

<div class="row m-b-md">
    <div class="col-xs-10">

        <div class="form-inline" id="scope-area">
            @if(isset($scope->block))
                @include($scope->block)
            @endif

            @if($scope->displayProjects)
                <div class="col-xs-2 row">
                @include('widget.select-multiple-bootstrap', ['name' => 'scope[projectIds]', 'lists' => $scope->userProjects->pluck('name' , 'project_id'), 'selected' => $scope->projectIds, 'select_tip'=>trans('app.选择项目')])
            </div>
             @endif

            @if(isset($scope->displayDates) ? $scope->displayDates : false)
                <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="date-range" class="form-control" style="width: 230px;">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @elseif(isset($scope->displayMonth) ? $scope->displayMonth : false)
                    <div class="input-group">
                        <span class="input-group-addon" ><i class="fa fa-calendar"></i></span>
                        <input type="text" class=" form-control col-xs-3 date_month"  name="scope[startMonth]" value="{{ $scope->startMonth }}"  placeholder="{{ trans('app.开始时间') }}"/>
                        <div class="input-group-addon" >To</div>
                        <input type="text"  class=" form-control col-xs-2 date_month" name="scope[endMonth]" value="{{ $scope->endMonth }}" placeholder="{{ trans('app.结束时间') }}"/>
                    </div>
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                @else

                <div class="input-group col-xs-1 m-l">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @endif
        </div>


    </div>
    <div class="form-group">
        <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#scope-modal">
            {{ trans('app.筛选') }}
        </button>
    </div>
</div>

@include('widget.game')


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

<div class="modal inmodal fade" id="scope-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span
                            class="sr-only">Close</span></button>
                <h5 class="modal-title">{{ trans('app.筛选') }}</h5>
                <small>{{ trans('app.在选择项目后才有APP列表，需要筛选APP请点击 「选择APP」按钮。') }}</small>
            </div>

            {!! Form::open(['class' => 'form-horizontal', 'id' => 'scope-form', 'method' => 'get', 'url' => Route::getCurrentRequest()->path()]) !!}
            @if(isset($scope->displayDates) ? $scope->displayDates : false)
            {!! Form::hidden('scope[startDate]', $scope->startDate, ['id' => 'scope-start-date']) !!}
            {!! Form::hidden('scope[endDate]', $scope->endDate, ['id' => 'scope-end-date']) !!}
            @endif

            @if(!empty(Request::get('type')))
                {!! Form::hidden('type',Request::get('type')) !!}
            @endif

            @include('widget.scopemodalbody', compact('scope'))

            <div class="modal-footer">

                {!! Form::button(trans('app.取消'), ['class' => 'btn btn-white', 'data-dismiss' => 'modal']) !!}
                {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary btn-submit']) !!}

            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>