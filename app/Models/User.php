<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    //campos que pueden asignarse de forma masiva
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol_id',
    ];

    /**
     * Campos que deben ocultarse al serializar el modelo
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Define los casts de atributos para conversión automática
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //un usuario pertenece a un rol
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }

    //verifica si el usuario tiene rol administrador
    public function isAdmin()
    {
        return $this->rol && $this->rol->nombre_rol === 'administrador';
    }
    
    //verifica si el usuario tiene rol empleado
    public function esEmpleado()
    {
        return $this->rol && $this->rol->nombre_rol === 'empleado';
    }
}
