<?php

namespace Database\Seeders;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Model::unguard(); //permite insertar datos masivamente sin restricciones de asignación masiva
        Schema::disableForeignKeyConstraints(); //deshabilita claves foráneas temporalmente

        $this->call(RolesTableSeeder::class); //ejecuta el seeder encargado de poblar la tabla roles
        $this->call(UsersTableSeeder::class); //ejecuta el seeder encargado de poblar la tabla users
        $this->call(CarpinteriasTableSeeder::class); //ejecuta el seeder encargado de poblar la tabla carpinterías
        $this->call(HorariosTableSeeder::class); //ejecuta el seeder encargado de poblar la tabla horarios
        $this->command->info('Tablas inicializadas con datos!'); //mensaje que sale cuando se completan los seeders

        Model::reguard(); //vuelve a activar la protección de asignación masiva
        Schema::enableForeignKeyConstraints(); //reactiva las restricciones de claves foráneas
    }
}
