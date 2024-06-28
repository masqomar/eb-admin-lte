@extends('layouts.app')

@section('content')
<section>
    <div class="container py-5">
        @foreach ($programTypes as $programType)
        @foreach ($programType->program as $program)
        @if ($program->is_active == 1)
        <div class="row justify-content-center mb-3">
            <div class="col-md-12 col-xl-10">
                <div class="card shadow-0 border rounded-3">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">
                                <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                    <img src="{{ asset('storage/upload_files/img/'.$program->image) }}" class="w-100" />
                                    <a href="#!">
                                        <div class="hover-overlay">
                                            <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-xl-6">
                                <h5><strong>{{ $program->name }}</strong></h5>
                                <div class="d-flex flex-row">                                    
                                    <span></span>
                                </div>
                                <div class="mt-1 mb-0 text-muted small">
                                    <span></span>
                                    <span class="text-primary"></span>
                                    <span></span>
                                    <span class="text-primary"></span>
                                    <span><br /></span>
                                </div>
                                <div class="mb-2 text-muted small">
                                    <span></span>
                                    <span class="text-primary"></span>
                                    <span></span>
                                    <span class="text-primary"></span>
                                    <span><br /></span>
                                </div>
                                <p class="text-truncate mb-4 mb-md-0">
                                Tempat kursus bahasa Inggris paling cocok buat kamu.
                                </p>
                            </div>
                            <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                                <div class="d-flex flex-row align-items-center mb-1">
                                    <h4 class="mb-1 me-1">Rp. {{ number_format($program->price) }}</h4>
                                    <span class="text-danger"><s>Rp. {{ number_format($program->price + ($program->price*20/100)) }}</s></span>
                                </div>
                                @if ($programType->name == "Program Private")
                                <h6 class="text-danger">{{ $programType->name }}</h6>
                                @elseif ($programType->name == "Program Semi Private")
                                <h6 class="text-info">{{ $programType->name }}</h6>
                                @else
                                <h6 class="text-success">{{ $programType->name }}</h6>
                                @endif
                                <div class="d-flex flex-column mt-4">
                                    <a href="{{ url('detail/' . $program->id) }}" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-sm">Details</a>
                                    <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-primary btn-sm mt-2" type="button">
                                        Konsultasi
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endforeach
        @endforeach
    </div>
</section>
@endsection