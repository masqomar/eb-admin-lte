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
                        <li class="breadcrumb-item"><a href="{{ route('transactions.index') }}">Transactions</a></li>
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
                        <div class="card-header">
                            <h4 class="card-title">Detail Transaksi</h4>
                        </div>
                        <div class="card-body">

                            <form class="form-horizontal" action="{{ route('transactions.updateStatus') }}" method="POST">
                                @csrf
                                @method('PUT')
                                <table>
                                    <tr>
                                        <th>Nama</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>No Hp</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->user->student->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <th>JK</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->user->student->gender }}</td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->user->student->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>Program</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->program->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Akses Token</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->voucher_token }}</td>
                                    </tr>
                                    <tr>
                                        <th>Tanggal</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->program_date }}</td>
                                    </tr>
                                    <tr>
                                        <th>Jam</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->program_time }} WIB</td>
                                    </tr>
                                    <tr>
                                        <th>Biaya</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>Rp. {{ number_format($transaction->program->price) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Diskon</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>Rp. {{ number_format( $transaction->discount ? $transaction->discount : 0 ) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Bayar</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>Rp. {{ number_format($transaction->total_purchases - $transaction->discount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Maksimal</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{{ $transaction->maximum_payment_time }}</td>
                                    </tr>
                                    <tr>
                                        <th>Catatan</th>
                                        <td>&nbsp; : &nbsp;</td>
                                        <td>{!! $transaction->note ? $transaction->note : '-' !!}</td>
                                    </tr>
                                </table>

                                <hr>
                                <input type="hidden" value="{{ $transaction->id}}" name="transaction_id">
                                <input type="hidden" value="{{ $transaction->user->id}}" name="user_id">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Status Pembayaran</label>
                                    <div class="col-sm-10">
                                        <select name="status" class="form-control">
                                            <option value="pending" @selected(old('$transaction->transaction_status') ?? $transaction->transaction_status == 'pending')>Pending</option>
                                            <option value="paid" @selected(old('$transaction->transaction_status') ?? $transaction->transaction_status == 'paid')>Lunas</option>
                                            <option value="failed" @selected(old('$transaction->transaction_status') ?? $transaction->transaction_status == 'failed')>Gagal</option>
                                            <option value="done" @selected(old('$transaction->transaction_status') ?? $transaction->transaction_status == 'done')>Terverifikasi</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Akses App ?</label>
                                    <div class="col-sm-10">
                                        <select name="is_active" class="form-control">
                                            <option value="1" @selected(old('$transaction->user->is_active') ?? $transaction->user->is_active == 1)>Aktif</option>
                                            <option value="0" @selected(old('$transaction->user->is_active') ?? $transaction->user->is_active == 0)>Tidak Aktif</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Akses CBT ?</label>
                                    <div class="col-sm-10">
                                        <select name="is_member" class="form-control">
                                            <option value="1" @selected(old('$transaction->user->student->is_member') ?? $transaction->user->student->is_member == 1)>Aktif</option>
                                            <option value="0" @selected(old('$transaction->user->student->is_member') ?? $transaction->user->student->is_member == 0)>Tidak Aktif</option>
                                        </select>

                                    </div>
                                </div>

                                <div class="form-group row">
                                    <div class="offset-sm-2 col-sm-10">
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                        <a href="{{ route('transactions.index') }}" class="btn btn-info">Kembali</a>
                                    </div>
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