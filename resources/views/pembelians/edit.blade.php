@extends('layouts.global')
@section('title')
    Pembelians
@endsection
@section('content')

    <section class="content-header">
        <h1>
            Edit Transaksi
        </h1>
        {{ Breadcrumbs::render('transaksi-beli') }}
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
                <h3 class="box-title">Form Transaksi</h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form role="form" enctype="multipart/form-data" action="{{route('pembelians.update', ['id'=>$pembelian->id])}}" method="POST">
                @csrf
                <input type="hidden" value="PUT" name="_method">
                    <div class="box-body" id="box-body">
                        <!-- Date -->
                        <?php
                            $tanggal_transaksi =date('m/d/Y', strtotime($pembelian->tanggal_transaksi));
                        ?>
                        <div class="form-group {{$errors->first('tanggal_transaksi') ? "has-error": ""}}">
                                <label>Date:</label>

                                <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right"
                            id="datepicker" name="tanggal_transaksi" value="{{$tanggal_transaksi}}">
                                </div>
                                <span class="help-block"><strong>{{$errors->first('tanggal_transaksi')}}</strong></span>
                                <!-- /.input group -->
                            </div>
                            <!-- /.form group -->
                        <div class="form-group {{$errors->first('supplier') ? "has-error": ""}}">
                                <label>supplier</label>
                                <select class="form-control select2" name="supplier" value="{{old('supplier')}}" id="supplier" style="width: 100%;" placeholder="Kategori Produk">
                                    <option value="">Select Product</option>
                                    @foreach ($suppliers as $supplier)
                                    <option value="{{$supplier->id}}">{{$supplier->nama}} || {{$supplier->perusahaan}}</option>
                                    @endforeach
                                </select>
                                <span class="help-block"><strong>{{$errors->first('supplier')}}</strong></span>
                            </div>
                        <div class="form-group">
                            <label for="Status">Status</label>
                            <select class="form-control"  name="status" id="Status"  style="width: 100%;">
                                <option {{$pembelian->status == "PROCESS" ? "selected" : ""}} value="PROCESS">PROCESS</option>
                                <option {{$pembelian->status == "FINISH" ? "selected" : ""}} value="FINISH">FINISH</option>
                                <option {{$pembelian->status == "CANCEL" ? "selected" : ""}} value="CANCEL">CANCEL</option>
                            </select>
                        </div>


                    <div id="appendProduct">
                        @if (!(empty(@$pembelian->details)))
                            @foreach ($pembelian->details as $value)
                            <div class="row" id="product" >
                                <div class="col-sm-6">
                                    <div class="form-group {{$errors->first('product') ? "has-error": ""}}">
                                        <label for="product">Product</label>
                                        <select class="form-control selectproduct" name="product[]" style="width: 100%;" onchange="loadBarang(this)" placeholder="Kategori Produk" required>
                                            <option value="">Select Product</option>
                                            @foreach ($products as $product)
                                            <option value="{{$product->id}}" {{ ($product->id == $value->product_id)? 'selected':'' }}>{{$product->nama_produk}} || {{$product->kode_produk}}</option>
                                            @endforeach
                                        </select>
                                        <span class="help-block"><strong>{{$errors->first('product')}}</strong></span>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                <div class="form-group {{$errors->first('qty') ? "has-error": ""}}">
                                        <label for="qty">QTY</label>
                                        <input type="number" class="form-control" id="qty" value="{{$value->qty}}" name="qty[]" placeholder="Jumlah" required min="1" >
                                        <span class="help-block"><strong>{{$errors->first('qty')}}</strong></span>
                                </div>
                                </div>

                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <label>Action</label>
                                        <button type="button" class="btn btn-danger" onclick="removeData(this)"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
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
    $('#supplier').select2({
    ajax:{
        url: '{{route('supplierSearch')}}',
        processResults: function(data){
            return {
                results: data.map(function(item){
                    return {
                    id: item.id,
                    text: item.nama +" || "+ item.perusahaan
                    }
                    })
                }
            }
        }
    });
    var data_cus = {{$pembelian->supplier_id}};
    console.log(data_cus);
    $('.select2').val(data_cus).trigger('change');


    var number = document.getElementById('qty');

    // Listen for input event on numInput.
    number.onkeydown = function(e) {
        if(!((e.keyCode > 95 && e.keyCode < 106)
        || (e.keyCode > 47 && e.keyCode < 58)
        || e.keyCode == 8)) {
            return false;
        }
    }
    $(".btn-success").click(function(e) {
        e.preventDefault();
        var appendProductDetail = `
        <div class="row" id="product" >
            <div class="col-sm-6">
                <div class="form-group">
                    <label for="product">Product</label>
                    <select class="form-control select2 selectproduct" name="product[]" style="width: 100%;" placeholder="Kategori Produk" onchange="loadBarang(this)" required>
                        <option value="">Select Product</option>
                        @foreach ($products as $product)
                        <option value="{{$product->id}}">{{$product->nama_produk}} || {{$product->kode_produk}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-sm-5">
                <div class="form-group">
                    <label for="qty">QTY</label>
                    <input type="number" class="form-control qty" id="qty" name="qty[]" placeholder="Jumlah" required min="1">
                </div>
            </div>

            <div class="col-sm-1">
                <div class="form-group">
                    <label>Action</label>
                    <button type="button" class="btn btn-danger" onclick="removeData(this)"><i class="fa fa-times"></i></button>
                </div>
            </div>
        </div>
        `;
        $('#appendProduct').append(appendProductDetail);
        $('.select2').select2();
    })

	function removeData(ele){
		var $parent = $(ele).parent().parent().parent();
		$($parent).remove();
	}

    function loadBarang(ele){
        var count_selected = 0;
        $('.selectproduct').each(function(index){
            var id_product = $(this).val();
            var now_id_product = $(ele).val();

            if(id_product == now_id_product){
                count_selected += 1;
            }
        });

        if(count_selected > 1){

                alert('Product sudah dipilih sebelumnya!');
                $(ele).val('').trigger('change');
                return false;
        }
    }

//Date picker
$('#datepicker').datepicker({
      autoclose: true
    })
</script>
@endsection

