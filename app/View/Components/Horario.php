<?php

namespace App\View\Components;

use App\Models\Horario as ModeloHorario;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Horario extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Componente que devuelve la vista de la sección de horarios con toda la información necesaria de la bbdd
     */
    public function render(): View|Closure|string
    {
        $horario = ModeloHorario::where('activo', '=','1')->first();
        return view('components.horario', ['horario' => $horario]);
    }
}
