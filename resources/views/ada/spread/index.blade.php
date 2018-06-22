@extends('layouts.side-nav')

@section('title', $title)

@section('page-head')

    @parent

    <div class="col-sm-8">
        <div class="title-action">
            <a href="{{ route('ada.spread.create') }}" class="btn btn-primary btn-sm">添加推广费用</a>
        </div>
    </div>

@endsection

@section('content')

    @include('flash::message')

    @include('widget.scope.date', ['scope' => $scope])
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $title }}</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped tooltip-demo tablesorter">
                            <thead>
                            <tr>
                                <th>时间</th>
                                <th>店铺名称</th>
                                <th>网销宝</th>
                                <th>营销通</th>
                                <th>诚信通</th>
                                <th>直通车充值</th>
                                <th>钻展充值</th>

                                <th>京东快车</th>
                                <th>京挑客服务费</th>

                                <th>淘客服务费</th>
                                <th>刷单佣金</th>
                                <th>软件费</th>
                                <th>其他推广费</th>
                            </tr>
                            <tr>
                                <td>总计</td>
                                <td>{{ $sum['all'] ?? 0 }}</td>
                                <td>{{ $sum['wxb'] ?? 0 }}</td>
                                <td>{{ $sum['yxt'] ?? 0 }}</td>
                                <td>{{ $sum['cxt'] ?? 0 }}</td>
                                <td>{{ $sum['ztc'] ?? 0 }}</td>
                                <td>{{ $sum['zhzh'] ?? 0 }}</td>
                                <td>{{ $sum['jdkc'] ?? 0 }}</td>
                                <td>{{ $sum['jtk'] ?? 0 }}</td>
                                <td>{{ $sum['taobaofuwu'] ?? 0 }}</td>
                                <td>{{ $sum['shuadan'] ?? 0 }}</td>
                                <td>{{ $sum['rjf'] ?? 0 }}</td>
                                <td>{{ $sum['qita'] ?? 0 }}</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{ $v->date }}</td>
                                    <td>{{ $shops[$v->shopId] ?? '' }}</td>
                                    <td>{{ (float) $v->wxb }}</td>
                                    <td>{{ (float) $v->yxt }}</td>
                                    <td>{{ (float) $v->cxt }}</td>
                                    <td>{{ (float) $v->ztc }}</td>
                                    <td>{{ (float) $v->zhzh }}</td>
                                    <td>{{ (float) $v->jdkc }}</td>
                                    <td>{{ (float) $v->jtk }}</td>
                                    <td>{{ (float) $v->taobaofuwu }}</td>
                                    <td>{{ (float) $v->shuadan }}</td>
                                    <td>{{ (float) $v->rjf }}</td>
                                    <td>{{ (float) $v->qita }}</td>
                                </td>
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



