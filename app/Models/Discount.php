<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discountCode', 'percentage', 'minSpend', 'cap',
        'startDate', 'endDate', 'description',
    ];

    // discount can be used in many transactions
    public function transactions() {
        return $this->hasMany(Transaction::class);
    }
}
