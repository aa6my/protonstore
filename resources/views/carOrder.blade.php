@extends(( auth()->user()->role == 'customer' ) ? 'layouts.app' : 'layouts.backend' )

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'carOrder' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/protonsquare.png') }}@endsection


@section('content')
@if (!$firstOrder)
<!-- no active orders -->
<section class="empty-order min-vh-100 flex-center pt-5">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">No Orders Yet.</h3>
        <p class="text-muted">No customers with unfulfilled orders for now...</p>
        <div class="d-flex mt-3">
            <a href="{{ route('previousOrder') }}" class="primary-btn mx-3">Previous Orders</a>
            <a href="{{ route('dashboard') }}" class="primary-btn mx-3">View Dashboard</a>
        </div>
    </div>
</section>
@else
<!-- todo - session success stuff -->
<section class="first-order d-flex">
    <div class="container">
        <div class="order-metadata mb-4">
            <div class="d-flex">
                <h2>ORDER #{{ $firstOrder->id }}</h2>
                @if ($firstOrder->completed)
                <div class="mx-5 px-3 alert alert-success">
                    Fulfilled
                </div>
                @else
                <div class="mx-5 px-3 alert alert-warning">
                    Not fulfilled
                </div>
                @endif
            </div>
            <div class="d-flex">
                <p class="text-muted">{{ $firstOrder->getOrderDate() }}</p>
                <p class="px-3 text-muted">{{ $firstOrder->getOrderTime() }}</p>
            </div>
        </div>

        <div class="order-cart p-4 mb-5">
            <h3 class="pb-4 px-2">Customer's cart</h3>
            <div class="flex-center flex-column order-cart-items">
            @foreach ($firstOrder->cartItems as $orderItem)
                <div class="order-cart-item d-flex justify-content-around">
                    <div class="car-img-wrapper">
                        <img src="{{ asset('carImages/' . $orderItem->car->image) }}" class="order-car">                      
                    </div>
                    <div class="car-desc-wrapper">
                        <div class="d-flex justify-content-between">
                            <h5>{{ $orderItem->car->name }}</h5>
                            <div class="car-status-wrapper">
                            @if ($orderItem->fulfilled)
                                <form action="{{ route('orderStatusUpdate', $orderItem->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="primary-btn px-3 unfulfill">Unfulfill</button>
                                </form>
                            @else
                                <form action="{{ route('orderStatusUpdate', $orderItem->id) }}" method="post">
                                    @csrf
                                    @method('PUT')
                                    <button class="primary-btn px-3 fulfill">Fulfill</button>
                                </form>                                
                            @endif
                            </div>
                        </div>
                        <div class="mobile d-flex pt-2">
                            <p class="price">{{ number_format($orderItem->car->price, 2) }}</p>
                            <p class="quantity">x{{ $orderItem->quantity }}</p>
                            <p class="cart-item-total">RM {{ number_format($orderItem->car->price * $orderItem->quantity, 2) }}</p>        
                        </div>
                        <p class="text-muted desktop w-75">{{ $orderItem->car->description }}</p>
                    </div>
                    <p>{{ $orderItem->user->username }}</p>
                    <p>{{ $orderItem->user->phone }}</p>
                    <p>{{ $orderItem->user->age }}</p>
                    <p class="price desktop">RM {{ number_format($orderItem->car->price, 2) }}</p>
                    <p class="quantity desktop">x{{ $orderItem->quantity }}</p>
                    <p class="cart-item-total desktop">RM {{ number_format($orderItem->car->price * $orderItem->quantity, 2) }}</p>
                </div>
                <hr>
            @endforeach
            </div>
        </div>

        @if (!$activeOrders->count())
        <div class="d-flex justify-content-center">
            <a href="{{ route('previousOrder') }}" class="primary-btn">Previous Orders</a>
        </div>
        @endif

    </div>
</section>
@endif

@if ($activeOrders->count())
<section class="kitchen-active-orders">
    <div class="container">
        <h2 class="mb-4">Active Orders</h2>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Order ID</th>
                    <th scope="col">Date</th>
                    <th scope="col">Time</th>
                    <th scope="col">Final Price</th>
                    <th scope="col">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($activeOrders as $order)
                    @if ($firstOrder->id == $order->id)
                    <tr class="table-active">
                    @else
                    <tr>
                    @endif
                        <th scope="row"><a href="{{ route('specificOrder', $order->id) }}">#{{ $order->id }}</a></th>
                        <td>{{ $order->getOrderDate() }}</td>
                        <td>{{ $order->getOrderTime() }}</td>
                        <td>RM {{ $order->getTotalFromScratch() }}</td>
                        <td>
                            @if ($order->completed)
                                <div class="px-3 alert alert-success">
                                    Fulfilled
                                </div>  
                            @else
                                <div class="px-3 alert alert-warning">
                                    Not fulfilled
                                </div>  
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-5 d-flex justify-content-between">
            <a href="{{ route('previousOrder') }}" class="primary-btn">Previous Orders</a>
            {{ $activeOrders->links() }}
        </div>
    </div>
</section>
@endif
@endsection