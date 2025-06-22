<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Trabajo extends Model
{
    protected $fillable = [
        'imagen',
        'carpinteria_id'
    ];

    public function carpinteria()
    {
        return $this->belongsTo(Carpinteria::class);
    }
}
