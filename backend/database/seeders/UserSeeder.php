<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();
        $data = [
            'name' => 'Renato Lucena',
            'email' => 'admin@example.com',
            'password' => Hash::make('1234567890'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(10),
            'is_active' => 1

        ];
        User::create($data);

        // Testing Dummy User
        User::factory(20)->create();
    }
}
