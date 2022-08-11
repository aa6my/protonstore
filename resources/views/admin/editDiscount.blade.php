

@extends('layouts.backend')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'previousOrder' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/proton.png') }}@endsection

<!-- GOT TIME DEN SLOWLY MAKE IT NAISER YA -->
@section('content')
<section class="min-vh-100 flex-center py-5">
    <div class="container">
        <h2 class="d-flex justify-content-center mt-5 mb-3">Discount 
            <span class="ps-3 fw-bold fst-italic">{{ $discount->discountCode }}</span>
        </h2>
        <form action="{{ route('discountUpdate', $discount->id) }}" method="post">
        @csrf
        <div class="mb-3">
            <label for="discountCode" class="form-label">Discount Code</label>
            <input type="text" class="form-control @error('discountCode') is-invalid @enderror" id="discountCode" 
                name="discountCode" value="{{ old('discountCode') ? old('discountCode') : $discount->discountCode }}">
            <div id="emailHelp" class="form-text">Tip: Discount code should be unique and have a meaningful name.</div>
            @error('discountCode')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="percentage" class="form-label">Discount Percentage (%)</label>
            <input type="number" class="form-control @error('percentage') is-invalid @enderror" id="percentage" 
                name="percentage" min="1" max="100" value="{{ old('percentage') ? old('percentage') : $discount->percentage }}">
            @error('percentage')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="minSpend" class="form-label">Minimum Spend ($)</label>
            <input type="number" class="form-control @error('minSpend') is-invalid @enderror" id="minSpend" 
                name="minSpend" step=".01" value="{{ old('minSpend') ? old('minSpend') : $discount->minSpend }}">
            @error('minSpend')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="cap" class="form-label">Cap At ($)</label>
            <input type="number" class="form-control @error('cap') is-invalid @enderror" id="cap" name="cap" 
                min="0" max="999" step=".01" value="{{ old('cap') ?  old('cap') : $discount->cap }}">
            @error('cap')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="startDate" class="form-label pe-5">Start Date</label>
            <input type="date" class="form-control @error('cap') is-invalid @enderror" name="startDate" 
                value="{{ old('startDate') ? old('startDate') : $discount->startDate }}"> 
            @error('startDate')
                <span class="invalid-feedback"  style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="endDate" class="form-label pe-5">End Date</label>
            <input type="date" class="form-control @error('cap') is-invalid @enderror" 
                name="endDate" value="{{ old('endDate') ? old('endDate') : $discount->endDate }}">
            @error('endDate')
                <span class="invalid-feedback" style="display:block" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" name="description"
            style="height: 100px;">{{ old('description') ? old('description') : $discount->description }}
            </textarea>
            @error('description')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <button type="submit" class="primary-btn w-100">Update</button>
    </form>
        
        <form class="mt-3" action="{{ route('discountDestroy', $discount->id) }}" method="post">
            @csrf
            @method('DELETE')
            <button type="submit" class="primary-btn w-100">Delete</button>
        </form>
    </div>
</section>
@endsection