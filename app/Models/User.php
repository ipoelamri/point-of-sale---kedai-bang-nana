<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kasih tahu Laravel kalau Primary Key kita bukan 'id', tapi 'id_user'
    protected $primaryKey = 'id_user';

    protected $fillable = [
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    // Relasi: Satu kasir bisa menangani banyak order (Tabel 3.7 ERD)
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id_kasir', 'id_user');
    }
}
