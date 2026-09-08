<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product_order_track_histories extends Model
{
    use HasFactory;
    protected $table = 'product_order_track_histories';
    
    protected $fillable = [
        'orderId',
        'userId', // Jangan lupa tambahkan ini jika Anda menyimpan ID user yang menginput track hitory
        'status',
        'remarks',
    ];

    public function order()
    {
        return $this->belongsTo(Orders::class, 'orderId');
    }

    /**
     * Tambahkan relasi ini untuk mengatasi error
     */
    public function user()
    {
        // Ganti 'userId' dengan nama kolom foreign key user yang ada di tabel database Anda (misal: 'user_id' atau 'created_by')
        return $this->belongsTo(User::class, 'userId'); 
    }
}
