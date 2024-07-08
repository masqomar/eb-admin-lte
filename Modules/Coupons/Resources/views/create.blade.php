@extends('admin.layouts.master')
@push('style')
<link rel="stylesheet" href="{{ asset('template/admin/plugins/select2/css/select2.min.css') }}">
@endpush
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
                <div class="col-md-12">

                    <div class="card">
                        <div class="card-body">

                            <form action="{{ route('coupons.store') }}" method="post">
                                @csrf
                                @method('POST')

                                <div class="input-group mb-2">
                                    <label>Nama Program</label>
                                    <div class="input-group">
                                        <select class="form-control select2 select2-danger" name="program_id" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            @foreach ($data as $program)
                                            <option value="{{$program->id}}">{{$program->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('program_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-2">
                                    <label>Kode Kupon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="Kode Kupon" name="code" required>
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-2">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Nominal" name="amount" required>
                                        @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label>Jumlah</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('qty') is-invalid @enderror" placeholder="Jumlah" name="qty" required>
                                        @error('qty')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>


                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                    <a href="{{ route('coupons.index') }}" class="btn btn-info">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
@endsection

@push('script')
<script src="{{ asset('template/admin/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
    $(function() {
        //Initialize Select2 Elements
        $('.select2').select2()
    });
</script>
@endpush