<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;
    protected $table="orders_products";

    protected $fillable =[
        'id',
        'amount',
        'product_id',
        'order_id',
    ];

    public $timestamps= false;

    
}
