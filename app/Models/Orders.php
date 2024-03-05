<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'tanggal_pemesanan',
        'status_pembayaran',
        'status_pengiriman',
    ];

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrdersDetail::class);
    }
}
