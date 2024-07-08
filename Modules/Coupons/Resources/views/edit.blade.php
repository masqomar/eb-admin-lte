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
                        <li class="breadcrumb-item"><a href="{{ route('coupons.index') }}">Kupon</a></li>
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

                            <form action="{{ route('coupons.update', $coupon->id) }}" method="post">
                                @csrf
                                @method('PUT')

                                <input type="hidden" value="{{ $coupon->id }}" name="id">
                                <div class="input-group">
                                    <label>Kode Kupon</label>
                                    <div class="input-group">
                                        <select class="form-control select2 select2-danger" name="program_id" data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option value="{{$coupon->program->id}}" @selected(old('{{$coupon->program->name}}') ?? '-' )>{{$coupon->program->name}}</option>
                                            @foreach ($programs as $program)
                                            <option value="{{$program->id}}">{{$program->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('program_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label>Kode Kupon</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control @error('code') is-invalid @enderror" placeholder="Kode Kupon" name="code" value="{{ $coupon->code }}">
                                        @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group">
                                    <label>Nominal</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('amount') is-invalid @enderror" placeholder="Nominal" name="amount" value="{{ $coupon->amount }}">
                                        @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="input-group mb-3">
                                    <label>Jumlah</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control @error('qty') is-invalid @enderror" placeholder="Jumlah" name="qty" value="{{ $coupon->qty }}">
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