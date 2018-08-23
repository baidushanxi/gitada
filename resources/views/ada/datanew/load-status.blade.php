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
                    <div class="form-group>
                        @if(!empty($status))
                            <label for="message" class="col-sm-2 control-label">导入状态:{{ \App\Models\Schedule::$status[$status->status] }}: 上次执行时间：{{ $status->op_time }}</label>
                    <div class="hr-line-dashed"></div>

                    <div class="form-group">
                        <textarea class="form-control"  name="message" cols="100" rows="10" id="intro">{{ $status->message }}</textarea>
                    </div>
                    @else
                        <div class="form-group">
                        还未开始...
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection
