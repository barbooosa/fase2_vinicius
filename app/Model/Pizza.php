<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pizza extends Model
{
    use HasFactory;

    protected $fillable = [
        'sabor',
        'descricao',
        'preco',
        'status',
        'created_at',
        'updated_at',
    ];
}
