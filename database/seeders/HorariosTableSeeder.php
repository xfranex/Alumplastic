<?php

namespace Database\Seeders;

use App\Models\Horario;
use Illuminate\Database\Seeder;

class HorariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Horario::truncate();
        foreach(self::$horarios as $horario) {
            Horario::create([
                'tipo' => $horario['tipo'],
                'activo' => $horario['activo'],
            ]);
        }

        $this->command->info('Horarios creados!');
    }

    private static $horarios = array(
        array('tipo' => 'laboral', 'activo' => 1),
        array('tipo' => 'vacaciones', 'activo' => 0),
    );
}
