<div class="row m-b-md">

    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}


    <div class="form-group">
        {!! Form::select("select_tag_group_id", \App\Models\Material\Groups::all()->pluck('group_name','group_id'), Request::get('select_tag_group_id'),
        [
        'class' => 'form-control',
        'placeholder' => trans('app.标签分组'),
        ]) !!}
    </div>


    <div class="form-group">
        {!! Form::select("select_tag_id", [], '',
        [
        'class' => 'form-control',
        'placeholder' => trans('app.选择标签'),
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
        {!! Form::text('select_unit_id', Request::get('select_unit_id') ,[
        'class' => 'form-control',
        'placeholder' => trans('app.输入素材ID'),
        ])!!}
    </div>

    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>

@push('scripts')
<script>
    $(function () {
        var group_id = $("select[name='select_tag_group_id']").val();
        loadTag(group_id)
    })
    $("select[name='select_tag_group_id']").change(function(){
        loadTag(this.value)
    });
    
    function loadTag(group_id) {
        var tags = {!! $scope->getImageTag() !!};
        var selectPosition = '{!! $scope->tag_id ?? '' !!}';
        html = "<option value=''>{{trans('app.选择标签')}}</option>";
        if (group_id =='') $("select[name='select_tag_id']").html(html);
        if (tags[group_id] == undefined) return false;

        for (var i in tags[group_id].get_tags){
            if (selectPosition == tags[group_id].get_tags[i].tag_id) {
                html += '<option selected="selected" value='+ tags[group_id].get_tags[i].tag_id +'>'+ tags[group_id].get_tags[i].tag_name +'</option>';
            }else{
                html += '<option value='+ tags[group_id].get_tags[i].tag_id +'>'+ tags[group_id].get_tags[i].tag_name +'</option>';
            }
        }
        $("select[name='select_tag_id']").html(html);
    }
</script>
@endpush
