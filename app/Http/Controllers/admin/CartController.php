<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\CartItem;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;


class CartController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function currencyFormat($number) {
        return number_format((float)$number, 2, '.', '');
    }

    // User requests to view their cart
    public function index() {
        if (auth()->user()->role != 'customer')
            abort(403, 'This route is only meant for customers.');
        
        $subtotal = 0;
        $cartItems = auth()->user()->cartItems->where('order_id', null);
        foreach($cartItems as $item) {
            $subtotal = $subtotal + ($item->car->price * $item->quantity);
        }
        
        return view('cart', compact('cartItems', 'subtotal')); 
    }

    // User adds to cart
    public function store(Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'This route is only meant for customers.');

        auth()->user()->cartItems()->create([
            'car_id' => $request->carID,
            'quantity' => 1,
            'order_id' =>$request->orderId,
        ]);

        return back()->with('success', "{$request->carName} added to cart.");
    }

    // User modifies the quantity of their cart item
    public function update(CartItem $cart, Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'This route is only meant for customers.');

        if ($request->cartAction == "-") {
            if ($cart->quantity > 1)
                $cart->quantity--;
            else {
                $dish = $cart->car->name;
                $cart->delete();
                return back()->with('success', "{$dish} deleted from cart.");
            }
        } else if ($request->cartAction == "+")
            $cart->quantity++;
        
        $cart->save();
        return back();
    }

    // User perform cart checkout
    public function checkout(Request $request) {
        if (auth()->user()->role != 'customer')
            abort(403, 'This route is only meant for customers.');
            
        $data = $this->validate($request, [
            'type' => ['required'], // order type (pickup / deliver)
            'dateTime' => ['required', 'after_or_equal:today'], // order date time (when the user wants to be served.)
        ]);

        $subtotal = 0;
        $cartItems = auth()->user()->cartItems->where('order_id', null);
        foreach($cartItems as $item) {
            $subtotal = $subtotal + ($item->car->price * $item->quantity);
        }

        $total = $subtotal;
        $discountID = -1;

        // Verify discount code
        if ($request->discountCode != "" and $request->discountCode != null) {
            $discountCode = strtoupper($request->discountCode);
            $usableDiscountCode =Discount::where("discountCode", $discountCode)->first();

            // If discount code exists
            if ($usableDiscountCode) {
                // If Available for use
                if (($usableDiscountCode->startDate <= Carbon::today()) and (($usableDiscountCode->endDate >= Carbon::today()))) {
                    // If the spending is less than minimum spend of the discount code, give error
                    if ($usableDiscountCode->minSpend > $subtotal) {
                        return redirect()
                            ->route('cart')
                            ->with('error', "You need to spend at least RM ".$usableDiscountCode->minSpend." in order to use this discount code.");
                    }

                    // Everything is okay. The discount code can be used.
                    $discountAmount = $subtotal * $usableDiscountCode->percentage/100;
                    if ($discountAmount > $usableDiscountCode->cap) {
                        $discountAmount = $usableDiscountCode->cap;
                    }
                    $total = $subtotal - $discountAmount;
                    $discountID = $usableDiscountCode->id;
                    
                } else {
                    return redirect()
                        ->route('cart')
                        ->with('error', "The discount code is unusable currently.");
                }
            } else {
                return redirect()
                    ->route('cart')
                    ->with('error', "The discount code doesn't exist.");
            }
        }

        // add tax of 6% to total amount
        $total = $this->currencyFormat($total * 1.06);

        // Create order
        $order = auth()->user()->orders()->create($data);
        
        // subtotal for now, it will be 'total' after discounting.
        return redirect()->route('processTransaction', ['transactionAmount' => $total, 'orderId' => $order->id, 'discountID' => $discountID]); 
    }
}
