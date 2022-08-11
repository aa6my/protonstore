

@extends('layouts.backend')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'previousOrder' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/protonsquare.png') }}@endsection


@section('content')
@if (!$discounts->count())
<!-- no previous orders -->
<section class="empty-order min-vh-100 flex-center pt-5">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">No Discount Vouchers Yet.</h3>
        <p class="text-muted">There seems to be no discount vouchers for now...</p>
        <div class="d-flex mt-3">
            <a href="{{ route('createDiscount') }}" class="primary-btn mx-3">Create Discount</a>
        </div>
    </div>
</section>
@else
<section class="min-vh-100 d-flex align-items-start mt-5 pt-18vh">
    <div class="container">
        <div class="d-flex justify-content-between">
        <h2 class="mb-4">Discount Codes</h2>
        <a href="{{ route('createDiscount') }}" class="primary-btn">+ Create Discount</a>
        </div>
        @if (session('success'))
            <div class="alert alert-success" role="alert">
                {{ session('success') }}
            </div>
        @endif
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Code</th>
                    <th scope="col">Percentage</th>
                    <th scope="col">Min Spend</th>
                    <th scope="col">Cap</th>
                    <th scope="col">Start Date</th>
                    <th scope="col">End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($discounts as $discount)
                    <tr>
                        <th scope="row"><a href="{{ route('specificDiscount', $discount->id) }}">
                            {{ $discount->discountCode }} </a></th>
                        <td>{{ $discount->percentage }}%</td>
                        <td>${{ number_format($discount->minSpend, 2) }}</td>
                        <td>${{ number_format($discount->cap, 2) }}</td>
                        <td>{{ $discount->startDate }}</td>
                        <td>{{ $discount->endDate }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
    </div>
</section>
@endif
@endsection