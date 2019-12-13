
@section('css')
@endsection
@extends('layouts.global')

@section('content')
 <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Simple Tables
        <small>preview of simple tables</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Simple</li>
        </ol>
    </section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-aqua">
            <div class="inner">
            </div>
            <div class="icon">
            <i class="ion ion-bag"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-green">
            <div class="inner">
            </div>
            <div class="icon">
            <i class="ion ion-stats-bars"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-yellow">
            <div class="inner">
                </h3>

            <p>Omset Bulan Ini</p>
            </div>
            <div class="icon">
            <i class="ion ion-person-add"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <div class="small-box bg-red">
            <div class="inner">
            <h3>65</h3>

            <p>Unique Visitors</p>
            </div>
            <div class="icon">
            <i class="ion ion-pie-graph"></i>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
        </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->
    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-7 connectedSortable">
                <figure class="highcharts-figure">
                        <div id="container1"></div>
                        <p class="highcharts-description">
                            A basic column chart compares rainfall values between four cities.
                            Tokyo has the overall highest amount of rainfall, followed by New York.
                            The chart is making use of the axis crosshair feature, to highlight
                            months as they are hovered over.
                        </p>
                    </figure>



        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">

                <figure class="highcharts-figure">
                        <div id="chart-bulet"></div>
                        <p class="highcharts-description">
                            A basic column chart compares rainfall values between four cities.
                            Tokyo has the overall highest amount of rainfall, followed by New York.
                            The chart is making use of the axis crosshair feature, to highlight
                            months as they are hovered over.
                        </p>
                    </figure>




        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->

    </section>
    <!-- /.content -->
@endsection
@section('js')
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    function IDRFormatter(angka, prefix) {
    var number_string = angka.toString().replace(/[^,\d]/g, ''),
        split = number_string.split(','),
        sisa = split[0].length % 3,
        rupiah = split[0].substr(0, sisa),
        ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    if (ribuan) {
        separator = sisa ? '.' : '';
        rupiah += separator + ribuan.join('.');
    }

    rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}
    var bilangan = {{$total_profit}};
        Highcharts.chart('container1', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Pendapatan di tahun ' +{{$tahun_ini}}
            },
            subtitle: {
                text: 'Total profit RP ' +IDRFormatter(bilangan)
            },
            xAxis: {
                categories: {!!json_encode($bulans)!!},
                crosshair: true
            },
            yAxis: {
                label:{
                    formatter: function(){
                    return IDRFormatter(this.value, 'Rp. ');
                }

                },
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px">Pendapatan di bulan {point.key}</span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0"></td>' +
                    '<td style="padding:0"><b>{point.y:.0f} IDR</b></td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
            series: [{
                name: 'Pendapatan Tahun 2019',
                data: {!!json_encode($profit)!!}

            }]
        });
        </script>
<script>
    Highcharts.chart('chart-bulet', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Browser market shares in January, 2018'
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
    },
    accessibility: {
        point: {
            valueSuffix: '%'
        }
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                format: '<b>{point.name}</b>: {point.y:.1f} pcs'
            }
        }
    },
    series: [{
        name: 'Presentase',
        colorByPoint: true,
        data: {!!json_encode($penjualan2)!!}
    }]
});
</script>
@endsection
