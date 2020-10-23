<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Receta extends Model
{
    protected $fillable = [
        'titulo', 'ingredientes', 'preparacion', 'imagen', 'categoria_id',
    ];

    // Relación 1:n de Receta a Categoria_receta
    // Obtiene la categoria de la receta via FK
    public function categoria()
    {
        // una receta pertenece a una categoria 1:1 inversa
        return $this->belongsTo(Categoria_receta::class);
    }
    public function user()
    {
        // una receta pertenece a un user 1:1 inversa
        return $this->belongsTo(User::class);
    }

    // Likes que ha recibido una receta
    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_receta');
    }

}
