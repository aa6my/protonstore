<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use App\Models\Order;
use App\Models\Discount;

class PayPalController extends Controller
{

    // only authenticated users are allowed to use this controller.
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * process transaction. checkout of cart leads to here.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function processTransaction(Request $request, float $transactionAmount, int $orderId, int $discountID)
    {

        if ($transactionAmount < 0)
        {
            // Transaction failed, delete the created order.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()->route('cart')->with('error', 'Transaction amount must be more than RM 0.');
        }

        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('successTransaction', [$transactionAmount, $orderId, $discountID]),
                "cancel_url" => route('cancelTransaction', $orderId),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "MYR",
                        "value" => $transactionAmount
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {

            // redirect to approve href
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            // Transaction failed, delete the created order.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', 'Something went wrong.');

        } else {

            // Transaction failed, delete the created order.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    /**
     * success transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function successTransaction(Request $request, float $transactionAmount, int $orderId, int $discountID)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (isset($response['status']) && $response['status'] == 'COMPLETED') {

            $order = Order::where('id',$orderId)->first();
            
            // Transaction succeed, empty the cart.
            $carts = auth()->user()->cartItems()->where('order_id', null)->get();
            foreach($carts as $cart) {
                $cart->order()->associate($order);
                $cart->save();
            }

            // Create Transaction object
            $order->transaction()->create(['final_amount'=>$transactionAmount]);
            if ($discountID != -1) {
                $discount = Discount::where("id", $discountID)->first();
                $order->transaction->discount()->associate($discount);
                $order->transaction->save();
            }

            return redirect()
                ->route('cart')
                ->with('success', 'Transaction complete.');
        } else {

            // Transaction failed, delete the created order.
            $order = Order::where('id',$orderId)->first()->delete();

            return redirect()
                ->route('cart')
                ->with('error', 'Something went wrong.');
        }
    }

    /**
     * cancel transaction.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelTransaction(Request $request, int $orderId)
    {

        // Transaction failed, delete the created order.
        $order = Order::where('id',$orderId)->first()->delete();

        return redirect()
            ->route('cart')
            ->with('error', 'You have canceled the transaction.');
    }
}
