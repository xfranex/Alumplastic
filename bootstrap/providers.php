<?php
//devuelve un array con la lista de Service Providers que Laravel cargará automáticamente al iniciar la aplicación
return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    App\Providers\RouteServiceProvider::class,
];
