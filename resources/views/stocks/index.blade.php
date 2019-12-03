@extends('layouts.global')
@section('title')

@endsection
@section('css')

@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        stocks
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
                <h3 class="box-title">Data stock</h3>

                <div class="box-tools">
                <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                    <input type="text" name="table_search" class="form-control pull-right" placeholder="Search">

                    <div class="input-group-btn">
                    <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                </div>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tr>
                    <th>Produck</th>
                    <th>Stock</th>
                </tr>
                <tr>
                    @foreach($stocks as $stock)
                        <tr>
                        <td>{{$stock->nama_produk}}</td>
                        <td>@if ($stock->stok)
                            {{$stock->stok}}

                            @else
                              0
                        @endif </td>
                    @endforeach
                </tr>
                </table>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                Create stocks
            </button>

            <span class="pull-right">
                {{$stocks->appends(Request::all())->links()}}
            </span>

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
            <form role="form" enctype="multipart/form-data" action="{{route('stocks.store')}}" method="POST">
            <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="stockname">stockname</label>
                        <input type="text" class="form-control" id="stockname" name="stockname" placeholder="stockname">
                    </div>
                    <div class="form-group" >
                        <label>Role</label>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="TLM" value="TLM" >
                            <label for="TLM" class="custom-control-label">Top Level Management</label>
                        </div>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" >
                            <label for="ADMIN" class="custom-control-label">Admin</label>
                        </div>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="OPERATOR" value="OPERATOR" >
                            <label for="OPERATOR" class="custom-control-label">Operator</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password2" class="form-control" id="exampleInputPassword1" name="password2" placeholder="Konfirm Password">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Avatar</label>
                        <input id="avatar" name="avatar" type="file" >
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Tambah stocks</button>
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

@endsection
