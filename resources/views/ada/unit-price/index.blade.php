@extends('layouts.side-nav')

@section('title', $title)

@section('content')

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
                                <th>商品名称</th>
                                <th>商品标识</th>
                                <th>资材单价</th>
                                <th>制料单价</th>
                                <th>生产单价</th>
                                <th>管理单价</th>
                            </tr>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{ $v['productName'] }}</td>
                                    <td>{{ $v['productId'] }}</td>
                                    <td>{{ (float) $v['material'] ?? '' }}</td>
                                    <td>{{ (float) $v['make'] ?? ''}}</td>
                                    <td>{{ (float) $v['produce'] ?? '' }}</td>
                                    <td>{{ (float) $v['manage'] ?? '' }}</td>
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



