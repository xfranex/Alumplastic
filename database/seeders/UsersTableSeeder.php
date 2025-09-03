<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Rol;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolAdmin = Rol::where('nombre_rol', 'administrador')->first();
        $rolEmpleado = Rol::where('nombre_rol', 'empleado')->first();

        User::truncate();
        // Usuario Administrador
        User::create([
            'name' => 'Paco',
            'email' => env('ADMIN_EMAIL'),
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'rol_id' => $rolAdmin->id,
        ]);

        // Usuario Empleado
        User::create([
            'name' => 'Empleado',
            'email' => env('EMPLOYEE_EMAIL'),
            'password' => bcrypt(env('EMPLOYEE_PASSWORD')),
            'rol_id' => $rolEmpleado->id,
        ]);
        
        $this->command->info('Usuarios creados!');
    }
}
