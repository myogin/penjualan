@extends('layouts.global')
@section('title')
    customers
@endsection
@section('content')

    <section class="content-header">
        <h1>
            General Form Elements
            <small>Preview</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Forms</a></li>
            <li class="active">General Elements</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
            @if(session('status'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Alert!</h4>
                {{session('status')}}
            </div>
            @endif
            <!-- general form elements -->
            <div class="box box-primary">
                <div class="box-header with-border">
                <h3 class="box-title">Quick Example</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" enctype="multipart/form-data" action="{{route('customers.update', ['id'=>$customer->id])}}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">

                    <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{$customer->nama}}" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" value="{{$customer->email}}" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="perusahaan">Perusahaan</label>
                        <input type="text" value="{{$customer->perusahaan}}" class="form-control" id="perusahaan" name="perusahaan" placeholder="Perusahaan">
                    </div>

                    <div class="form-group">
                        <label for="phone">telepon</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{$customer->phone}}">
                    </div>
                    <div class="form-group">
                        <label for="address">A3a0at</label>
                        <textarea id="address" name="address" class="form-control" rows="4">{{$customer->address}}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="avatar">Avatar image</label><br>
                            Current avatar: <br>
                            @if($customer->avatar)
                                <img src="{{asset('storage/'.$customer->avatar)}}" width="120px" /><br>
                            @else
                                No avatar
                            @endif<br>
                        <input id="avatar" name="avatar" type="file">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
                    </div>
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
