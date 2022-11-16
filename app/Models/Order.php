<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table="orders";

    protected $fillable =[
        'id',
        'amount',
        'status',
        'product_id',
        'store_id'
    ];

    public $timestamps= false;

}