<?php

namespace Database\Seeders;

use App\Models\Carpinteria;
use Illuminate\Database\Seeder;

class CarpinteriasTableSeeder extends Seeder
{
    /**
     * Datos iniciales de carpinterías
     */
    public function run(): void
    {
        Carpinteria::truncate();
        foreach(self::$carpinterias as $carpinteria) {
            Carpinteria::create([
                'nombre' => $carpinteria['nombre']
            ]);
        }

        $this->command->info('Carpinterías creadas!');
    }

    //crearemos dos carpinterías
    private static $carpinterias = array(
        array('nombre' => 'PVC'),
        array('nombre' => 'ALUMINIO'),
    );
}
