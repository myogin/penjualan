@extends('layouts.global')
@section('title')

@endsection
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Penjualans

        </h1>
        {{ Breadcrumbs::render('penjualan') }}
    </section>
    @php
    function rupiah($angka){

        $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
        return $hasil_rupiah;

    }
    @endphp
    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <section class="col-lg-9 connectedSortable">
                <div class="box box-primary">
                    <figure class="highcharts-figure">
                        <div id="produk-laku"></div>
                    </figure>
                </div>
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-3 connectedSortable">
                <div class="box box-primary">
                    <form action="{{route('laporans.index')}}" class="form-horizontal">
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="input-group">
                                        <label> DATA TAHUN {{$tahun_ini}} </label>
                                    </div>
                                    <div class="input-group">
                                        <label>Pilih tahun</label>
                                        <input type="text" id="datepicker" value='{{Request::get('year')}}' name='year' />
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                    <hr>
                                    <div class="input-group">
                                        @foreach ($rank_customer as $rcus)
                                        <h4>Peringkat Customer</h4>
                                        <label>Nama Customer : <u>{{$rcus->name}}</u> total tas dibeli sebanyak: <u>{{$rcus->jumlah}}</u></label>
                                        @endforeach
                                    </div>
                                    <hr>
                                    <div class="input-group">
                                        @foreach ($rank_product as $rpro)
                                        <h4>Peringkat Product</h4>
                                        <label>Nama Product : <u>{{$rpro->name}}</u> total terjual sebanyak: <u>{{$rpro->jumlah}}</u></label>
                                        @endforeach
                                    </div>
                                    <hr>
                                </div>
                                <div class="col-md-6">
                                    <h4>Laba</h4>
                                    <label>{{rupiah($total_profit)}}</label>
                                </div>
                                <div class="col-md-6">
                                        <h4>Omset</h4>
                                        <label>{{rupiah($total_omset)}}</label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- right col -->
            <!-- Left col -->
            <section class="col-lg-8 connectedSortable">
                <div class="box box-primary">
                    <figure class="highcharts-figure">
                        <div id="container1"></div>
                    </figure>
                </div>
            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-4 connectedSortable">
                <div class="box box-primary">
                    <figure class="highcharts-figure">
                        <div id="chart-bulet"></div>
                    </figure>
                </div>
            </section>
            <!-- right col -->
        </div>
        <!-- /.row (main row) -->
        <div class="row">
        <div class="col-xs-12">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{session('status')}}
            </div>
            @endif
            <div class="box">

                <div class="box-header">
                    <h4>Penjualan list
                        <a href="{{route('penjualans.create')}}" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Penjualan</a>
                    </h4>
                    <div class="row input-daterange">
                            <div class="col-md-4">
                                <input type="text" name="from_date" id="from_date" class="form-control" placeholder="From Date" readonly />
                            </div>
                            <div class="col-md-4">
                                <input type="text" name="to_date" id="to_date" class="form-control" placeholder="To Date" readonly />
                            </div>
                            <div class="col-md-4">
                                <button type="button" name="filter" id="filter" class="btn btn-primary">Filter</button>
                                <button type="button" name="refresh" id="refresh" class="btn btn-default">Refresh</button>
                            </div>
                        </div>
                        <br />
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="tabel-penjualans" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Invoice Number</th>
                        <th>Tanggal pesan</th>
                        <th>Customer</th>
                        <th>Produk</th>

                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Invoice Number</th>
                        <th>Tanggal pesan</th>
                        <th>Customer</th>
                        <th>Produk</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
        </div>
        </div>
        <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Default Modal</h4>
            </div>
            <form role="form" enctype="multipart/form-data" action="{{route('penjualans.store')}}" method="POST">
            <div class="modal-body">

                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" id="kode_produk" name="kode_produk" placeholder="Kode Produk">
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;" placeholder="Kategori Produk">

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="form-group">
                        <label for="harga_dasar">Harga Dasar</label>
                        <input type="number" class="form-control" id="harga_dasar" name="harga_dasar" placeholder="Harga Dasar">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Gambar</label>
                        <input id="produk" name="produk" type="file" >
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Tambah penjualans</button>
                <button type="buton" class="btn btn-default " data-dismiss="modal">Close</button>

            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection
@section('js')
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.css"/>

<script type="text/javascript" src="https://cdn.datatables.net/v/bs/jszip-2.5.0/pdfmake-0.1.18/dt-1.10.12/af-2.1.2/b-1.2.2/b-colvis-1.2.2/b-flash-1.2.2/b-html5-1.2.2/b-print-1.2.2/cr-1.3.2/fc-3.2.2/fh-3.1.2/kt-2.1.3/r-2.1.0/rr-1.1.2/sc-1.4.2/se-1.2.0/datatables.min.js"></script>
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
Highcharts.chart('produk-laku', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Grafik Penjualan Tas Tahun '+{{$tahun_ini}}
    },
    subtitle: {
        text: 'Total tas terjual '+{{$terjual}}+' PCS'
    },
    xAxis: {
        categories: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'May',
            'Jun',
            'Jul',
            'Aug',
            'Sep',
            'Oct',
            'Nov',
            'Dec'
        ],
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Rainfall (mm)'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.1f} pcs</b></td></tr>',
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
    series:{!!json_encode($product_name)!!}
});

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
                    '<td style="padding:0"><b>{point.y:.1f} IDR</b></td></tr>',
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
        text: 'Produk Terjual Tahun' +{{$tahun_ini}}
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
<script>
    $('#category_id').select2({
    ajax:{
        url: '{{route('categorySearch')}}',
        processResults: function(data){
            return {
                results: data.map(function(item){
                    return {
                    id: item.id,
                    text: item.name
                    }
                    })
                }
            }
        }
    });
    </script>



  <script type="text/javascript">
$(document).ready(function(){
 $('.input-daterange').datepicker({
  todayBtn:'linked',
  format:'yyyy-mm-dd',
  autoclose:true
 });

 load_data();

 function load_data(from_date = '', to_date = '')
 {
    $('#tabel-penjualans').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
    url:'{{ route('laporans.index')}}',
    data:{from_date:from_date, to_date:to_date}
   },
        columns: [
            { data: 'id',sortable: true,
                render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
                },width: '20'},
        {data: 'invoice_number', name: 'invoice_number'},
        {data: 'tanggal_transaksi', name: 'tanggal_transaksi'},
        {data: 'customer.nama', name: 'customer.nama'},
        {data: 'products[ | ].nama_produk', name: 'products[].nama_produk'},
        {data: 'total_harga', name: 'total_harga'},
        {data: 'status', name: 'status',width: '80'},
        {data: 'action', name: 'action', orderable: false, searchable: false,width: '120px'}
        ],
        columnDefs: [{targets: 6,
            render: function ( data, type, row ) {
            var css1 = 'black';
            if (data == 'FINISH') {
                css1 = 'bg-olive btn-flat btn-xs';
            }if (data == 'CANCEL') {
                css1 = 'bg-navy btn-flat btn-xs';
            }if (data == 'PROCESS') {
                css1 = 'bg-maroon btn-flat btn-xs';
            }
            return '<span class="'+ css1 +'">' + data + '</span>';
            }
    }],
    dom: 'lBfrtip',
   buttons: [
    'excel', 'csv', 'pdf', 'copy'
   ],
   "lengthMenu": [ [10, 25, 50, -1], [10, 25, 50, "All"] ]

    });
}

$('#filter').click(function(){
 var from_date = $('#from_date').val();
 var to_date = $('#to_date').val();
 if(from_date != '' &&  to_date != '')
 {
  $('#tabel-penjualans').DataTable().destroy();
  load_data(from_date, to_date);
 }
 else
 {
  alert('Both Date is required');
 }
});

$('#refresh').click(function(){
 $('#from_date').val('');
 $('#to_date').val('');
 $('#order_table').DataTable().destroy();
 load_data();
});

});


    function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-default').modal('show');
        $('#modal-default form')[0].reset();
        $('.modal-title').text('Add penjualan');
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-default form')[0].reset();
        $.ajax({
            url: "{{ url('penjualans') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
            $('#modal-default').modal('show');
            $('.modal-title').text('Edit penjualan');

            $('#id').val(data.id);
            $('#kode_produk').val(data.products[0].nama_produk);
            $('#nama_produk').val(data.nama_produk);
            $('#keterangan').val(data.keterangan);
            $('#satuan').val(data.satuan);
            $('#harga_dasar').val(data.harga_dasar);
            $('#harga_jual').val(data.harga_jual);
            },
            error : function() {
                alert("Nothing Data");
            }
        });
        }
    function deleteData(id){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.ajax({
                url : "{{ url('penjualans') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    table.ajax.reload();
                    swal({
                        title: 'Success!',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function () {
                    swal({
                        title: 'Oops...',
                        text: data.message,
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
        }
    $(function(){
            $('#modal-default form').validator().on('submit', function (e) {

                var form =  $('#modal-default form');
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');

                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('penjualans') }}";
                    else url = "{{ url('penjualans') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        // data : $('#modal-default form').serialize(),
                        data: new FormData($("#modal-default form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-default').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(xhr){
                            var res = xhr.responseJSON;
                            if($.isEmptyObject(res) == false){
                                $.each(res.errors, function(key, value){
                                    $('#' + key)
                                        .closest('.form-group')
                                        .addClass('has-error')
                                        .append('<span class="help-block"><strong>'+ value +'</strong></span>')
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
        $("#datepicker").datepicker({
    format: "yyyy",
    viewMode: "years",
    minViewMode: "years"
});
    </script>
@endsection
