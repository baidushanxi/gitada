@extends('layouts.side-nav')

@section('title', $title)

@section('content')

    @include('widget.scope.date', ['scope' => $scope])

    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>{{ $title }}表格</h5>
                </div>
                <div class="ibox-content">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped tooltip-demo tablesorter">
                            <thead>
                            <tr class="font-bold">
                                <th>店铺名称</th>
                                <th>销售额</th>
                                <th>成本</th>
                            </tr>
                            </thead>
                            <tbody>
                             @foreach($data as $key => $v)
                             <tr>
                                 <td>
                                     {!!
                                          BaseHtml::toggleModel( $v->shopName, route('adaDataNew.detail',array_merge(Request::all(),["scope[shopId]" => $v->shopId])),"#detail-modal", trans('app.查看') )
                                     !!}
                                 </td>
                                 <td>{{ round(($v->sales),2)  }}</td>
                                 <td>{{ round(($v->cost),2)  }}</td>
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
@include('widget.fade-detail-modal', ['title'=> '分天报表','showChart'=>false ,'table_style' => 'font-size:14px;','detailHeader' => ['时间','店铺名称','成本','销售额']])
@include('widget.highcharts')

@section('scripts-last')
    <script>
        $('.show-modal').click(function () {
            var m = $('#detail-modal');
            var b = m.find('.modal-body .ibox');
            var url = $(this).data('href');
            $.getJSON(url, function (res) {
                var html = '';
                $.each(res['data'], function (k, v) {
                    html += '<tr>';
                    $.each(v, function (hour, data) {
                        html += '<td>' + data + '</td>';
                    });
                    html += '</tr>';
                });
                b.find('.ibox-content .table tbody').html(html);
                var data = res.hcData;
                Highcharts.chart('detail-container', {
                    chart: {
                        zoomType: 'xy',
                        width:1400
                    },
                    xAxis: [{
                        categories: data.xAxis,
                        crosshair: true
                    }],
                    yAxis: [{ // Primary yAxis
                        labels: {
                            format: '{value}',
                            style: {
                                color: Highcharts.getOptions().colors[1]
                            }
                        },
                        title: false
                    }, { // Secondary yAxis
                        title: false,
                        labels: {
                            format: '{value}'+ "%",
                            style: {
                                color: Highcharts.getOptions().colors[0]
                            }
                        },
                        opposite: true
                    }],
                    tooltip: {
                        shared: true
                    },
                    legend: {
                        layout: 'vertical',
                        align: 'right',
                        verticalAlign: 'top',
                        borderWidth: 0
                    },
                    series: data.series
                });
            });
        });
    </script>
@endsection

