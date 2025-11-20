<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class GuestLayout extends Component
{
    /**
     * Componente que devuelve la vista que contiene la estructura base del área de login
     * Para llamarlo tenemos que usar kebak-case (x-app-layout), las variables llegan automáticamente, todo el contenido
     * dentro de la etiqueta del componente se inyecta en $slot y cualquier <x-slot name="header"> se inyecta en $header dentro de la vista
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
