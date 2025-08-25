<?php

namespace App\Providers;

use App\Models\Carpinteria;
use App\Models\Consulta;
use App\Models\Horario;
use App\Models\Producto;
use App\Models\Serie;
use App\Models\Trabajo;
use App\Models\User;
use App\Policies\CarpinteriaPolicy;
use App\Policies\ConsultaPolicy;
use App\Policies\HorarioPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\SeriePolicy;
use App\Policies\TrabajoPolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Consulta::class => ConsultaPolicy::class,
        Carpinteria::class => CarpinteriaPolicy::class,
        Producto::class => ProductoPolicy::class,
        Serie::class => SeriePolicy::class,
        Trabajo::class => TrabajoPolicy::class,
        Horario::class => HorarioPolicy::class,
        User::class => UserPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        
    }
}