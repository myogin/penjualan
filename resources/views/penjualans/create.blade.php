@extends('layouts.global')
@section('title')
    penjualans
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
            <div class="col-md-12">
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
                <form role="form" enctype="multipart/form-data" action="{{route('penjualans.store')}}" method="POST">
                @csrf
                    <div class="box-body" id="box-body">

                        <div class="form-group">
                            <label for="invoice">Invoice Number</label>
                            <input type="text" class="form-control" id="invoice" name="invoice" placeholder="Invoice Number">
                        </div>
                        <div class="form-group">
                            <label for="customer">Categori</label>
                            <select class="form-control custom-select" name="customer">
                                <option selected="" disabled="">Select one</option>
                                @foreach($customers as $customer)
                                <option value="{{$customer->id}}">{{$customer->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <select class="form-control select2"  name="status" id="Status"  style="width: 100%;">
                                <option selected>Process</option>
                                <option>Finish</option>
                                <option>Cancel</option>
                            </select>
                        </div>

                    <div id="appendProduct">
		                <div class="row" id="product" >
		                	<div class="col-sm-6">
			                  <div class="form-group">
			                         <label for="product">Product</label>
                                        <select class="form-control custom-select" name="product[]">
                                            <option selected="" disabled="">Select one</option>
                                            @foreach($products as $product)
                                            <option value="{{$product->id}}">{{$product->nama_produk}}</option>
                                            @endforeach
                                        </select>
			                   </div>
			                </div>
			                <div class="col-sm-5">
			                   <div class="form-group">
			                        <label for="qty">QTY</label>
                                    <input type="number" class="form-control" id="qty" name="qty[]" placeholder="Jumlah">
			                   </div>
			                </div>

			            	<div class="col-sm-1">
			            		<div class="form-group">
			            			<label>Action</label>
			            			<button type="button" class="btn btn-danger" onclick="removeData(this)"><i class="fa fa-times"></i></button>
			            		</div>
			            	</div>
			            </div>

			        </div>
                        <button type="button" class="btn btn-success" >Tambah Product</button>
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
@section('js')
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>

    $(".btn-success").click(function(e) {
        e.preventDefault();
        $('#product').first().clone().appendTo('#appendProduct').find('#qty').val('');
});
	function removeData(ele){
		var $parent = $(ele).parent().parent().parent();
		$($parent).remove();
	}

</script>
@endsection

