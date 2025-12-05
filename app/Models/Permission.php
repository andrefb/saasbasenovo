<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'key',
        'name',
        'category',
        'description',
    ];

    // Nenhuma relação complexa necessária aqui,
    // pois os Roles guardam as keys diretamente no JSON.
}
