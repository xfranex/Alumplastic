<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if(User::count() == 0) {
            // Usuario Administrador
            User::create([
            'name' => 'Admin',
            'email' => env('ADMIN_EMAIL', 'alumplastic@alumplastic.com'),
            'password' => bcrypt(env('ADMIN_PASSWORD', 'alumplastic')),
            ]);
        }
        $this->command->info('¡Usuario administrador creado!');
    }
}
