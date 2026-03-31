<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * La tabla asociada al modelo.
     */
    protected $table = 'usuarios';

    /**
     * Desactivar timestamps.
     */
    public $timestamps = false;

    /**
     * La clave primaria.
     */
    protected $primaryKey = 'id';

    /**
     * Los atributos que son asignables masivamente.
     */
    protected $fillable = [
        'username',
        'password',
        'rol',
        'nombre',
    ];

    /**
     * Los atributos ocultos para serialización.
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Sin casts — el password ya está hasheado en la BD.
     */
    protected $casts = [];
}
