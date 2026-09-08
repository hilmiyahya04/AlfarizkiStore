<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_reviews extends Model
{
    use HasFactory;
    protected $table = 'product_reviews';
    protected $fillable = [
        'userId',
        'productCode',
        'rating',
    ];

    // 🔹 Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    // 🔹 Relasi ke Product
    public function product()
    {
        return $this->belongsTo(Product::class, 'productCode', 'productCode');
    }
}
