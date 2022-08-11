<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    //
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        if (auth()->user()->role != 'admin')
            abort(403, 'This route is only meant for restaurant admins.');
        $discounts = Discount::all();
        return view('admin.discount', compact('discounts'));
    }

    public function createDiscount() {
        if (auth()->user()->role != 'admin')
            abort(403, 'This route is only meant for restaurant admins.');
        return view('admin.createDiscount');
    }

    private function validateDiscount(Request $request, $type) {
        if ($type == 'update')
            $discountCode = ['required', 'string', 'max:30'];
        else
            $discountCode = ['required', 'string', 'max:30', 'unique:App\Models\Discount'];

        $data = $this->validate($request, [
            'discountCode' => $discountCode,
            'percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'minSpend' => ['required', 'integer', 'min:0', 'max:9999'],
            'cap' => ['required', 'integer', 'min:1' ,'max:999'],
            'startDate' => ['required', 'after_or_equal:today'],
            'endDate' => ['required', 'after:startDate'],
            'description' => ['max:1000'],
        ]);
        return $data;
    }

    public function store(Request $request) {
        if (auth()->user()->role != 'admin')
            abort(403, 'This route is only meant for restaurant admins.');
        
        $data = $this->validateDiscount($request, '');
        $discount = Discount::create(array_merge(
            $data, ['discountCode' => strtoupper($data['discountCode'])]
        ));

        return redirect()->route('discount')->with('success', 
                "Discount code '{$discount->discountCode}' created successfully.");
    }

    public function specificDiscount(Discount $discount) {
        if (auth()->user()->role != 'admin')
            abort(403, 'This route is only meant for restaurant admins.');
        
        // Render a form thats prefilled with original details
        // For staffs to view / edit / delete the specific discount voucher
        return view('admin.editDiscount', compact('discount'));
    }

    public function update(Request $request, Discount $discount) {
        $data = $this->validateDiscount($request, 'update');
        $discount->update(array_merge(
            $data, ['discountCode' => strtoupper($data['discountCode'])]
        ));
        
        return redirect()->route('discount')->with('success', 
                "Discount code '{$discount->discountCode}' updated successfully.");
    }

    public function destroy(Discount $discount) {
        $discountCode = $discount->discountCode;
        $discount->delete();
        return redirect()->route('discount')->with('success', 
                "Discount code '{$discountCode}' deleted successfully.");
    }
}
