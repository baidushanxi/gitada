<div class="row m-b-md">
    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}
    <div class="form-group">
        @include('widget.select-single', ['lists' => $scope->deliveryAccounts, 'name' => 'delivery_account_id', 'selected' => $scope->accountId])
    </div>

    <div class="form-group">
        @include('widget.select-single', ['lists' =>  ([''=>trans('app.请选择状态')] +  collect($searchArray)->flip()->toArray()), 'name' => 'select_status', 'selected' => $scope->status])
    </div>

    <div class="form-group">
        @include('widget.select-single', ['lists' =>[''=>'选择数据时间段', '1'=>'当日数据','2'=>'累计数据'], 'name' => 'select_filter', 'selected' => $scope->filter])
    </div>

    <div class="form-group">
        {!! Form::text('name', Request::get('name') ,[
        'class' => 'form-control',
        'placeholder' => trans('app.名称'),
        ])!!}
    </div>


    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>