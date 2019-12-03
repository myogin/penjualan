@extends('layouts.global')
@section('title')
    Users
@endsection
@section('content')
    <div class="content-wrapper" style="min-height: 1233.2px;">
        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Profile</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">User Profile</li>
                </ol>
            </div>
            </div>
        </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
        <div class="container-fluid">
            <div class="row">
            <div class="col-md-3">

                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                    @if($user->avatar)
                    <img class="profile-user-img img-fluid img-circle" src="{{asset('storage/'. $user->avatar)}}" alt="User profile picture">
                    @else
                    No Profile Picture
                    @endif
                    </div>

                    <h3 class="profile-username text-center">{{$user->name}}</h3>

                    <p class="text-muted text-center">{{$user->email}}</p>

                    <ul class="list-group list-group-unbordered mb-3">
                    <li class="list-group-item">
                        <b>Phone </b> <a class="float-right">{{$user->phone}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Address</b> <a class="float-right">{{$user->address}}</a>
                    </li>
                    <li class="list-group-item">
                        <b>Roles</b> <a class="float-right">@foreach(json_decode($user->roles) as $role) {{$role}}  <br>
                @endforeach</a>
                    </li>
                    </ul>

                    <a href="#" class="btn btn-primary btn-block"><b>Hello</b></a>
                </div>
                <!-- /.card-body -->
                </div>
                <!-- /.card -->


            </div>
            <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
