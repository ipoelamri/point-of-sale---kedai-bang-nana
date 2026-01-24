<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $primaryKey = 'id_kategori';

    protected $fillable = ['nama_kategori'];

    // Relasi: Satu kategori punya banyak menu
    public function menus()
    {
        return $this->hasMany(Menu::class, 'kategori_id', 'id_kategori');
    }
}
