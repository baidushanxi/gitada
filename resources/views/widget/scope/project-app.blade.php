@include('widget.daterangepicker')
@include('widget.scopejs', compact('scope'))

<div class="row m-b-md">
    <div class="col-xs-10 form-inline">

        <div class="row" id="scope-area">
            @if(isset($scope->block))
                @include($scope->block)
            @endif

            <div class="col-xs-2 row">
                @include('widget.select-multiple-bootstrap', ['name' => 'scope[projectIds]', 'lists' => $scope->userProjects->pluck('name' , 'project_id'), 'selected' => $scope->projectIds, 'select_tip'=>trans('app.选择项目')])
            </div>

            @if($scope->displayDates)
                <div class="input-group date col-xs-5 m-l">
                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                    <input type="text" id="date-range" class="form-control" style="width: 230px;">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @else
                <div class="input-group date col-xs-1 m-l">
                    <input type="button" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
                </div>
            @endif
        </div>

    </div>
    <div class="col-xs-2">
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
            {!! Form::hidden('scope[startDate]', $scope->startDate, ['id' => 'scope-start-date']) !!}
            {!! Form::hidden('scope[endDate]', $scope->endDate, ['id' => 'scope-end-date']) !!}

            @include('widget.scopemodalbody', compact('scope'))

            <div class="modal-footer">

                {!! Form::button(trans('app.取消'), ['class' => 'btn btn-white', 'data-dismiss' => 'modal']) !!}
                {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary btn-submit']) !!}

            </div>

            {!! Form::close() !!}

        </div>
    </div>
</div>