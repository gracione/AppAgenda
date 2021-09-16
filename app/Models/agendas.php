<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class agendas extends Model
{
    protected $fillable =[
        'id',
        'idCliente',
        'idFuncionario',
        'tipo',
        'data',
        'descricao',
        'nome',
        'telefone',
    ];  
    use HasFactory;
}
