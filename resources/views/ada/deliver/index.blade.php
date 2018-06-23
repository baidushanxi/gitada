@extends('layouts.side-nav')

@section('title', $title)

@section('page-head')

    @parent

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
                                <th>店铺名称</th>
                                <th>包裹数量</th>
                                <th>快递费用1</th>
                                <th>快递费用2</th>
                            </tr>
                            <tr>
                                <td>总计</td>
                                <td>{{ $sum }}</td>
                                <td>{{ $sum * \App\Models\AdaDeliver::PRICE0 }}</td>
                                <td>{{ $sum * \App\Models\AdaDeliver::PRICE }}</td>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{ $shops[$v->shopId] ?? '' }}</td>
                                    <td>{{ $v->number }}</td>
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



