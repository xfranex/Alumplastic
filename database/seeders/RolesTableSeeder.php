<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rol;

class RolesTableSeeder extends Seeder
{
    /**
     * Datos iniciales de roles
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
    
    //crearemos dos tipos de roles
    private static $roles = array(
        array('rol' => 'administrador'),
        array('rol' => 'empleado')
    );
    
}