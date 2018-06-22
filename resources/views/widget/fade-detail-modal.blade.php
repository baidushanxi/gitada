<div class="modal inmodal fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="width: 1500px; height: 650px; position: relative;left: -250px;">
            <div class="modal-body">
                <div class="ibox-title">
                    <div id="title"><h5>{{ $title ?? trans('app.明细报表') }}</h5></div>
                </div>
                @if(!empty($showChart))

                <div class="row">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins"  style="width: 1000px;">

                            <div class="ibox-content">
                                <div id="detail-container" style="width: 800px; height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="row" style="height:500px;overflow: auto">
                    <div class="col-lg-12">
                        <div class="ibox float-e-margins">
                            <div class="ibox-content" style="">
                                <div class="table-responsive">
                                    <table class="table table-striped" @if(!empty($table_style)) {!! 'style=' . $table_style !!} @endif>
                                        <thead>
                                        @foreach($detailHeader as $h)
                                            <th>{{ $h }}</th>
                                        @endforeach
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-white" data-dismiss="modal" style="position: absolute;top: 0;right: 0;">{{ trans('app.关闭') }}</button>
            </div>
        </div>
    </div>
</div>