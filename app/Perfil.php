<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model
{
    //
    protected $fillable = [
        'biografia', 'imagen',
    ];
    // relacion 1:1 de Perfil a User, un perfil pertenece a un user
    public function user()
    {
        return $this->belongsTo(User::class);
        // Si por algun motivo la relacion no toma efecto se puede indicar manual mente sobre que campo se hará.
        // return $this->belongsTo(User::class, 'user_id');
    }
}
