<div class="row m-b-md">
    <div class="col-xs-10">

        <div class="row">
            {!! Form::open(['class' => 'form-horizontal', 'id' => 'scope-form', 'method' => 'get', 'url' => Route::getCurrentRequest()->path()]) !!}

            @if(isset($scope->block))
                @include($scope->block)
            @endif

            <div class="input-group date col-xs-1 m-l">
                <input type="submit" class="btn btn-primary m-l-md btn-submit" value="{{ trans('app.提交') }}">
            </div>

            {!! Form::close() !!}
        </div>

    </div>
</div>
