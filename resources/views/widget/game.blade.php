@if( !empty($scope->projects) || !empty($scope->adChannels))
<div class="alert alert-info">
    @if( !empty($scope->projects))
    <p><label>{{ trans('app.项目') }}：</label> @foreach($scope->projects as $pl) {{ $pl->name }} @endforeach</p>
    @endif

    @if( !empty($scope->apps))
        <p><label>APP：</label> @foreach($scope->apps as $pl) {{ $pl->name }} @endforeach</p>
    @endif

    @if( !empty($scope->adChannels))
        <p><label>{{ trans('app.广告渠道') }}：</label> @foreach($scope->adChannels as $pl) {{ $pl->channel_alias }} @endforeach</p>
    @endif
</div>
@endif