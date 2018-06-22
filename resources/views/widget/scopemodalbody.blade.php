<div class="modal-body">

    @if($scope->displayProjects)
    <div class="form-group scope-projects">
        <label class="col-sm-2 control-label">
            <div class="row">
                <div class="col-sm-12 m-b-sm">
                    <input type="button" class="btn btn-primary btn-xs btn-outline active" aria-pressed="true" value="{{ trans('app.选择项目') }}">
                </div>
                <div class="col-sm-12">
                    {!! Form::button('全选', ['class' => 'btn btn-success btn-xs select-all']) !!}
                    {!! Form::button('不选', ['class' => 'btn btn-success btn-xs select-none']) !!}
                </div>
            </div>
        </label>
        <div class="col-sm-10">
            <div class="row">
                @foreach($scope->userProjects as $p)
                <label class="col-sm-3" style="font-weight: normal;"> <input type="checkbox" value="{{ $p->project_id }}" @if(in_array($p->project_id, $scope->projectIds )) checked @endif name="scope[projectIds][]"> {{ $p->name }} </label>
                @endforeach
            </div>
        </div>
    </div>

    <div class="hr-line-dashed"></div>

    @endif

    @if($scope->displayApps)
    <div class="form-group scope-apps">
        <label class="col-sm-2 control-label">
            <div class="row">
                <div class="col-sm-12 m-b-sm">
                    <input type="button" class="btn btn-primary btn-xs btn-outline btn-apps" aria-pressed="true" data-toggle="button" value="{{ trans('app.选择APP') }}">
                </div>
                <div class="col-sm-12 btn-select" style="display: none;">
                    {!! Form::button('全选', ['class' => 'btn btn-success btn-xs select-all']) !!}
                    {!! Form::button('不选', ['class' => 'btn btn-success btn-xs select-none']) !!}
                </div>
                <div class="col-sm-12" id="app_list_os" style="padding-left: 0;padding-right: 0">
                    <button type="button" style="margin-top: 5px;" class="btn btn-xs btn-white app-os" data-os={!! \App\Models\AppInfo::TYPE_AND !!}><i class="fa fa-android"></i>{!! \App\Models\AppInfo::$typeList[\App\Models\AppInfo::TYPE_AND] !!}</button>
                    <button type="button" style="margin-top: 5px;" class="btn btn-xs btn-white app-os" data-os={!! \App\Models\AppInfo::TYPE_IOS !!}><i class="fa fa-apple"></i>{!! \App\Models\AppInfo::$typeList[\App\Models\AppInfo::TYPE_IOS] !!}</button>
                </div>
            </div>
        </label>

        <div class="col-sm-10">
            <div class="row" style="display: none;">
            </div>
        </div>
    </div>

    <div class="hr-line-dashed"></div>
    @endif

    @if($scope->displayAdChannels)
    <div class="form-group scope-ad_channel">
        <label class="col-sm-2 control-label">
            <div class="row">
                <div class="col-sm-12 m-b-sm">
                    <input type="button" class="btn btn-primary btn-xs btn-outline active btn-ad_channel" aria-pressed="true" data-toggle="button" value="{{ trans('app.选择广告渠道') }}">
                </div>
                <div class="col-sm-12 btn-select">
                    {!! Form::button('全选', ['class' => 'btn btn-success btn-xs select-all']) !!}
                    {!! Form::button('不选', ['class' => 'btn btn-success btn-xs select-none']) !!}
                </div>
            </div>
        </label>
        <div class="col-sm-10">
            <div class="row">
                @foreach($scope->userAdChannels as $channel)
                <label class="col-sm-3" style="font-weight: normal;"> <input type="checkbox" value="{{ $channel->channel_id }}" @if(in_array($channel->channel_id, $scope->adChannelIds )) checked @endif name="scope[adChannelIds][]"> {{ $channel->channel_alias }} </label>
                @endforeach
            </div>
        </div>
    </div>
    @endif


</div>
