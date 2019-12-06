@extends('layouts.global')
@section('title')
    categories
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
                <form role="form" enctype="multipart/form-data" action="{{route('categories.update', ['id'=>$category->id])}}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">

                    <div class="box-body">
                        <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" value="{{$category->name}}" class="form-control" id="name" name="name" placeholder="Full Name">
                    </div>
                    <div class="form-group">
                        <label for="image">Avatar image</label><br>
                            Current avatar: <br>
                            @if($category->image)
                                <img src="{{asset('storage/'.$category->image)}}" width="120px" /><br>
                            @else
                                No avatar
                            @endif<br>
                        <input id="image" name="image" type="file">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah avatar</small>
                    </div>
                    <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    </div>

                </div>
                    <!-- /.card-body -->


                </form>
                <!-- /.box-body -->
            </div>
            <!-- /.box -->
            </div>
        </div>
    </section>
@endsection
