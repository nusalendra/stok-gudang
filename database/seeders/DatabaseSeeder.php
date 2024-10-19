<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

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
    }
}
