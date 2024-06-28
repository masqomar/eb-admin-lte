@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <h1 class="card-header text-center">{{ __('Form Pendaftaran') }}</h1>

                <div class="card-body">
                    <form action="{{ route('coupon', $program->id) }}" method="POST" id="form1">
                        @csrf
                    </form>
                    <form method="POST" action="{{ route('store') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Nama Lengkap') }}</label>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>
                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="phone_number" class="col-md-4 col-form-label text-md-end">{{ __('No HP') }}</label>
                            <div class="col-md-6">
                                <input id="phone_number" type="number" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" required autocomplete="phone_number">
                                <span class="text-muted"><small>WA aktif untuk aktivasi dan pembayaran</small></span>
                                @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Jenis Kelamin') }}</label>
                            <div class="col-md-6">
                                <select name="gender" id="gender" class="form-control" required>
                                    <option value="">Jenis Kelamin</option>
                                    <option value="M">Laki-laki</option>
                                    <option value="F">Perempuan</option>
                                </select>
                                @error('gender')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="address" class="col-md-4 col-form-label text-md-end">{{ __('Alamat') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control form-control-lg" name="address" value="{{ old('address') }}" required></textarea>
                                @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="program_id" class="col-md-4 col-form-label text-md-end">{{ __('Paket Program') }}</label>
                            <div class="col-md-6">
                                <input type="hidden" id="program_id" name="program_id" class="form-control " value="{{ $program->id }}" readonly />
                                <input type="text" id="program_name" name="program_name" class="form-control " value="{{ $program->name }}" readonly />
                                @error('program_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="program_date" class="col-md-4 col-form-label text-md-end">{{ __('Tanggal Kursus') }}</label>
                            <div class="col-md-6">
                                <input id="program_date" type="date" class="form-control @error('program_date') is-invalid @enderror" name="program_date" value="{{ old('program_date') }}" required>
                                @error('program_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="program_time" class="col-md-4 col-form-label text-md-end">{{ __('Jam Belajar') }}</label>
                            <div class="col-md-6">
                                <input id="program_time" type="time" class="form-control @error('program_time') is-invalid @enderror" name="program_time" value="{{ old('program_time') }}" required>
                                @error('program_time')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="note" class="col-md-4 col-form-label text-md-end">{{ __('Catatan') }}</label>
                            <div class="col-md-6">
                                <textarea class="form-control form-control-lg" name="note" value="{{ old('note') }}"></textarea>
                                @error('note')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div class="form-group mb-2">
                            <label>Punya kupon diskon?</label>
                            <div class="input-group">
                                <input type="hidden" name="program_id" value="{{$program->id}}" form="form1">
                                <input type="text" class="form-control coupon" name="coupon_code" placeholder="Kupon diskon" form="form1">
                                <span class="input-group-append">
                                    <input type="submit" class="form-control bg-primary text-white" form="form1" value="Klaim">
                                </span>
                            </div>
                            @if ($message = Session::get('success'))
                            <div class="alert alert-success alert-block">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>
                            @endif
                            @if ($message = Session::get('error'))
                            <div class="alert alert-danger">
                                <strong>{{ $message }}</strong>
                                <button type="button" class="close" data-dismiss="alert">×</button>
                            </div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between">
                            <p class="mb-2"><strong>Biaya</strong></p>
                            <p class="mb-2"><strong>Rp. {{ number_format($program->price) }}</strong></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-2"><strong>Biaya Admin</strong></p>
                            <p class="mb-2"><strong>-</strong></p>
                        </div>

                        <div class="d-flex justify-content-between">
                            <p class="mb-2"><strong>Diskon</strong></p>
                            @if ($diskon = Session::get('couponAmount'))
                            <p class="mb-2"><strong>Rp. {{ number_format($diskon) }}</strong></p>
                            @else
                            <p class="mb-2"><strong>-</strong></p>
                            @endif
                        </div>
                        @if ($couponId = Session::get('couponId'))
                        <input type="hidden" name="coupon_id" value="{{ $couponId }}">
                        @endif

                        <div class="d-flex justify-content-between mb-4">
                            <p class="mb-2"><strong>Total Biaya</strong></p>
                            <p class="mb-2"><strong>Rp. {{ number_format($program->price - $diskon) }}</strong></p>
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Daftar Sekarang!') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection