<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $primaryKey = 'id_item';

    protected $fillable = [
        'order_id',
        'menu_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
        'catatan_khusus',
    ];

    // Relasi: Item milik satu Order
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id_order');
    }

    // Relasi: Item adalah satu Menu
    public function menu()
    {
        return $this->belongsTo(Menu::class, 'menu_id', 'id_menu');
    }
}
