<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class funcionarios extends Model
{
    protected $fillable = [
        'id',
        'nome',
        'email',
        'senha',
        'numero',
        'tipo',
    ];
    use HasFactory;
}
