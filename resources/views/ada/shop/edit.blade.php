@extends('layouts.side-nav')

@section('title', $title)

@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $title }}</h5>
                </div>
                <div class="ibox-content">
                    {!! Form::open(['class' => 'form-horizontal', 'enctype' => 'multipart/form-data']) !!}
                    <div class="form-group @if (!empty($errors->first('platform'))) has-error @endif">
                        {!! Form::label('platform', trans('app.平台'), ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            @include('widget.select-single', ['lists' => \App\Models\AdaShop::$platform, 'name' => 'platform', 'selected' => $data->platform ?? old('platform')])
                            <span class="help-block m-b-none">{{ $errors->first('platform') }}</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group @if (!empty($errors->first('shopName'))) has-error @endif">
                        {!! Form::label('shopName', '店铺名称', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5">
                            {!! Form::text('title', $data->shopName ?? old('shopName'), [
                            'class' => 'form-control',
                            'required' => true,
                             'readonly' => 'readonly',
                            ]) !!}
                            <span class="help-block m-b-none">{{ $errors->first('shopName') }}</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group @if (!empty($errors->first('artificial'))) has-error @endif">
                        {!! Form::label('artificial', '人工分摊', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5 input-group m-b">
                            {!! Form::text('artificial', (float) ($data->artificial ?? old('artificial')), [
                            'class' => 'form-control',
                            'required' => true,
                            ]) !!}
                            <span class="input-group-addon">%</span>
                            <span class="help-block m-b-none">{{ $errors->first('artificial') }}</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>

                    <div class="form-group @if (!empty($errors->first('public'))) has-error @endif">
                        {!! Form::label('public', '公共分摊', ['class' => 'col-sm-2 control-label']) !!}
                        <div class="col-sm-5 input-group m-b">
                            {!! Form::text('public', (float) ($data->public ?? old('public')), [
                            'class' => 'form-control',
                            'required' => true,
                            ]) !!}
                            <span class="input-group-addon">%</span>
                            <span class="help-block m-b-none">{{ $errors->first('public') }}</span>
                        </div>
                    </div>

                    <div class="hr-line-dashed"></div>


                    <div class="form-group">
                        <div class="col-sm-4 col-sm-offset-2">
                            {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
                        </div>
                    </div>

                    {!! Form::close() !!}

                </div>
            </div>
        </div>
    </div>

@endsection

@include('widget.select2')
@include('widget.color-picker')

@section('scripts-last')
    <script>

    </script>
@endsection