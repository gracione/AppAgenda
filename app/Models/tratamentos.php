<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tratamentos extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'valor',
    ];

    use HasFactory;
}
