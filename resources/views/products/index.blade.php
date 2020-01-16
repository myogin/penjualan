@extends('layouts.global')
@section('title')

@endsection
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('bower_components/select2/dist/css/select2.min.css')}}">
@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        Products
        </h1>

        {{ Breadcrumbs::render('product') }}
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
                    <h4>Product list
                        <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Product</a>
                    </h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="tabel-products" class="table table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Ketegori</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Harga Dasar</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                        <th>No</th>
                        <th>Nama Ketegori</th>
                        <th>Kode Produk</th>
                        <th>Nama Produk</th>
                        <th>Satuan</th>
                        <th>Harga Dasar</th>
                        <th>Harga Jual</th>
                        <th>Stock</th>
                        <th>Action</th>
                    </tr>
                    </tfoot>
                    </table>
                </div>
                <!-- /.box-body -->
                </div>
                <!-- /.box -->
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
            <form role="form" enctype="multipart/form-data" action="{{route('products.store')}}" method="POST">
            <div class="modal-body">

                    {{ csrf_field() }} {{ method_field('POST') }}
                    <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="kode_produk">Kode Produk</label>
                        <input type="text" class="form-control" id="kode_produk" name="kode_produk" placeholder="Kode Produk">
                    </div>
                    <div class="form-group">
                        <label for="nama_produk">Nama Produk</label>
                        <input type="text" class="form-control" id="nama_produk" name="nama_produk" placeholder="Nama Produk">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select class="form-control select2" name="category_id" id="category_id" style="width: 100%;"
                        placeholder="Kategori Produk">
                        <option value="">Select Product</option>
                        @foreach ($categories as $category)
                        <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea id="keterangan" name="keterangan" class="form-control" rows="4" placeholder="Keterangan"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="satuan">Satuan</label>
                        <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Satuan">
                    </div>
                    <div class="form-group">
                        <label for="harga_dasar">Harga Dasar</label>
                        <input type="number" class="form-control" id="harga_dasar" name="harga_dasar" placeholder="Harga Dasar">
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" class="form-control" id="harga_jual" name="harga_jual" placeholder="Harga Jual">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputFile">Gambar</label>
                        <input id="produk" name="produk" type="file" >
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left">Tambah products</button>
                <button type="buton" class="btn btn-default " data-dismiss="modal">Close</button>

            </div>
            </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        {{-- form show --}}
        <div class="modal fade" id="modal-show">
                <div class="modal-dialog">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title">Default Modal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                        <div class="col-md-6">
                            <h5>Kode Produk</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-qrcode"></i></span>
                                <input type="text" id="skode"class="form-control" disabled="">
                            </div>
                            <h5>Nama</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-edit"></i></span>
                                <input type="text" id="snama"class="form-control" disabled="">
                            </div>
                            <h5>Kategori</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-reorder"></i></span>
                                <input type="text" id="skate"class="form-control" disabled="">
                            </div>
                            <h5>Satuan</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-balance-scale"></i></span>
                                <input type="text" id="ssatuan"class="form-control" disabled="">
                            </div>
                            <h5>Keterangan</h5>
                            <div class="input-group">
                                <textarea class="form-control" id="sket" rows="3" disabled=""></textarea>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h5>Avatar</h5>
                            <div class="input-group img-show">
                                    <img id="savatar" src="" width="120px" /><br>
                            </div>
                            <h5>Harga Dasar</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <input type="text" id="sharga1" class="form-control" disabled="">
                            </div>
                            <h5>Harga Jual</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-money"></i></span>
                                <input type="text" id="sharga" class="form-control" disabled="">
                            </div>
                            <h5>Stok</h5>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-database"></i></span>
                                <input type="text" id="sstok"class="form-control" disabled="">
                            </div>
                        </div>
                    </div>
                    </div>
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
<!-- Select2 -->
<script src="{{asset('bower_components/select2/dist/js/select2.full.min.js')}}"></script>
<script>
    $('#category_id').select2({
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

    </script>

<script type="text/javascript">
    var table = $('#tabel-products').DataTable({
        aaSorting: [[0, "desc"]],
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.product') }}",
        columns: [
        {data: 'id', sortable: true,
                render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
                },width: '20'},

        {data: 'category.name', name: 'category.name'},
        {data: 'kode_produk', name: 'kode_produk'},
        {data: 'nama_produk', name: 'nama_produk'},
        {data: 'satuan', name: 'satuan'},
        {data: 'harga_dasar', name: 'harga_dasar'},
        {data: 'harga_jual', name: 'harga_jual'},
        {data: 'stock.stok', name: 'stok'},
        {data: 'action', name: 'action', orderable: false, searchable: false,width: '180px'}
        ]
    });
    function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-default').modal('show');
        $('#modal-default form')[0].reset();
        $('.modal-title').text('Add product');
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-default form')[0].reset();

        $.ajax({
            url: "{{ url('products') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
            $('#modal-default').modal('show');
            $('.modal-title').text('Edit product');

            $('.select2').val(data.category_id).trigger('change');
            console.log(data.category_id);
            $('#id').val(data.id);
            $('#kode_produk').val(data.kode_produk);
            $('#nama_produk').val(data.nama_produk);
            $('#keterangan').val(data.keterangan);
            $('#satuan').val(data.satuan);
            $('#harga_dasar').val(data.harga_dasar);
            $('#harga_jual').val(data.harga_jual);
            },
            error : function() {
                alert("Nothing Data");
            }
        });
        }
        function showForm(id) {
        $.ajax({
            url: "{{ url('products') }}" + '/' + id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
            $('#modal-show').modal('show');
            $('.modal-title').text('Info Data Product');

            $('#skode').val(data.kode_produk);
            $('#snama').val(data.nama_produk);
            $('#skate').val(data.category.name);
            $('#ssatuan').val(data.satuan);
            $('#sket').val(data.keterangan);
            $('#sharga').val(data.harga_jual);

            $('#sharga1').val(data.harga_dasar);
            $('#sstok').val(data.stock.stok);

            document.getElementById("savatar").src = "{{asset('storage/')}}/"+data.gambar;
            },
            error : function() {
                alert("Nothing Data");
            }
        });
        }
    function deleteData(id){
        var csrf_token = $('meta[name="csrf-token"]').attr('content');
        swal({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#d33',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then(function () {
            $.ajax({
                url : "{{ url('products') }}" + '/' + id,
                type : "POST",
                data : {'_method' : 'DELETE', '_token' : csrf_token},
                success : function(data) {
                    table.ajax.reload();
                    swal({
                        title: 'Success!',
                        text: data.message,
                        type: 'success',
                        timer: '1500'
                    })
                },
                error : function () {
                    swal({
                        title: 'Oops...',
                        text: data.message,
                        type: 'error',
                        timer: '1500'
                    })
                }
            });
        });
        }
    $(function(){
            $('#modal-default form').validator().on('submit', function (e) {

                var form =  $('#modal-default form');
                form.find('.help-block').remove();
                form.find('.form-group').removeClass('has-error');

                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('products') }}";
                    else url = "{{ url('products') . '/' }}" + id;

                    $.ajax({
                        url : url,
                        type : "POST",
                        // data : $('#modal-default form').serialize(),
                        data: new FormData($("#modal-default form")[0]),
                        contentType: false,
                        processData: false,
                        success : function(data) {
                            $('#modal-default').modal('hide');
                            table.ajax.reload();
                            swal({
                                title: 'Success!',
                                text: data.message,
                                type: 'success',
                                timer: '1500'
                            })
                        },
                        error : function(xhr){
                            var res = xhr.responseJSON;
                            if($.isEmptyObject(res) == false){
                                $.each(res.errors, function(key, value){
                                    $('#' + key)
                                        .closest('.form-group')
                                        .addClass('has-error')
                                        .append('<span class="help-block"><strong>'+ value +'</strong></span>')
                                });
                            }
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
