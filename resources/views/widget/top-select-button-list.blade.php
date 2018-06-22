@push('css')

<link href="{{ asset('css/plugins/dataTables/dataTables.bootstrap.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.responsive.css') }}" rel="stylesheet">
<link href="{{ asset('css/plugins/dataTables/dataTables.tableTools.min.css') }}" rel="stylesheet">

@include('widget.icheck')

@endpush
<div style="float:left; position:relative;height:100%;">
    <button type="button" class="showcol btn btn-primary" data-toggle="modal" data-target="#button_list">
        {{ trans('app.显示更多数据维度') }}
    </button>
    <div class="modal inmodal fade" id="button_list" tabindex="-1" role="dialog" aria-hidden="false">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <h4 class="modal-title">{{ trans('app.显示更多数据维度') }}</h4>
                </div>
                <ul style="z-index: 1;background: white" >
                    @foreach($button['button'] as $k=>$v)
                    <li>
                        <input type="checkbox"  class="toggle-vis" data-column="{{$k}}"/> {{$v}}
                    </li>
                    @endforeach
                </ul>
                <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">关闭</button>
                </div>
            </div>
        </div>
    </div>
</div>