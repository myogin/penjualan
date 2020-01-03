<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="{{asset('bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <link rel="stylesheet" href="{{asset('css/yogi.css')}}">

</head>
<body onload="window.print();">
<div class="wrapper">

<!-- Main content -->
<section class="invoice">
<!-- title row -->
<div class="row">
    <div class="col-xs-12">
    <h2 class="page-header">
        <i class="fa fa-globe"></i> Balinese Classic
        <small class="pull-right">{{$tanggal_transaksi =date('M/d/Y', strtotime($pembelian->tanggal_transaksi))}}</small>
    </h2>
    </div>
    <!-- /.col -->
</div>
<!-- info row -->
<div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
    From
    <address>
        <strong>Balinese Classic</strong><br>
        Address: Jalan Kebo Iwa XIII<br>
        Phone: (+62) 0895342574617<br>
        Email: yoginugraha19@gmail.com
    </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
    To
    <address>
        <strong>{{$pembelian->supplier->nama}}</strong><br>
        Address: {{$pembelian->supplier->address}}<br>
        Company: {{$pembelian->supplier->perusahaan}}<br>
        Phone: {{$pembelian->supplier->phone}}<br>
        Email: {{$pembelian->supplier->email}}
    </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
    <b>Invoice #{{$pembelian->invoice_number}}</b><br>
    <br>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- Table row -->
<div class="row">
    <div class="col-xs-12 table-responsive">
    <table class="table table-striped detail_product_invoice">
        <thead>
        <tr>
        <th style="width: 50px;">No</th>
        <th style="text-align: left;">Product</th>
        <th style="width: 200px;">Price</th>
        <th style="width: 100px;text-align: center;">Qty</th>
        <th style="width: 200px;">Subtotal</th>
        </tr>
        </thead>
        <tbody>
            @php
            function rupiah($angka){

                $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                return $hasil_rupiah;

            }
                $no=1;
            @endphp
            @foreach ($pembelian->products as $value)
                <tr>
                <td style="text-align: center;">{{$no++}}</td>
                <td>{{$value->nama_produk}}</td>
                <td style="text-align: right;">{{rupiah($value->pivot->harga_jual)}}</td>
                <td style="text-align: center;">{{$value->pivot->qty}}</td>
                <td style="text-align: right;">{{rupiah($value->pivot->qty*$value->pivot->harga_jual)}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6">

    </div>
    <!-- /.col -->
    <div class="col-xs-6">

    <div class="table-responsive">
        <table class="table rata-kanan">
        <tr>
            <th >Subtotal:</th>
            <td>{{rupiah($pembelian->total_harga)}}</td>
        </tr>
        <tr>
            <th>Tax (10%)</th>
            <td>{{rupiah($pembelian->total_harga/100*10)}}</td>
        </tr>
        <tr>
            <th>Total:</th>
            <td>@php
                $total = $pembelian->total_harga+($pembelian->total_harga/100*10)+20000 ;
                echo rupiah($total);
            @endphp </td>
        </tr>
        </table>
    </div>
    </div>
    <!-- /.col -->
</div>
<!-- /.row -->

<!-- this row will not appear when printing -->
<div class="row no-print">
    <div class="col-xs-12">
    <a href="{{route('invoicePrint2', ['id' => $pembelian->id])}}" target="_blank" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print</a>

    </div>
</div>
</section>
<div class="clearfix"></div>
</div>
<!-- /.content-wrapper -->
</body>
</html>
