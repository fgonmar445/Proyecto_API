<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    protected $fillable = [
        'user_id',
        'nombre',
        'edad',
        'especie',
        'peso',
        'vacunado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
