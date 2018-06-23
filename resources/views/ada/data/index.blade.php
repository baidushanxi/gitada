@extends('layouts.side-nav')

@section('title', $title)

@section('content')

    @if(!empty($message))
        <div id="flash-overlay-modal" class="row">
            <div class="col-lg-12">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>{!! $message !!}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @include('widget.scope.date', ['scope' => $scope])
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $title }}表格</h5>
                    <div class="ibox-tools">
                        <a class="btn btn-xs btn-primary" target="_blank" href="{!! route('ada.data.export', Request::all()) !!}">
                            <i class="fa fa-download"></i> 导出EXCEL
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped tooltip-demo tablesorter">
                            <thead>
                            <tr class="font-bold">
                                <th>店铺</th>

                                <th>价税合计(本)</th>
                                <th>销售成本(本)</th>
                                <th>资材费用</th>
                                <th>制料费用</th>
                                <th>生产费用</th>
                                <th>管理费用</th>
                                <th>推广费用</th>
                                <th>包裹数量</th>
                                <th>快递费用1</th>
                                <th>快递费用2</th>
                                <th>人工分摊</th>
                                <th>公共分摊</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach($data as $key => $v)
                             <tr>
                                 <td>{{ $v['shopName'] }}</td>
                                 <td>{{ round(($v['amount']),2)  }}</td>
                                 <td>{{ round(($v['cost']),2)  }}</td>
                                 <td>{{ round(($v['materialSum']),2) }}</td>
                                 <td>{{ round(($v['makeSum']),2) }}</td>
                                 <td>{{ round(($v['produceSum']),2) }}</td>
                                 <td>{{ round(($v['manageSum']),2) }}</td>
                                 <td>{{ $v['deliver'] }}</td>
                                 <td>{{ $v['deliverSum0'] }}</td>
                                 <td>{{ $v['deliverSum'] }}</td>
                                 <td>{{ round(($v['spread']),2) }}</td>
                                 <td>{{ round(($shops[$key]->artificial * $v['amount'] /100),2) }}</td>
                                 <td>{{ round(($shops[$key]->public * $v['amount'] /100),2) }}</td>
                             </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>

    </div>

@endsection

@include('widget.tablesorter')


