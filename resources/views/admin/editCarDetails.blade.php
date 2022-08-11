

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
<form method='post' action="{{ route('updateCarDetails') }}" class="px-4 py-3" style="min-width: 350px">
    @csrf
    <input name="carID" type="hidden" value="{{ $car['id'] }}">

    <div class="mb-2">
        <label for="ItemType" class="form-label">Car Type</label>
        <div class="input-group mb-3">
            <label class="input-group-text" for="itemTypeInputGroup">Type:</label>
            <select name="carType" class="form-select" id="itemTypeInputGroup" >
                <option selected>{{ $car['type'] }}</option>
                <option name="carType" value="">All</option>
                <option name="carType" value="suv">SUV</option>
                <option name="carType" value="sedan">SEDAN</option>
            </select>
        </div>
    </div>
    
    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemName" class="form-label">Car Name</label>
        <div class="input-group mb-3">
            <input name="carName" type="text" class="form-control" placeholder="Name" aria-label="Item Name" value="{{ $car['name'] }}" required>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemPrice" class="form-label">Car Price</label>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input name="carPrice" type="number" min=0 step=0.01 class="form-control price-class" class="form-control" placeholder="Price" aria-label="Item Price" value="{{ $car['price'] }}" required>
            <span class="validity"></span>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemCost" class="form-label">Car Estimated Cost</label>
        <div class="input-group mb-3">
            <span class="input-group-text">$</span>
            <input name="carEstCost" type="number" min=0 step=0.01 class="form-control price-class" class="form-control" placeholder="Cost" aria-label="Item Cost" value="{{ $car['estCost'] }}" required>
            <span class="validity"></span>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="ItemDescription" class="form-label">Car Description</label>
        <div class="input-group mb-3">
            <textarea name="carDescription" class="form-control" placeholder="Description" aria-label="Item Description" required>{{ $car['description'] }}</textarea>
        </div>
    </div>

    <div class="dropdown-divider"></div>
    
    <div class="mb-2">
        <label for="ItemSize" class="form-label">Car Capacity</label>
        <div class="input-group mb-3">
            <label class="input-group-text" for="itemSizeInputGroup">Size:</label>
            <select name="carSize" class="form-select" id="itemSizeInputGroup">
                <option selected>{{ $car->size }}</option>
                @if($car['size'] == "1-2")
                @else
                    <option name="carSize" value="1-2">1 - 2 People</option>
                @endif
                @if($car['size'] == "3-4")
                @else
                    <option name="carSize" value="3-4">3 - 4 People</option>
                @endif
                @if($car['size'] == ">5")
                @else
                    <option name="carSize" value=">5">>5 People</option>
                @endif
            </select>
        </div>
    </div>

    <div class="dropdown-divider"></div>

    <div class="mb-1">
        <label for="SpecialCondition" class="form-label">Special Condition</label>
        <div class="form-check">
            <input name="carNormal" type="hidden" value=0>

            @if( $car['normal'] == 1)
            <label class="form-check-label active" for="dropdownCheck">
                <input name='carNormal' value=1 type="checkbox" class="form-check-input" id="dropdownCheck" checked="checked">Normal
            </label>
            @else
            <input name='carNormal' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Normal
            </label>
            @endif
        </div>
        <div class="form-check">
            <input name="carSpecial" type="hidden" value=0>

            @if( $car['special'] == 1)
            <label class="form-check-label active" for="dropdownCheck">
                <input name='carSpecial' value=1 type="checkbox" class="form-check-input" id="dropdownCheck" checked="checked">Special
            </label>
            @else
            <input name='carSpecial' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Special
            </label>
            @endif
        </div>
        <div class="form-check">
            <input name="carAdvance" type="hidden" value=0>
        
            @if( $car['advance'] == 1)
            <label class="form-check-label active" for="dropdownCheck">
                <input name='carAdvance' value=1 type="checkbox" class="form-check-input" id="dropdownCheck" checked="checked">Advance
            </label>
            @else
            <input name='carAdvance' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
            <label class="form-check-label" for="dropdownCheck">
            Advance
            </label>
            @endif
        </div>
    </div>

    <div class="dropdown-divider"></div>
    <div class="row">
        <div>
            <button type="submit" class="btn btn-outline-success">Save Changes</button>
            <a href={{ url()->previous() }}><button type="button" class="btn btn-outline-danger">Back</button></a>
        </div>
    </div>
</form>
@endsection