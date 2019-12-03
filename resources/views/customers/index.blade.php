@extends('layouts.global')
@section('title')

@endsection
@section('css')

@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        customers
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
                <h3 class="box-title">Data customer</h3>

                <div class="box-tools">
                    <form action="{{route('customers.index')}}">
                        <div class="input-group input-group-sm hidden-xs" style="width: 150px;">
                            <input type="text" value="{{Request::get('customer_email')}}" name="customer_email" class="form-control pull-right" placeholder="Search">

                            <div class="input-group-btn">
                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
                <table class="table table-hover">
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Perusahaan</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th>Avatar</th>
                    <th>Action</th>
                </tr>
                <tr>
                    @foreach($customers as $customer)
                        <tr>
                        <td>{{$customer->nama}}</td>
                        <td>{{$customer->email}}</td>
                        <td>{{$customer->perusahaan}}</td>
                        <td>{{$customer->phone}}</td>
                        <td>{{$customer->address}}</td>
                        <td>
                            @if($customer->avatar)
                            <img src="{{asset('storage/'.$customer->avatar)}}" width="70px" />
                            @else
                            N/A
                            @endif
                        </td>
                        </td>
                        <td style="display: flex;">
                            <a class="btn btn-info btn-sm" href="{{route('customers.edit',['id'=>$customer->id])}}">Edit</a>
                                <form onsubmit="return confirm('Delete this customer permanently?')" class="d-inline"
                                    action="{{route('customers.destroy', ['id' => $customer->id ])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm" style="margin-left: 2px;">
                                </form>
                            <a   href="{{route('customers.show', ['id' => $customer->id])}}"class="btn bg-maroon btn-sm" style="margin-left: 2px;">Detail</a>
                        </td>
                    @endforeach
                </tr>
                </table>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                Create customers
            </button>

            <span class="pull-right">
                {{$customers->appends(Request::all())->links()}}
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
            <form role="form" enctype="multipart/form-data" action="{{route('customers.store')}}" method="POST">
            <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="perusahaan">Perusahaan</label>
                        <input type="text" class="form-control" id="perusahaan" name="perusahaan" placeholder="Perusahaan">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat</label>
                        <textarea id="address" name="address" class="form-control" rows="4"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Avatar</label>
                        <input id="avatar" name="avatar" type="file" >
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Tambah customers</button>
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
