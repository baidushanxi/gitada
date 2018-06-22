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
                                <th>店铺名称</th>
                                <th>平台</th>
                                <th>人工分摊</th>
                                <th>公共分摊</th>
                                <th>编辑</th>
                            </tr>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $v)
                                <tr>
                                    <td>{{ $v->shopName }}</td>
                                    <td>{{ \App\Models\AdaShop::$platform[$v->platform] ?? '' }}</td>
                                    <td>{{ (float) ($v->artificial) .'%' }}</td>
                                    <td>{{ (float) ($v->public) .'%' }}</td>
                                    <td>{!!  BaseHtml::tooltip(trans('app.设置'), route('ada.shop.edit', ['id' => $v->id])) !!}
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



