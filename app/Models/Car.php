<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    public $timestamps = true;
    protected $fillable = [
        'type',
        'name',
        'description',
        'price',
        'image',
        'size',
        'normal',
        'special',
        'advance',
        
    ];

    public function cartItems() {
        return $this->hasMany(CartItem::class);
    }


}
