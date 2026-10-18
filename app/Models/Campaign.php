<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    // Define quais colunas podem ser preenchidas no momento da criação
    protected $fillable = [
        'creator_id',
        'title',
        'content',
        'topic',
    ];

    // Define que esta campanha pertence a um usuário (Admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}