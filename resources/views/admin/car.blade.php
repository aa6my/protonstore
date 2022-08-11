 @extends(( !Auth::check() || auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

 @section('links')
 <link href="{{ asset('css/car.css') }}" rel="stylesheet">
 @endsection
 
 @section('bodyID')
 {{ 'car' }}@endsection
 
 @section('navTheme')
 {{ 'light' }}@endsection
 
 @section('logoFileName')
 {{ URL::asset('/images/protonsquare.png') }}@endsection
 
 
 @section('content')
 <section class="car" style="margin-top: 17vh;">
     <div class="container">
         <a href={{"./filter?carType="}} class="car-title">
             <h2 class="d-flex justify-content-center car-title">CAR</h2>
         </a>
         @if (session('success'))
         <div class="alert alert-success fixed-bottom" role="alert" style="width:500px;left:30px;bottom:20px">
             {{ session('success') }}
         </div>
         @endif
 
         <div class="row car-bar">
         @if (Auth::check() && auth()->user()->role == 'admin')
             <div class="col-md-1 d-flex align-items-center">
                 <div class="dropstart">    
                     <button type="button" class="btn btn-success" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" id="filter-button">
                         <i class="fa fa-plus" aria-hidden="true"></i></i>
                     </button>
                     <div class="dropdown-menu">    
                         <form method='post' action="{{ route('saveCarItem') }}" enctype="multipart/form-data" class="px-4 py-3" style="min-width: 350px">
                             @csrf
                             <div class="mb-2">
                                 <label for="formFile" class="form-label">Car Image</label>
                                 <input name="carImage" class="form-control" type="file" id="item-image" required>
                             </div>
                             
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-2">
                                 <label for="ItemType" class="form-label">Car Type</label>
                                 <div class="input-group mb-3">
                                     <label class="input-group-text" for="itemTypeInputGroup">Type:</label>
                                     <select name="carType" class="form-select" id="itemTypeInputGroup" >
                                         <option name="carType" value="suv">SUV</option>
                                         <option name="carType" value="sedan">Sedan</option>
                                     </select>
                                 </div>
                             </div>
                             
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-1">
                                 <label for="ItemName" class="form-label">Car Name</label>
                                 <div class="input-group mb-3">
                                     <input name="carName" type="text" class="form-control" placeholder="Name" aria-label="Item Name" required>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-1">
                                 <label for="ItemPrice" class="form-label">Car Price</label>
                                 <div class="input-group mb-3">
                                     <span class="input-group-text">$</span>
                                     <input name="carPrice" type="number" min=0 step=0.01 class="form-control price-class" placeholder="Price" aria-label="Item Price" required>
                                     <span class="validity"></span>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-1">
                                 <label for="ItemCost" class="form-label">Car Estimated Cost</label>
                                 <div class="input-group mb-3">
                                     <span class="input-group-text">$</span>
                                     <input name="carEstCost" type="number" min=0 step=0.01 class="form-control price-class" placeholder="Cost" aria-label="Item Cost" >
                                     <span class="validity"></span>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-1">
                                 <label for="ItemDescription" class="form-label">Car Description</label>
                                 <div class="input-group mb-3">
                                     <textarea name="carDescription" class="form-control" placeholder="Description" aria-label="Item Description" required></textarea>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
                             
                             <div class="mb-2">
                                 <label for="ItemSize" class="form-label">Car Capacity</label>
                                 <div class="input-group mb-3">
                                     <label class="input-group-text" for="itemSizeInputGroup">Size:</label>
                                     <select name="carSize" class="form-select" id="itemSizeInputGroup" >
                                         <option name="carSize" value="1-2">1 - 2 People</option>
                                         <option name="carSize" value="3-4">3 - 4 People</option>
                                         <option name="carSize" value=">5">More than 5 People</option>
                                     </select>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-1">
                                 <label for="Variant" class="form-label">Variant</label>
                                 <div class="form-check">
                                     <input name="carNormal" type="hidden" value=0>
                                     <input name='carNormal' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                     <label class="form-check-label" for="dropdownCheck">
                                        Normal
                                     </label>
                                 </div>
                                 <div class="form-check">
                                     <input name="carSpecial" type="hidden" value=0>
                                     <input name='carSpecial' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                     <label class="form-check-label" for="dropdownCheck">
                                     Special
                                     </label>
                                 </div>
                                 <div class="form-check">
                                    <input name="carAdvance" type="hidden" value=0>
                                    <input name='carAdvance' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                    <label class="form-check-label" for="dropdownCheck">
                                    Advance
                                    </label>
                                </div>
                                 
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <button type="submit" class="btn btn-outline-success">Add Item</button>
                         </form>
                     </div>
                 </div>
             </div>
         @endif
         @if (Auth::check() && auth()->user()->role == 'admin')
             <div class="col-md-8 offset-md-1 col-12 text-center car-type my-3">
                 <form method="get" action="{{ route('filterCar') }}">
                     <button type="submit" name="carType" value="" class="btn btn-light car-type-button">All</button>
                     <button type="submit" name="carType" value="suv" class="btn btn-light car-type-button">SUV</button>
                     <button type="submit" name="carType" value="sedan" class="btn btn-light car-type-button">Sedan</button>
                 </form>
             </div>
         @else
             <div class="col-md-8 offset-md-2 col-12 text-center car-type my-3">
                 <form method="get" action="{{ route('filterCar') }}">
                    <button type="submit" name="carType" value="" class="btn btn-light car-type-button">All</button>
                    <button type="submit" name="carType" value="suv" class="btn btn-light car-type-button">SUV</button>
                    <button type="submit" name="carType" value="sedan" class="btn btn-light car-type-button">SEDAN</button>
                 </form>
             </div>
         @endif
             <div class="col-md-2 d-flex align-items-center">
                 <div class="dropstart w-100 d-flex justify-content-end">    
                     <button type="button" class="btn btn-dark" data-bs-toggle="dropdown" aria-expanded="false" data-bs-auto-close="outside" id="filter-button">Filter <i class="fa fa-filter" aria-hidden="true"></i></button>
                     <div class="dropdown-menu">
                         <form method="get" action="{{ route('filterCar') }}" class="px-4 py-3 " style="min-width: 350px">    
                             <div class="mb-2">
                                 <label for="ItemType" class="form-label">Car Type</label>
                                 <div class="input-group mb-3">
                                     <label class="input-group-text" for="itemTypeInputGroup">Type:</label>
                                     <select name="carType" class="form-select" id="itemTypeInputGroup" >
                                         <option name="carType" value="">All</option>
                                         <option name="carType" value="suv">SUV</option>
                                         <option name="carType" value="sedan">SEDAN</option>
                                     </select>
                                 </div>
                             </div>
                             
                             <div class="dropdown-divider"></div>
                         
                             <div class="col-12 mb-3">
                                 <label for="PriceRange" class="form-label">Price range</label>
                                 <div class="input-group mb-3">
                                     <span class="input-group-text">$</span>
                                     <input name="fromPrice" type="text" class="form-control" placeholder="From Price" aria-label="From Price">
                                     <span class="input-group-text">~</span>
                                     <input name="toPrice" type="text" class="form-control" placeholder="To Price" aria-label="To Price">
                                 </div>
                             </div>
                             
                             <div class="dropdown-divider"></div>
                             
 
                             <div class="mb-2">
                                 <label for="ItemSize" class="form-label">Car Capacity</label>
                                 <div class="input-group mb-3">
                                     <label class="input-group-text" for="itemSizeInputGroup">Size:</label>
                                     <select name="carSize" class="form-select" id="itemSizeInputGroup" >
                                         <option name="carSize" value="">All</option>
                                         <option name="carSize" value="1-2">1 - 2 People</option>
                                         <option name="carSize" value="3-4">3 - 4 People</option>
                                         <option name="carSize" value=">5">More than 5 People</option>
                                     </select>
                                 </div>
                             </div>
 
                             <div class="dropdown-divider"></div>
 
                             <div class="mb-3">
                               <label for="SpecialCondition" class="form-label">Variant</label>
                               <div class="form-check">
                                <input name="carNormal" type="hidden" value=0>
                                <input name='carNormal' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                <label class="form-check-label" for="dropdownCheck">
                                   Normal
                                </label>
                            </div>
                            <div class="form-check">
                                <input name="carSpecial" type="hidden" value=0>
                                <input name='carSpecial' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                                <label class="form-check-label" for="dropdownCheck">
                                Special
                                </label>
                            </div>
                            <div class="form-check">
                               <input name="carDrinks" type="hidden" value=0>
                               <input name='carDrinks' value=1 type="checkbox" class="form-check-input" id="dropdownCheck">
                               <label class="form-check-label" for="dropdownCheck">
                               Drinks
                               </label>
                           </div>
                                 
                             </div>
 
                             <div class="dropdown-divider"></div>
                             <button type="submit" class="btn btn-outline-dark">Filter</button>
                         </form>
                     </div>
                 </div>
             </div>
         </div>
         
         
 
 
         <div class="d-flex flex-wrap mt-4 mb-5">
         @forelse ($cars as $car)
             
             <div class="card col-md-3 col-6 d-flex align-items-center">
                 <div class="card-body w-100">
                     <form class="d-flex flex-column justify-content-between h-100" action="{{ route('addToCart') }}" method="post">
                         @csrf
                         <div class="flex-center">
                             <img class="card-img-top carImage" src="{{ asset('carImages/' . $car->image) }}">
                         </div>
 
                         <h5 class="card-title mt-3">
                             {{ $car->name }} 
                         </h5>
                         
                         <h6 class="card-subtitle mb-2 text-muted">{{ $car->description }}</h6>
                         <h6 class="card-subtitle mb-2 text-muted">For {{ $car->size }} people</h6>
                         
                         <div class="d-flex justify-content-between">
                             <p class="card-text fs-5 fw-bold">$ {{ number_format($car->price, 2) }}</p>
                             <h6 class="card-text flex-center">
                                 @if($car->allergic)
                                 <i class="fa fa-exclamation-circle allergic-alert" aria-hidden="true" data-bs-toggle="tooltip" title="Allergic Warning"></i>
                                 @endif
 
                                 @if($car->vegan)
                                 <i class="fa fa-tree" aria-hidden="true" data-bs-toggle="tooltip" title="Vegan Friendly"></i>
                                 @elseif($car->vegetarian)
                                 <i class="fa fa-leaf" aria-hidden="true" data-bs-toggle="tooltip" title="Vegetarian Friendly"></i>
                                 @endif
                             </h6>
                         </div>
 
                         <input name="carID" type="hidden" value="{{ $car->id }}">
                         <input name="carName" type="hidden" value="{{ $car->name }}">
                         @if (Auth::check())
                             @if (auth()->user()->role == 'customer')
                                 <button type="submit" class="primary-btn w-100 mt-3">Add to Cart</button>
                             @elseif (auth()->user()->role == 'admin')
                                 <div class="dropdown w-100 mt-3">
                                     <a href="#" role="button" id="dropdownCarLink" 
                                         data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                                         <button class="primary-btn w-100">Edit</button>
                                     </a>
 
                                     <ul class="dropdown-menu" aria-labelledby="dropdownCarLink">
                                         <li><a class="dropdown-item" href={{"./editCarImages/".$car['id']}}>Edit Images</a></li>
                                         <li><a class="dropdown-item" href={{"./editCarDetails/".$car['id']}}>Edit Details</a></li>
                                         <li><a class="dropdown-item" href={{"./delete/".$car['id']}}>Delete</a></li>
                                     </ul>
                                 </div>
                             @endif
                         @endif
                     </form>
                 </div>
             </div>
         
         @empty
         <div class="row">
             <div class="col-12">
                 <h1>No result found... <i class="fa fa-frown-o" aria-hidden="true"></i></h1>
             </div>
         </div>
         @endforelse
         </div>
     </div>
 </section>
 @endsection