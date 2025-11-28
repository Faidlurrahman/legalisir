<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('admins')->truncate(); // <--- tambahkan ini

        DB::table('admins')->insert([
            [
                'name' => 'Nazwahh Cantikkk',
                'email' => 'nazwah@gmail.com',
                'password' => Hash::make('sayangku'),
                'tempat_lahir' => 'Cirebon',
                'tanggal_lahir' => '2008-02-20',
                'jenis_kelamin' => 'P',
                'no_telepon' => '0819-1144-9507',
                'nip' => '198705122022032001',
                'alamat' => 'Jl. Siliwangi No. 1, Cirebon',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'tempat_lahir' => 'Jakarta',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'L',
                'no_telepon' => '081298765432',
                'nip' => '199001012022032002',
                'alamat' => 'Jl. Merdeka No. 2, Jakarta',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
