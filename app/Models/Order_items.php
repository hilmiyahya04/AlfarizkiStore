<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_items extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'qty',
        'price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function order()
    {
        return $this->belongsTo(orders::class, 'order_id');
    }
}
