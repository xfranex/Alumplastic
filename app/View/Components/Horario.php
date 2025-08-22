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
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $horario = ModeloHorario::where('activo', '=','1')->first();
        return view('components.horario', ['horario' => $horario]);
    }
}
