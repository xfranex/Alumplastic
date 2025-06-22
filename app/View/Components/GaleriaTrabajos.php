<?php

namespace App\View\Components;

use App\Models\Carpinteria;
use App\Models\Trabajo;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class GaleriaTrabajos extends Component
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
        $carpinterias = Carpinteria::has('trabajos')->get();
        $trabajos = Trabajo::with('carpinteria')->get();
        return view('components.galeria-trabajos', ['carpinterias' => $carpinterias, 'trabajos' => $trabajos]);
    }
}
