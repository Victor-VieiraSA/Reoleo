<?php

namespace App\Models;

use CodeIgniter\Model;

class UsuarioModel extends Model
{
    protected $table         = 'usuarios';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $useTimestamps = false; // `criado_em` é preenchido pelo próprio banco

    protected $allowedFields = [
        'perfil',
        'razao_social',
        'cpf_cnpj',
        'telefone',
        'email',
        'senha',
        'endereco',
        'numero',
        'bairro',
        'municipio',
        'cep',
        'referencia',
    ];
}
