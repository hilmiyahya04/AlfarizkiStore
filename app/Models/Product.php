<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $table = 'product';
    protected $fillable = [
        'productCode',
        'productName',
        'productCompany',
        'productPrice',
        'productImage1',
        'productImage2',
        'productImage3',
        'productAvailability',
        'postingDate',
        'categoryId'
    ];

    public function index()
    {
        $products = Product::all();

        return view('cart', compact('products'));
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(categories::class, 'categoryId', 'id');
    }

    public function variants()
    {
    return $this->hasMany(ProductVariant::class, 'productId');
    }

    public function reviews()
    {
        return $this->hasMany(product_reviews::class, 'productCode', 'productCode');
    }
}
