

@extends('layouts.app')

@section('links')
    <link href="{{ asset('css/order.css') }}" rel="stylesheet">
@endsection

@section('bodyID')
{{ 'order' }}@endsection

@section('navTheme')
{{ 'light' }}@endsection

@section('logoFileName')
{{ URL::asset('/images/proton.png') }}@endsection


@section('content')
@if (!$activeOrder && !$allOrders->count())
<!-- when user has not made an order before -->
<section class="empty-order min-vh-100 pt-5 flex-center">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="hero-wrapper">
            <img src="{{ URL::asset('/images/empty_order.svg') }}" alt="">
        </div>
        <h3 class="mt-4 mb-2">No Orders Yet.</h3>
        <p class="text-muted">It seems like you haven't made your choice yet...</p>
        <!-- <a href="{{ route('car') }}"><button class="primary-btn w-100 py-2">See Car</button></a> -->
        <a href="{{ route('car') }}"><button class="primary-btn mt-3">Discover car</button></a>
    </div>
</section>
@elseif ($activeOrder)
<!-- todo - session success stuff -->
<section class="active-order d-flex">
    <div class="container">
        <div class="order-metadata mb-4">
            <div class="d-flex">
                <h2>ORDER #{{ $activeOrder->id }}</h2>
                @if ($activeOrder->completed)
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
                <p class="text-muted">{{ $activeOrder->getOrderDate() }}</p>
                <p class="px-3 text-muted">{{ $activeOrder->getOrderTime() }}</p>
            </div>
        </div>

        <div class="row">
            <div class="order-cart p-4 mb-5 col-lg-8 col-md-12">
                <h3 class="pb-4 px-2">Your cart</h3>
                <div class="flex-center flex-column order-cart-items">
                @foreach ($activeOrder->cartItems as $orderItem)
                    <div class="order-cart-item d-flex justify-content-around">
                        <div class="car-img-wrapper">
                            <img class="order-car shadow" src="{{ asset('carImages/' . $orderItem->car->image) }}">
                        </div>
                        <div class="car-desc-wrapper">
                            <div class="d-flex justify-content-between">

                                <h5>{{ $orderItem->car->name }}</h5>
                                @if ($orderItem->fulfilled)
                                    <div class="px-3 alert alert-success">
                                        Fulfilled
                                    </div>  
                                @else
                                    <div class="px-3 alert alert-warning">
                                        Not fulfilled
                                    </div>  
                                @endif
                            </div>
                            <div class="mobile d-flex pt-2">
                                <p class="price">$ {{ number_format($orderItem->car->price, 2) }}</p>
                                <p class="quantity">x{{ $orderItem->quantity }}</p>
                                <p class="cart-item-total">$ {{ number_format($orderItem->car->price * $orderItem->quantity, 2) }}</p>        
                            </div>
                            <p class="text-muted desktop">{{ $orderItem->car->description }}</p>
                        </div>
                        <p>{{ $orderItem->user->username }}</p>
                        <p>{{ $orderItem->user->phone }}</p>
                        <p>{{ $orderItem->user->age }}</p>
                        <p class="price desktop">$ {{ number_format($orderItem->car->price, 2) }}</p>
                        <p class="quantity desktop">x{{ $orderItem->quantity }}</p>
                        <p class="cart-item-total desktop">$ {{ number_format($orderItem->car->price * $orderItem->quantity, 2) }}</p>
                    </div>
                    <hr>
                @endforeach
                </div>
            </div>

            <div class="order-summary p-4 col-lg-3 offset-lg-1 col-md-12">
                <h3 class="pb-3">Summary</h3>
                <div class="d-flex justify-content-between">
                    <h6>Subtotal</h6>
                    <p>$ {{ $subtotal = $activeOrder->getSubtotal() }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Discount</h6>
                    <p>$ {{ $discount = $activeOrder->getDiscount($subtotal) }}</p>
                </div>
                <div class="d-flex justify-content-between">
                    <h6>Tax (6%)</h6>
                    <p>$ {{ $tax = $activeOrder->getTax($subtotal, $discount) }}</p>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <h6>Total</h6>
                    <p>$ {{ $activeOrder->getTotal($subtotal, $discount, $tax) }}</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@if ($allOrders->count())
@if(!$activeOrder)
<div class="pt-18vh">
@endif
<section class="order-histories">
    <div class="container">
        <h2 class="mb-4">Previous Orders</h2>
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
                @foreach ($allOrders as $order)
                @if ($activeOrder && $activeOrder->id == $order->id)
                <tr class="table-active">
                @else
                <tr>
                @endif
                    <th scope="row"><a href="{{ route('specificOrder', $order->id) }}">#{{ $order->id }}</a></th>
                    <td>{{ $order->getOrderDate() }}</td>
                    <td>{{ $order->getOrderTime() }}</td>
                    <td>$ {{ $order->getTotalFromScratch() }}</td>
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
        <div class="row mt-md-4">
            <div class="col-12 flex-center">
                {{ $allOrders->links() }}
            </div>
        </div>
    </div>
</section>
@if(!$activeOrder)
</div>
@endif
@endif
@endsection