<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cuenta extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'email',
        'password_hash',
        'telefono',
        'fecha_registro',
    ];

    protected $hidden = [
        'password_hash',
    ];

    protected function casts(): array
    {
        return [
            'fecha_registro' => 'date',
        ];
    }
}
