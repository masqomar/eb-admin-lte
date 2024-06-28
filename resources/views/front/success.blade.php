@extends('layouts.app')

@section('content')
<section class="py-3 py-md-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-9 col-xl-8 col-xxl-7">
                <div class="row gy-3 mb-3">
                    <div class="col-6">
                        <h2 class="text-uppercase text-endx m-0">Invoice</h2>
                    </div>
                    <div class="col-6">
                        <a class="d-block text-end" href="#!">
                            <img src="https://kampunginggrisbooster.com/wp-content/uploads/elementor/thumbs/English-Booster-Logo-Website-qouz8sj1l3ikqq1dx8ohxgijxsg32bzj40tbz9p98g.png" class="img-fluid" alt="English Booster Logo" width="135" height="44">
                        </a>
                    </div>
                    <div class="col-12">
                        <h4>From</h4>
                        <address>
                            <strong>English Booster</strong><br>
                            Kampung Inggris<br>
                            Jl. Asparaga No. 83, Tegalsari<br>
                            Tulungrejo, Pare, Kediri<br>
                            Phone: 0822 3105 0500<br>
                            Email: kampunginggrisbooster@gmail.com
                        </address>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12 col-sm-6 col-md-8">
                        <h4>Bill To</h4>
                        <address>
                            <strong>{{ $transaction->user->name }}</strong><br>
                            {{ $transaction->user->student->address }}<br>
                            Phone: {{ $transaction->user->student->phone_number }}<br>
                            Email: {{ $transaction->user->email }}
                        </address>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4">
                        <h4 class="row">
                            <span class="col-6">Invoice #</span>
                            <span class="col-6 text-sm-end">{{ $transaction->code }}</span>
                        </h4>
                        <div class="row">
                            <span class="col-6">Code Reff</span>
                            <span class="col-6 text-sm-end">#{{ $transaction->invoice }}</span>
                            <span class="col-6">Order Date</span>
                            <span class="col-6 text-sm-end">{{ $transaction->created_at }}</span>
                            <span class="col-6">Invoice Date</span>
                            <span class="col-6 text-sm-end">{{ $transaction->updated_at }}</span>
                            <span class="col-6">Invoice Status</span>
                            @if ($transaction->transaction_status == 'pending')
                            <span class="col-6 text-sm-end bg-info text-white">{{ $transaction->transaction_status }}</span>
                            @elseif ($transaction->transaction_status == 'paid')                            
                            <span class="col-6 text-sm-end bg-succes text-white">{{ $transaction->transaction_status }}</span>
                            @elseif ($transaction->transaction_status == 'failed')                            
                            <span class="col-6 text-sm-end bg-danger text-white">{{ $transaction->transaction_status }}</span>
                            @else
                            <span class="col-6 text-sm-end bg-warning text-white">{{ $transaction->transaction_status }}</span>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-uppercase">Qty</th>
                                        <th scope="col" class="text-uppercase">Program</th>
                                        <th scope="col" class="text-uppercase text-end">Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody class="table-group-divider">
                                    <tr>
                                        <th scope="row">1</th>
                                        <td>{{ $transaction->program->name }}</td>
                                        <td class="text-end">Rp. {{ number_format($transaction->program->price) }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row" colspan="2" class="text-uppercase text-end">Total</th>
                                        <td class="text-end">Rp. {{ number_format($transaction->program->price) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary mb-3">Download Invoice</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection