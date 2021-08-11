<?php
namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'iduser' => '160718035',
            'nama' => 'Admin Admin',
            'email' => 'admin1@argon.com',
            'email_verified_at' => now(),
            'password' => Hash::make('secret'),
            'jabatan' => '1'
        ]);
    }
}
