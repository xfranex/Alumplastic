<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::truncate();
        foreach (self::$roles as $rol) {
            Rol::create([
                'nombre_rol' => $rol['rol']
            ]);
        }

        $this->command->info('Roles creados!');
    }
    
    private static $roles = array(
        array('rol' => 'administrador'),
        array('rol' => 'empleado')
    );
    
}