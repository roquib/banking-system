<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        if ($users->count() == 0) {
            User::create([
                'name' => 'Abdur roquib',
                'email' => 'roquib01@gmail.com',
                "password" => Hash::make(123456789),
            ]);
        }
    }
}
