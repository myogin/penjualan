
@section('css')
@endsection
@extends('layouts.global')

@section('content')
 <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Dashboard
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        </ol>
    </section>

<!-- Main content -->
<section class="content">
        @if (array_intersect(["ADMIN"], json_decode(Auth::user()->roles)))
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
            <div class="inner">
                <h3 id="tampilan_omset"></h3>

                <p>Omset Bulan ini</p>
            </div>
            <div class="icon">
                    <i class="fa fa-money"></i></a>
            </div>
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-maroon">
            <div class="inner">
                <h3>{{$transaksi_proses}}</h3>

                <p>Transaksi Berstatus Proses</p>
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
                <h3>{{$customer}}</h3>

                <p>Pelanggan Baru</p>
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
                <h3>{{$stock}}</h3>

                <p>Stok Menipis</p>
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
            <div class="box box-primary">
                <figure class="highcharts-figure">
                    <div id="container1"></div>
                </figure>
            </div>
        </section>
        <!-- /.Left col -->
        <!-- right col (We are only adding the ID to make the widgets sortable)-->
        <section class="col-lg-5 connectedSortable">
            <div class="box box-primary">
                <figure class="highcharts-figure">
                    <div id="chart-bulet"></div>
                </figure>
            </div>
        </section>
        <!-- right col -->
    </div>
    <!-- /.row (main row) -->
    @else
    <div class="row">
        <div class="col-md-12">
            <div class="box">
                <div class="box-header with-border">
                    <h2>Hallo !!</h2>
                </div>
                <div class="box-body">
                    <p>Welcome to admin dashboard Balinesse Classic</p>
                </div>
            </div>
        </div>
    </div>
    @endif
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
    var tampilan_omset = {{$total_omset}};
    document.getElementById('tampilan_omset').innerHTML= 'Rp'+IDRFormatter(tampilan_omset);

    var bilangan = {{$total_pemasukan}};
    var bilangan2 = {{$total_pengeluaran}};
        Highcharts.chart('container1', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Grafik perbandingan pengeluaran dan pemasukan ' +{{$tahun_ini}}
            },
            subtitle: {
                text: 'Total pemasukan RP ' +IDRFormatter(bilangan)+ ' || Total pengeluaran RP ' +IDRFormatter(bilangan2)
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
                name: 'Pemasukan di Tahun 2019 ' +{{$tahun_ini}},
                data: {!!json_encode($profit)!!}

            },{
                name: 'Pengeluaran di Tahun 2019 ' +{{$tahun_ini}},
                data: {!!json_encode($pengeluaran)!!}
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
        text: 'Produk Terjual Bulan ini'
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
