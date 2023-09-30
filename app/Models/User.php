<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'USUARIO';
    protected $primaryKey = 'USUARIO_ID';
    public $timestamps = false;

    protected $fillable = [
        'USUARIO_NOME',
        'USUARIO_EMAIL',
        'USUARIO_SENHA',
        'USUARIO_CPF'
    ];

    protected $hidden = [
        'USUARIO_SENHA'
    ];

    public function Orders() {
        return $this->hasMany('App\Models\Order', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function CartItems() {
        return $this->hasMany('App\Models\CartItem', 'USUARIO_ID', 'USUARIO_ID');
    }

    public function address() {
        return $this->hasOne(Address::class, 'USUARIO_ID', 'USUARIO_ID');
    }

    //Método para retornar um único objeto do endereço ativo do usuário
    public function activeAddress() {
        return $this->address()->where('ENDERECO_APAGADO', 0)->first();
    }
}
