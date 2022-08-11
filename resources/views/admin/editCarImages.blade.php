
@extends(( auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

@section('links')
<link href="{{ asset('css/car.css') }}" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
@endsection

@section('bodyID')
{{ 'car' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL('http://127.0.0.1:8000/images/protonsquare.png') }}@endsection

@section('content')
<div class="flex-center min-vh-100">
<form method='post' action="{{ route('updateCarImages') }}" enctype="multipart/form-data" class="px-4 py-3" style="min-width: 350px">
    @csrf
    <input name="carID" type="hidden" value="{{ $car['id'] }}">

    <div class="mb-2">
        <label for="formFile" class="form-label">Car Image (Only png, jpg, jpeg) Max Size: 10MB</label>
        <input name="carImage" class="form-control" type="file" id="item-image" required>
    </div>
    
    <div class="dropdown-divider"></div>

    <div class="row">
        <div>
            <button type="submit" class="btn btn-outline-success">Save Changes</button>
            <a href={{ url()->previous() }}><button type="button" class="btn btn-outline-danger">Back</button></a>
        </div>
    </div>
</form>
</div>
@endsection