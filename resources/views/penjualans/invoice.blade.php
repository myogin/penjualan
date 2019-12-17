@extends('layouts.global')
@section('title')
    Invoice
@endsection
@section('content')
<!-- Content Header (Page header) -->
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
                function rupiah($angka){

                    $hasil_rupiah = "Rp " . number_format($angka,0,',','.');
                    return $hasil_rupiah;

                }
                    $no=1;
                @endphp
                @foreach ($penjualan->products as $value)
                    <tr>
                    <td>{{$no++}}</td>
                    <td>{{$value->nama_produk}}</td>
                    <td>{{rupiah($value->pivot->harga_jual)}}</td>
                    <td>{{$value->pivot->qty}}</td>
                    <td>{{rupiah($value->pivot->qty*$value->pivot->harga_jual)}}</td>
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
                <td>{{rupiah($penjualan->total_harga)}}</td>
            </tr>
            <tr>
                <th>Tax (10%)</th>
                <td>{{rupiah($penjualan->total_harga/100*10)}}</td>
            </tr>
            <tr>
                <th>Shipping</th>
                <td>{{rupiah($penjualan->shipping)}}</td>
            </tr>
            <tr>
                <th>Total:</th>
                <td>@php
                    $total = $penjualan->total_harga+($penjualan->total_harga/100*10)+20000 ;
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
@endsection
@section('js')
@endsection
