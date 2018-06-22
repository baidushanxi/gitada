<div class="row m-b-md">

    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}
    @if($scope->displayDates)
        <div class="input-group date">
            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
            <input type="text" id="date-range" class="form-control" style="width: 230px;">
            {!! Form::hidden('scope[startDate]', $scope->startDate, ['id' => 'scope-start-date']) !!}
            {!! Form::hidden('scope[endDate]', $scope->endDate, ['id' => 'scope-end-date']) !!}
        </div>
    @endif

    <div class="form-group">
        @include('widget.select-single', ['lists' => $scope->deliveryAccounts, 'name' => 'delivery_account_id', 'selected' => $scope->accountId])
    </div>

    @if(isset($scope->block))
        @include($scope->block)
    @endif

    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>

@include('widget.daterangepicker')

@push('scripts')
<script>

</script>
@endpush