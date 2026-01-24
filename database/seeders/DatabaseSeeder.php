<?php

namespace Database\Seeders;

use App\Models\Kategori;
use App\Models\Menu;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat Akun User (Admin, Kasir, Pemilik)
        User::create([
            'username' => 'admin',
            'password' => Hash::make('123456'),
            'role' => 'admin',
        ]);

        User::create([
            'username' => 'kasir',
            'password' => Hash::make('123456'),
            'role' => 'kasir',
        ]);

        User::create([
            'username' => 'pemilik',
            'password' => Hash::make('123456'),
            'role' => 'pemilik',
        ]);

        // 2. Buat Kategori
        $katMakanan = Kategori::create(['nama_kategori' => 'Makanan']);
        $katMinuman = Kategori::create(['nama_kategori' => 'Minuman']);

        // 3. Buat Menu Contoh
        Menu::create([
            'kategori_id' => $katMakanan->id_kategori,
            'nama_menu' => 'Nasi Goreng Spesial',
            'deskripsi' => 'Nasi goreng dengan telur dan ayam suwir',
            'harga' => 25000,
            'stok' => 100,
            'foto' => null, // Foto kosong dulu
            'is_available' => true,
        ]);

        Menu::create([
            'kategori_id' => $katMakanan->id_kategori,
            'nama_menu' => 'Mie Goreng Jawa',
            'deskripsi' => 'Mie goreng bumbu rempah jawa',
            'harga' => 22000,
            'stok' => 50,
            'foto' => null,
            'is_available' => true,
        ]);

        Menu::create([
            'kategori_id' => $katMinuman->id_kategori,
            'nama_menu' => 'Es Teh Manis',
            'deskripsi' => 'Teh manis dingin segar',
            'harga' => 5000,
            'stok' => 200,
            'foto' => null,
            'is_available' => true,
        ]);
    }
}
