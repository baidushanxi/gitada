<div class="row m-b-md">

    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}

    <div class="input-group">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" id="date_time" class="form-control" style="width: 230px;">
        {!! Form::hidden('scope[startDate]', $scope->startDate, ['id' => 'scope-start-date']) !!}
        {!! Form::hidden('scope[endDate]', $scope->endDate, ['id' => 'scope-end-date']) !!}
    </div>


    @if(isset($scope->block))
        @include($scope->block)
    @endif

    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>

@include('widget.daterangepicker')