<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 2 | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
        !-- Content Header (Page header) -->
        <section class="content-header">
                <h1>
                  Invoice
                  <small>#{{$penjualan->invoice_number}}</small>
                </h1>
                {{ Breadcrumbs::render('transaksi') }}
              </section>
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Balinese Classic
                    <small class="pull-right">{{$tanggal_transaksi =date('M/d/Y', strtotime($penjualan->tanggal_transaksi))}}</small>
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
                    Jalan Kebo Iwa Perum<br>
                    Swamandala XIII no 3<br>
                    Phone: (+62) 0895342574617<br>
                    Email: yoginugraha19@gmail.com
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                To
                <address>
                    <strong>{{$penjualan->customer->nama}}</strong><br>
                    {{$penjualan->customer->address}}<br>
                    {{$penjualan->customer->perusahaan}}<br>
                    {{$penjualan->customer->phone}}<br>
                    {{$penjualan->customer->email}}
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                <b>Invoice #{{$penjualan->invoice_number}}</b><br>
                <br>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                    <th>No</th>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                        @php
                            $no=1;
                        @endphp
                        @foreach ($penjualan->products as $value)
                            <tr>
                            <td>{{$no++}}</td>
                            <td>{{$value->nama_produk}}</td>
                            <td>{{$value->pivot->harga_jual}}</td>
                            <td>{{$value->pivot->qty}}</td>
                            <td>{{$value->pivot->qty*$value->pivot->harga_jual}}</td>
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
                <p class="lead">Payment Methods:</p>
                <img src="../../dist/img/credit/visa.png" alt="Visa">
                <img src="../../dist/img/credit/mastercard.png" alt="Mastercard">
                <img src="../../dist/img/credit/american-express.png" alt="American Express">
                <img src="../../dist/img/credit/paypal2.png" alt="Paypal">

                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
                    dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
                </p>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">

                <div class="table-responsive">
                    <table class="table">
                    <tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>Rp {{$penjualan->total_harga}}</td>
                    </tr>
                    <tr>
                        <th>Tax (10%)</th>
                        <td>Rp {{$penjualan->total_harga/100*10}}</td>
                    </tr>
                    <tr>
                        <th>Shipping</th>
                        <td>Rp 20000</td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>@php
                            $total = $penjualan->total_harga+($penjualan->total_harga/100*10) ;
                            echo "Rp $total";
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
                <a href="{{route('invoicePrint', ['id' => $penjualan->id])}}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                <button type="button" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Submit Payment
                </button>
                <button type="button" class="btn btn-primary pull-right" style="margin-right: 5px;">
                    <i class="fa fa-download"></i> Generate PDF
                </button>
                </div>
            </div>
            </section>
            <!-- /.content -->
            <div class="clearfix"></div>
        </div>
        <!-- /.content-wrapper -->
</body>
</html>
