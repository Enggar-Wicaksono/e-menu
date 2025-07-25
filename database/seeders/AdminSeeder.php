<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use function Laravel\Prompts\password;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'logo' => 'default.jpg',
            'name' =>'Admin Emenu',
            'username' => 'admin',
            'email' => 'admin@emenu.com',
            'password' =>bcrypt('12345'),
            'role' => 'admin'
        ]);
    }
}
