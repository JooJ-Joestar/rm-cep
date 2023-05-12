<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Endereco extends Model
{
    use HasFactory, SoftDeletes;
    
    /**
     * Atributos da tabela.
     */
    protected $fillable = [
        'rua',
        // Complemento é opcional.
        'complemento',
        'bairro',
        'numero',
        'cep',
        'cidade_id',
        'estado_id'
    ];

    /**
     * Permite a leitura dos campos de atribuição em massa por outros componentes.
     */
    public function getFillable() {
        return $this->fillable;
    }
}
