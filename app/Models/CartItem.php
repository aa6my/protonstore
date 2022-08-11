<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'car_id',
        'order_id',
        'quantity',
        'fulfilled',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function car() {
        return $this->belongsTo(Car::class);
    }

    public function order() {
        return $this->belongsTo(Order::class);
    }
}
