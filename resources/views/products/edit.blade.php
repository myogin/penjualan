@extends('layouts.global')
@section('title')
    products
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
                <form role="form" enctype="multipart/form-data" action="{{route('products.update', ['id'=>$product->id])}}" method="POST">
                    @csrf
                    <input type="hidden" value="PUT" name="_method">

                    <div class="box-body">

                        <div class="form-group">
                            <label for="kode_produk">Kode Produk</label>
                            <input type="text" value="{{$product->kode_produk}}" class="form-control" id="kode_produk" name="kode_produk" placeholder="Kode Produk">
                        </div>
                        <div class="form-group">
                            <label for="nama_produk">Nama Produk</label>
                            <input type="text" value="{{$product->nama_produk}}" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk">
                        </div>
                        <div class="form-group">
                            <label>Kategori</label>
                            <select class="form-control select2" name="category_id" id="category" style="width: 100%;" placeholder="Kategori Produk">

                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea id="keterangan" value="{{$product->keterangan}}" name="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="satuan">Satuan</label>
                            <input type="text" value="{{$product->satuan}}" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
                        </div>
                        <div class="form-group">
                            <label for="harga_dasar">Harga Dasar</label>
                            <input type="number" value="{{$product->harga_dasar}}" class="form-control" id="harga_dasar" name="harga_dasar" placeholder="Harga Dasar">
                        </div>
                        <div class="form-group">
                            <label for="harga_jual">Harga Jual</label>
                            <input type="number" value="{{$product->harga_jual}}" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual">
                        </div>
                        <div class="form-group">
                            <label for="avatar">Product image</label><br>
                                Current image: <br>
                                @if($product->gambar)
                                    <img src="{{asset('storage/'.$product->gambar)}}" width="120px" /><br>
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
@section('js')
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
    $('#category').select2({
    ajax:{
        url: '{{route('categorySearch')}}',
        processResults: function(data){
            return {
                results: data.map(function(item){
                    return {
                    id: item.id,
                    text: item.name
                    }
                    })
                }
            }
        }
    });
    var categories = {!! $product->category !!}
        categories.forEach(function(category){
            var option = new Option(category.name, category.id, true, true);
            $('#category').append(option).trigger('change');
        });
    </script>
@endsection

