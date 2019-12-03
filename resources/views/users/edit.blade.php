@extends('layouts.global')
@section('title')
    Users
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
                <form role="form" enctype="multipart/form-data" action="{{route('users.update', ['id'=>$user->id])}}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">

                    <div class="box-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{$user->name}}" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" value="{{$user->username}}" class="form-control" id="username" name="username" placeholder="Username">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <div class="form-check" style="padding-right: 50px; display: table-cell;">
                            <input class="form-check-input" type="radio" name="status" {{$user->status == "ACTIVE" ? "checked" : ""}} value="ACTIVE">
                            <label class="form-check-label">Aktif</label>
                        </div>
                        <div class="form-check" style="padding-right: 50px; display: table-cell;">
                            <input class="form-check-input" type="radio" name="status"  {{$user->status == "INACTIVE" ? "checked" : ""}} value="INACTIVE">
                            <label class="form-check-label">no AKtif</label>
                        </div>
                    </div>


                    <div class="form-group" >
                        <label>Role</label>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="TLM" value="TLM" {{in_array("TLM", json_decode($user->roles)) ?"checked" : ""}}>
                            <label for="TLM" class="custom-control-label">Top Level Management</label>
                        </div>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="ADMIN" value="ADMIN" {{in_array("ADMIN", json_decode($user->roles)) ?"checked" : ""}}>
                            <label for="ADMIN" class="custom-control-label">Admin</label>
                        </div>
                        <div class="custom-control custom-checkbox" style="padding-right: 50px; display: table-cell;">
                            <input class="custom-control-input" type="checkbox" name="roles[]" id="OPERATOR" value="OPERATOR" {{in_array("OPERATOR", json_decode($user->roles)) ?"checked" : ""}}>
                            <label for="OPERATOR" class="custom-control-label">Operator</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="text" class="form-control" id="phone" name="phone" placeholder="Phone Number" value="{{$user->phone}}">
                    </div>
                    <div class="form-group">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" class="form-control" rows="4">{{$user->address}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">Email address</label>
                        <input type="email" value="{{$user->email}}" class="form-control" id="exampleInputEmail1" name="email" placeholder="Enter email">
                    </div>
                    <div class="form-group">
                        <label for="avatar">Avatar image</label><br>
                            Current avatar: <br>
                            @if($user->avatar)
                                <img src="{{asset('storage/'.$user->avatar)}}" width="120px" /><br>
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
