@extends('layouts.global')
@section('title')

@endsection
@section('css')

@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Kategori
        <small>preview of simple tables</small>
        </h1>
        <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Tables</a></li>
        <li class="active">Kategori</li>
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
                <h3 class="box-title">Data Kategori</h3>

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
                    <th>Kategori</th>
                    <th>Image</th>
                    <th>Action</th>
                </tr>
                <tr>
                    @foreach($categories as $category)
                        <tr>
                        <td>{{$category->name}}</td>
                        <td>
                            @if($category->image)
                            <img src="{{asset('storage/'.$category->image)}}" width="70px" />
                            @else
                            N/A
                            @endif
                        </td>
                        <td style="display: flex;">
                            <a class="btn btn-info btn-sm" href="{{route('categories.edit',['id'=>$category->id])}}">Edit</a>
                                <form onsubmit="return confirm('Delete this category permanently?')" class="d-inline"
                                    action="{{route('categories.destroy', ['id' => $category->id ])}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="submit" value="Delete" class="btn btn-danger btn-sm" style="margin-left: 2px;">
                                </form>
                        </td>
                    @endforeach
                </tr>
                </table>
            </div>
            <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-default">
                Tambah Kategori
            </button>

            <span class="pull-right">
                {{$categories->appends(Request::all())->links()}}
            </span>

        </div>
        </div>
        <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Kategori</h4>
            </div>
            <form role="form" enctype="multipart/form-data" action="{{route('categories.store')}}" method="POST">
            <div class="modal-body">

                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control {{$errors->first('name') ? "is-invalid" : ""}}" id="name" name="name" placeholder="Full Name" value="{{old('name')}}">
                    <div class="invalid-feedback">  {{$errors->first('name')}}</div>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input id="image" name="image" type="file" value="{{old('name')}}">
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Tambah Kategori</button>
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
