<div class="row m-b-md">

    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}


    <div class="form-group">
        {!! Form::select("select_source_id", \App\Models\Material\Source::all()->pluck('source','id'), Request::get('select_source_id'),
        [
        'class' => 'form-control',
        'placeholder' => trans('app.选择来源'),
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::select("select_creator_id", \App\User::all()->pluck('username','user_id'), Request::get('select_creator_id'),
        [
        'class' => 'form-control',
        'placeholder' => trans('app.选择上传者'),
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::text('select_reference_id', Request::get('select_reference_id') ,[
        'class' => 'form-control',
        'placeholder' => trans('app.输入素材ID'),
        ])!!}
    </div>

    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>
