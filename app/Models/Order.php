<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    
    public function order_address()
    {
        return $this->belongsTo(UserAddress::class, 'order_address');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user');
    }
}
