@extends('admin.layouts.master')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $title }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        @can('create transactions')
                        <div class="card-header">
                            <h3 class="card-title">
                                <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#modal-tambah" data-backdrop="static" data-keyboard="false"><i class="fas fa-plus"></i> Tambah</a>
                            </h3>
                        </div>
                        @endcan
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table class="table table-bordered table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama</th>
                                        <th>Program</th>
                                        <th>Biaya</th>
                                        <th>Diskon</th>
                                        <th>Invoice</th>
                                        <th>Kode Midtrans</th>
                                        <th>Status</th>
                                        @canany(['update transactions', 'delete transactions'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $i)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $i->user->name }}</td>
                                        <td>{{ $i->program_id == null ? '-' : $i->program->name }}</td>
                                        <td>Rp. {{ number_format($i->total_purchases) }}</td>
                                        <td>{{ $i->discount ? $i->discount : '-' }}</td>
                                        <td>{{ $i->code }}</td>
                                        <td>{{ $i->invoice }}<br />{{ $i->snap_token }}</td>
                                        <td>{{ $i->transaction_status }}</td>
                                        @canany(['update transactions', 'delete transactions'])
                                        <td>
                                            <div class="btn-group">
                                                @can('update transactions')
                                                <button class="btn btn-sm btn-primary btn-edit" data-id="{{ $i->id }}"><i class="fas fa-pencil-alt"></i></button>
                                                <a class="btn btn-sm btn-success btn-edit" href="{{ route('transactions.detail', $i->id) }}"><i class="fas fa-eye"></i></a>
                                                @endcan
                                                @can('delete transactions')
                                                <button class="btn btn-sm btn-danger btn-delete" data-id="{{ $i->id }}" data-name="{{ $i->name }}"><i class="fas fa-trash"></i></button>
                                                @endcan
                                            </div>
                                        </td>
                                        @endcanany
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
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

@section('js')
<script>
    $(document).ready(function() {
        $(document).on("click", '.btn-edit', function() {
            let id = $(this).attr("data-id");
            $('#modal-loading').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
            $.ajax({
                url: "{{ route('transactions.show') }}",
                type: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                success: function(data) {
                    var data = data.data;
                    $("#name").val(data.name);
                    $("#id").val(data.id);
                    $('#modal-loading').modal('hide');
                    $('#modal-edit').modal({
                        backdrop: 'static',
                        keyboard: false,
                        show: true
                    });
                },
            });
        });

        $(document).on("click", '.btn-delete', function() {
            let id = $(this).attr("data-id");
            let name = $(this).attr("data-name");
            $("#did").val(id);
            $("#delete-data").html(name);
            $('#modal-delete').modal({
                backdrop: 'static',
                keyboard: false,
                show: true
            });
        });
    });
</script>
@endsection

@section('modal')
{{-- Modal tambah --}}
<div class="modal fade" id="modal-tambah">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- Modal Update --}}
<div class="modal fade" id="modal-edit">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method("PUT")
                    <div class="input-group">
                        <label>Name</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="Name" name="name" id="name" value="{{ old('name') }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
            </div>
            <div class="modal-footer justify-content-between">
                <input type="hidden" name="id" id="id">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
{{-- Modal delete --}}
<div class="modal fade" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Hapus Data</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('transactions.destroy') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('DELETE')
                    <p class="modal-text">Apakah anda yakin akan menghapus? <b id="delete-data"></b></p>
                    <input type="hidden" name="id" id="did">
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
@endsection