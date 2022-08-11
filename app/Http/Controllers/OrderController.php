<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function __construct() {
        return $this->middleware('auth');
    }

    public function index() { // Cust regular order page
        $activeOrder = auth()->user()->orders()->where('completed', 0)->orderBy('dateTime', 'desc')->first();
        $allOrders = auth()->user()->orders()->orderBy('dateTime', 'desc')->paginate(8);
        return view('order', compact('activeOrder', 'allOrders'));
    }

    public function show(Order $order) { // Customer specific order page
        $activeOrder = $order;
        $allOrders = auth()->user()->orders()->orderBy('dateTime', 'desc')->paginate(8);
        return view('order', compact('activeOrder', 'allOrders'));
    }

    public function kitchenOrder() { // Kitchen or Admin's order page
        if (auth()->user()->role == 'customer')
            abort(403, 'This route is only meant for restaurant staffs.');

        $activeOrders = Order::where('completed', 0)->orderBy('dateTime', 'desc')->paginate(8);
        $firstOrder = $activeOrders->first();
        return view('kitchenOrder', compact('firstOrder', 'activeOrders'));
    }

    public function specificKitchenOrder(Order $order) { // Kitchen or Admin's specific order page
        if (auth()->user()->role == 'customer')
            abort(403, 'This route is only meant for restaurant staffs.');

        $activeOrders = Order::where('completed', 0)->orderBy('dateTime', 'desc')->paginate(8);
        $firstOrder = $order;
        return view('kitchenOrder', compact('firstOrder', 'activeOrders'));
    }

    public function orderStatusUpdate(CartItem $orderItem) { // Kitchen or Admin update order status
        if (auth()->user()->role == 'customer')
            abort(403, 'This route is only meant for restaurant staffs.');

        $orderItem->fulfilled = $orderItem->fulfilled ? false : true;
        $orderItem->save();

        $cartItems = CartItem::where('order_id', $orderItem->order_id)->paginate(8);
        foreach ($cartItems as $item) {
            if (!$item->fulfilled)
                return redirect()->route('kitchenOrder');
        }
        $orderItem->order->completed = true;
        $orderItem->push();
        return redirect()->route('kitchenOrder');
    }

    public function previousOrder() { // Kitchen or Admin view all previous orders
        if (auth()->user()->role == 'customer')
            abort(403, 'This route is only meant for restaurant staffs.');

        // this is actually 'previousOrders' not 'activeOrders', but i name it this way 
        // just for the blade's variable naming sake
        $previousOrders = Order::where('completed', 1)->orderBy('dateTime', 'desc')->paginate(8);
        return view('previousOrder', compact('previousOrders'));
    }
}
