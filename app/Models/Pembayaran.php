<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'order_id',
        'snap_token',
        'metode_bayar',
        'status_bayar',
        'midtrans_log',
        'waktu_bayar',
    ];

    protected $casts = [
        'waktu_bayar' => 'datetime',
    ];

    // Relasi: Pembayaran milik satu Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_order');
    }
}
