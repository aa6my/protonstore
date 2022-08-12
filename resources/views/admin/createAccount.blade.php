@extends('layouts.backend')

@section('links')
    <link href="{{ asset('css/accountCreation.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'accountCreation' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/protonsquare.png') }}@endsection


@section('content')
<section class="container mt-5 mt-md-0 pt-5 pt-md-0">
    <br>
    @if (session('success'))
    <div class="alert alert-success fixed-bottom" role="alert" style="width:500px;left:30px;bottom:20px">
        {{ session('success') }}
    </div>
    @endif
    <br>
    <div class="row d-flex justify-content-center" id="top-bar">
        <div class="col-md-2" id="title">
            <label>Create Accounts</label>
        </div>
    </div>
    <br>

    <div class="row mt-5">
        <div class="col-10 col-md-8 offset-1 offset-md-2">
            <form method="POST" action="{{ route('accountStoring') }}" id="accountCreationForm">
                @csrf

                <div class="row mb-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Phone') }}</label>

                    <div class="col-md-6">
                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-5">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Age') }}</label>

                    <div class="col-md-6">
                        <input id="age" type="text" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}" required autocomplete="name" autofocus>

                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-5">
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

                <div class="row mb-5">
                    <label for="password" class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-5">
                    <label for="role" class="col-md-4 col-form-label text-md-end">{{ __('Role') }}</label>

                    <div class="col-md-6">
                        <select class="form-select" aria-label="{{ __('Role') }}" name="role">
                            <option value="admin" selected>Admin</option>
                            <option value="kitchenStaff">Kitchen Order</option>
                            <option value="customer">Customer</option>
                        </select>

                        @error('role')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-8 offset-md-2">
                        <button type="submit" class="primary-btn w-100 px-4">Create</button>
                    </div>
                </div>

            </form>
        </div>
    </div>

</section>
@endsection