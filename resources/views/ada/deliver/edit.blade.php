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

                    <div class="form-group @if (!empty($errors->first('spread_file'))) has-error @endif">
                        <label for="spread" class="col-sm-2 control-label">上传EXCEL</label>
                        <div class="col-sm-5">
                            @include('widget.file-upload', ['file_name'=>'spread_file'])
                        </div>
                        <span class="help-block m-b-none">{{ $errors->first('spread_file') }}</span>
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