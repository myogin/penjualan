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
            Address: Jalan Kebo Iwa XIII<br>
            Phone: (+62) 0895342574617<br>
            Email: yoginugraha19@gmail.com
        </address>
        </div>
        <!-- /.col -->
        <div class="col-sm-4 invoice-col">
        To
        <address>
            <strong>{{$penjualan->customer->nama}}</strong><br>
            Address: {{$penjualan->customer->address}}<br>
            Company: {{$penjualan->customer->perusahaan}}<br>
            Phone: {{$penjualan->customer->phone}}<br>
            Email: {{$penjualan->customer->email}}
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
                @foreach ($penjualan->products as $value)
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
        <p class="lead">Payment Methods:</p>
        <img src="../../dist/img/credit/bca.png" alt="BCA" style="max-width: 80px;">

        <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Pembayaran bisa dilakukan pada rekening bca berikut : <br>
            No Rek : 118941651684 <br>
            A/N    : Made Yogi Nugraha
        </p>
        </div>
        <!-- /.col -->
        <div class="col-xs-6">

        <div class="table-responsive">
            <table class="table rata-kanan">
            <tr>
                <th >Subtotal:</th>
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
        <a href="{{route('invoicePrint', ['id' => $penjualan->id])}}" target="_blank" class="btn btn-success pull-right"><i class="fa fa-print"></i> Print</a>
        </div>
    </div>
    </section>
    <!-- /.content -->
@endsection
@section('js')
@endsection
