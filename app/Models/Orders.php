<?php

namespace App\Models;

use App\Policies\product_order_track_historiesPolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
    protected $fillable = [
    'userId',
    'orderDate',
    'paymentMethod',
    'orderStatus',
    'id_pemesanan',
    'total_price',
    'recipient_name',
    'phone_number',
    'province',
    'city',
    'district',
    'postal_code',
    'street_address',
    'address_detail',
    'address_label',
    ];
    public function items()
    {
        return $this->hasMany(order_items::class, 'order_id');
    }

    public function tracking()
    {
        return $this->hasMany(product_order_track_histories::class, 'orderId');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function refunds()
    {
        return $this->hasMany(Refund::class, 'order_id');
    }

    public function returns()
    {
        return $this->hasManyThrough(
            ReturnModel::class,
            order_items::class,
            'order_id',
            'order_item_id',
            'id',
            'id'
        );
    }
}
