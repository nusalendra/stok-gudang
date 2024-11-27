<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Barang;
use App\Models\Karyawan;
use App\Models\Supplier;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(30)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::create([
            'email' => 'budisetyo@gmail.com',
            'password' => 'password',
            'role' => 'Admin'
        ]);

        User::create([
            'email' => 'laskarpelangi@gmail.com',
            'password' => 'password',
            'role' => 'Karyawan'
        ]);

        Karyawan::create([
            'user_id' => 2,
            'nama_lengkap' => 'Laskar Pelangi',
            'jenis_kelamin' => 'Perempuan',
            'umur' => 17,
            'nomor_telepon' => '089677888764'
        ]);

        Supplier::create([
            'nama' => 'PT Sepatu Jaya',
            'alamat' => 'Jl. Jakarta No. III',
            'nomor_telepon' => '089618291729'
        ]);

        // Barang::create([
        //     'nama' => 'Carvil',
        //     'ukuran' => 28,
        //     'warna' => 'Hitam',
        //     'harga_beli' => 160000,
        //     'harga_jual' => 192000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Ardiles',
        //     'ukuran' => 23,
        //     'warna' => 'Putih',
        //     'harga_beli' => 140000,
        //     'harga_jual' => 168000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Futsal',
        //     'ukuran' => 43,
        //     'warna' => 'Biru',
        //     'harga_beli' => 200000,
        //     'harga_jual' => 240000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Vans',
        //     'ukuran' => 34,
        //     'warna' => 'Hitam',
        //     'harga_beli' => 180000,
        //     'harga_jual' => 216000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Luberend',
        //     'ukuran' => 28,
        //     'warna' => 'Biru',
        //     'harga_beli' => 130000,
        //     'harga_jual' => 156000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Pro Att',
        //     'ukuran' => 37,
        //     'warna' => 'Hitam',
        //     'harga_beli' => 150000,
        //     'harga_jual' => 180000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Rajut Sport',
        //     'ukuran' => 33,
        //     'warna' => 'Putih',
        //     'harga_beli' => 190000,
        //     'harga_jual' => 228000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Walked',
        //     'ukuran' => 41,
        //     'warna' => 'Hitam',
        //     'harga_beli' => 160000,
        //     'harga_jual' => 192000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);

        // Barang::create([
        //     'nama' => 'Xavier',
        //     'ukuran' => 35,
        //     'warna' => 'Hitam',
        //     'harga_beli' => 120000,
        //     'harga_jual' => 144000,
        //     'stok' => 10,
        //     'tanggal_expired' => 2024 - 10 - 31
        // ]);
    }
}
