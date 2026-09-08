<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'productId',
        'size',
        'color',
        'material',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'productId');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'product_variant_id');
    }
}