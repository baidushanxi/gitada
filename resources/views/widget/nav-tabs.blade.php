<div class="row">
    <div class="col-lg-12">
        <div class="panel blank-panel">

            <div class="panel-heading">
                <div class="panel-options">

                    <ul class="nav nav-tabs">

                        @foreach($tabs as $k => $v)
                        <li @if($k == $scope->type ?? $type) class="active" @endif><a href="{!! $v['url'] !!}">{{ $v['text'] }}</a></li>
                        @endforeach
                    </ul>

                </div>
            </div>

        </div>
    </div>
</div>
