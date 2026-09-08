<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    use HasFactory;

    // Daftarkan user_id agar bisa disimpan otomatis oleh Listener
    protected $fillable = [
        'user_id',
        'product_id',
        'product_variant_id',
        'quantity',
    ];

    /**
     * Hubungan relasi ke User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Hubungan relasi ke Product (disesuaikan dengan Model Product Anda)
     */
    public function product(): BelongsTo
    {
        // Pastikan nama model Anda adalah 'Product'
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

}
