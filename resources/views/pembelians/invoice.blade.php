@extends('layouts.global')
@section('title')
    Invoice
@endsection
@section('content')
<!-- Content Header (Page header) -->
<section class="content-header">
        <h1>
          Invoice
          <small>#{{$pembelian->invoice_number}}</small>
        </h1>
        {{ Breadcrumbs::render('transaksi-beli') }}
      </section>
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
                    <td style="text-align: right;">{{rupiah($value->pivot->harga_beli)}}</td>
                    <td style="text-align: center;">{{$value->pivot->qty}}</td>
                    <td style="text-align: right;">{{rupiah($value->pivot->qty*$value->pivot->harga_beli)}}</td>
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
@endsection
@section('js')
@endsection
