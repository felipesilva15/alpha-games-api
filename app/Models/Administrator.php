<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrator extends Model
{
    use HasFactory;

    protected $table = 'ADMINISTRADOR';
    protected $primaryKey = 'ADM_ID';
    protected $fillable = ['ADM_NOME', 'ADM_EMAIL', 'ADM_SENHA', 'ADM_ATIVO'];
    public $timestamps = false;

    public static function rules(): Array {
        return [
            'ADM_NOME' => 'string|required',
            'ADM_EMAIL' => 'string|email|unique:ADMINISTRADOR,ADM_EMAIL|required',
            'ADM_SENHA' => 'string|min:3|required',
            'ADM_ATIVO' => 'int|required'
        ];
    }
}
