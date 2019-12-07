@extends('layouts.global')
@section('title')

@endsection
@section('css')

@endsection
@section('content')
<!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
        stocks
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
                    <h4>Category list
                        <a onclick="addForm()" class="btn btn-primary pull-right" style="margin-top: -8px;">Add Category</a>
                    </h4>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="tabel-stocks" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                            <th>Id</th>
                        <th>Nama Ketegori</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    </tbody>
                    <tfoot>
                    <tr>
                            <th>Id</th>
                        <th>Nama Ketegori</th>
                        <th>Gambar</th>
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
            <form role="form" enctype="multipart/form-data" action="{{route('stocks.store')}}" method="POST">
            <div class="modal-body">

                {{ csrf_field() }} {{ method_field('POST') }}
                <input type="hidden" id="id" name="id">
                    <div class="form-group">
                        <label for="name">Nama Produk</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="name">
                    </div>
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="text" class="form-control" id="stock" name="stock" placeholder="stock">
                    </div>
                    <!-- /.card-body -->

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary pull-left" id="submit">Tambah stocks</button>
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
<script type="text/javascript">
    var table = $('#tabel-stocks').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('api.stock') }}",
        columns: [
        {data: 'id', name: 'id'},
        {data: 'nama_produk', name: 'nama_produk'},
        {data: 'stok', name: 'stok'},
        {data: 'action', name: 'action', orderable: false, searchable: false,}
        ]
    });
    function addForm() {
        save_method = "add";
        $('input[name=_method]').val('POST');
        $('#modal-default').modal('show');
        $('#modal-default form')[0].reset();
        $('.modal-title').text('Add stock');
    }

    function editForm(id) {
        save_method = 'edit';
        $('input[name=_method]').val('PATCH');
        $('#modal-default form')[0].reset();
        $('#submit').text('Edit Stock');
        $.ajax({
            url: "{{ url('stocks') }}" + '/' + id + "/edit",
            type: "GET",
            dataType: "JSON",
            success: function(data) {
            $('#modal-default').modal('show');
            $('.modal-title').text('Edit stock');

            $('#id').val(data.id);
            $('#name').val(data.nama_produk);
            $('#name').prop('disabled',true)
            $('#stock').val(data.stok);
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
                url : "{{ url('stocks') }}" + '/' + id,
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
                if (!e.isDefaultPrevented()){
                    var id = $('#id').val();
                    if (save_method == 'add') url = "{{ url('stocks') }}";
                    else url = "{{ url('stocks') . '/' }}" + id;

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
                        error : function(data){
                            swal({
                                title: 'Oops...',
                                text: data.message,
                                type: 'error',
                                timer: '1500'
                            })
                        }
                    });
                    return false;
                }
            });
        });
    </script>
@endsection
