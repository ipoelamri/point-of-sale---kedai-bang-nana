<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $primaryKey = 'id_order';

    protected $fillable = [
        'no_order',
        'nama_pelanggan',
        'total_bayar',
        'tipe_pesanan',
        'no_meja',
        'status_order',
        'user_id_kasir',
    ];

    // Relasi: Order punya banyak item (detail pesanan)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id_order');
    }

    // Alias untuk items (untuk backward compatibility)
    public function items()
    {
        return $this->orderItems();
    }

    // Relasi: Order punya satu pembayaran (Tabel 3.7 ERD)
    public function pembayaran()
    {
        return $this->hasOne(Pembayaran::class, 'order_id', 'id_order');
    }

    // Relasi: Order dilayani oleh satu kasir (User)
    public function kasir()
    {
        return $this->belongsTo(User::class, 'user_id_kasir', 'id_user');
    }
}
