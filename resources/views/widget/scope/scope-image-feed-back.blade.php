<div class="row m-b-md">

    {!! Form::open(['class' => 'form-inline col-md-12', 'method' => 'get']) !!}


    <div class="form-group">
        {!! Form::select("select_ad_channel_id", \App\Models\Ad\Channel::getList(), Request::get('select_ad_channel_id'),
        [
        'class' => 'form-control',
        'placeholder' => trans('app.广告渠道'),
        ]) !!}
    </div>


    <div class="form-group">
        {!! Form::select("select_ad_position_id", [], '',
        [
        'class' => 'form-control',
        'placeholder' => trans('app.广告位'),
        ]) !!}
    </div>

    <div class="form-group">
        {!! Form::select("select_creator_id", \App\User::all()->pluck('username','user_id'), Request::get('select_creator_id'),
        [
        'class' => 'form-control',
        'placeholder' => trans('app.选择上传者'),
        ]) !!}
    </div>

    {!! Form::submit(trans('app.提交'), ['class' => 'btn btn-primary']) !!}
    {!! Form::close() !!}
</div>

@push('scripts')
<script>
    $(function () {
        var channel_id = $("select[name='select_ad_channel_id']").val();
        loadPosition(channel_id)
    })
    $("select[name='select_ad_channel_id']").change(function(){
        loadPosition(this.value)
    });
    
    function loadPosition(ad_channel_id) {
        var position = {!! $scope->getImagePosition() !!};
        var selectPosition = '{!! $scope->position_id ?? '' !!}';
        html = "<option value=''>{{trans('app.广告位')}}</option>";
        if (ad_channel_id =='') $("select[name='select_ad_position_id']").html(html);
        if (position[ad_channel_id] == undefined) return false;

        for (var i in position[ad_channel_id].get_ad_position){
            if (selectPosition == position[ad_channel_id].get_ad_position[i].id) {
                html += '<option selected="selected" value='+ position[ad_channel_id].get_ad_position[i].id +'>'+position[ad_channel_id].get_ad_position[i].name +'</option>';
            }else{
                html += '<option value='+ position[ad_channel_id].get_ad_position[i].id +'>'+position[ad_channel_id].get_ad_position[i].name +'</option>';
            }
        }
        $("select[name='select_ad_position_id']").html(html);
    }
</script>
@endpush
