<?php

use App\Http\Controllers\admin\AccountCreationController;
use App\Http\Controllers\admin\CartController;
use App\Http\Controllers\admin\DashboradController;
use App\Http\Controllers\admin\DiscountController;
use App\Http\Controllers\admin\CarController;
use App\Http\Controllers\auth\RegisterUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PayPalController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


require __DIR__.'/auth.php';

Route::get('/', [HomeController::class,'index'])->name('home');

Route::post('create-account',[RegisterUserController::class,'store'])->name('valdite_user');

//dashboard
Route::get('/dashboard', [DashboradController::class, 'index'])->name('dashboard');
// Account Creation
Route::get('/account/create', [AccountCreationController::class, 'create'])->name('createAccount');
Route::post('/account/create', [AccountCreationController::class, 'store'])->name('accountStoring');
// Car
Route::get('/car/filter?carType=', [CarController::class, 'index'])->name('car');
Route::post('/car/saveCarItem', [CarController::class, 'store'])->name('saveCarItem');
Route::get('/car/delete/{id}', [CarController::class, 'delete'])->name('deleteCarItem');
Route::get('/car/editCarDetails/{id}', [CarController::class, 'showDetails'])->name('showCarDetails');
Route::get('/car/editCarImages/{id}', [CarController::class, 'showImages'])->name('showCarImages');
Route::post('/car/updateDetails', [CarController::class, 'updateDetails'])->name('updateCarDetails');
Route::post('/car/updateImages', [CarController::class, 'updateImages'])->name('updateCarImages');
Route::get('/car/filter', [CarController::class, 'filter'])->name('filterCar');


// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart');
Route::post('/cart/create', [CartController::class, 'store'])->name('addToCart');
Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cartUpdate');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cartCheckout');

// Discount
Route::get('/discount', [DiscountController::class, 'index'])->name('discount');
Route::get('/discount/create', [DiscountController::class, 'createDiscount'])->name('createDiscount');
Route::post('/discount/create', [DiscountController::class, 'store']);
Route::get('/discount/{discount}', [DiscountController::class, 'specificDiscount'])->name('specificDiscount');
Route::delete('/discount/delete/{discount}', [DiscountController::class, 'destroy'])->name('discountDestroy');
Route::post('/discount/{discount}', [DiscountController::class, 'update'])->name('discountUpdate');

// Order
Route::get('/order', [OrderController::class, 'index'])->name('order');
Route::get('/order/{order}', [OrderController::class, 'show'])->name('specificOrder');
Route::get('/staff/order', [OrderController::class, 'carOrder'])->name('carOrder');
Route::get('/staff/order/{order}', [OrderController::class, 'specificcarOrder'])->name('specificcarOrder');
Route::put('/staff/order/update/{orderItem}', [OrderController::class, 'orderStatusUpdate'])->name('orderStatusUpdate');
Route::get('/staff/previous-order', [OrderController::class, 'previousOrder'])->name('previousOrder');

// PayPal
Route::get('/process-transaction/{transactionAmount}/{orderId}/{discountID}', [PayPalController::class, 'processTransaction'])->name('processTransaction');
Route::get('/success-transaction/{transactionAmount}/{orderId}/{discountID}', [PayPalController::class, 'successTransaction'])->name('successTransaction');
Route::get('/cancel-transaction/{orderId}', [PayPalController::class, 'cancelTransaction'])->name('cancelTransaction');

