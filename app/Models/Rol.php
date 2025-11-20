<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    //nombre de la tabla asociada al modelo
    protected $table = 'roles';

    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'nombre_rol',
    ];

    //un rol puede tener muchos usuarios
    public function usuarios()
    {
        return $this->hasMany(User::class, 'rol_id', 'id');
    }
}
